<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Traits\ProductAnalyticTrait;
use App\Traits\StripePaymentTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    use StripePaymentTrait, ProductAnalyticTrait;

    public function show(Order $order)
    {
        try 
        {
            $order = Order::with('products')->where('user_id', auth()->id())->where('order_code', $order->order_code)->firstOrFail();
            return view('orders.show', compact('order'));
        } 
        catch (ModelNotFoundException $e) 
        {
            return redirect()->back()->with('error', 'Invalid URL');
        }
    }

    /** 
    * client-side AJAX request send JSON payload in the Request body
    * retrieve the $request using $request->json()
    */
    public function store(Request $request)
    {
        try 
        {
            $order = $this->processOrder($request);
            return response()->json([
                'message' => 'Order created successfully',
                'order_code' => $order->order_code,
            ]);
        } 
        catch(Exception $e) 
        {
            return response()->json([
                'message' => 'Order failed stock unavailable',
                'status' => 'fail'
            ]);
        }   
    }

    public function success(Request $request)
    {
        try 
        {
            $order = Order::where('order_code', $request->input('order'))
                ->where('user_id', auth()->id())
                ->firstOrFail();
            return view('orders.success', compact(['order']));
        } 
        catch (ModelNotFoundException $e) 
        {
            return redirect()->route('home');
        }
    }

    /**
     * Process the order based on the payment method
     * 
     * @param string $paymentMethod
     * @return Order
     */
    protected function processOrder(Request $request) 
    {
        $productIdArray = explode(",", $request->json('form_data.products'));
        $quantityArray = explode(",", $request->json('form_data.quantities'));
        $paymentMethod = $request->json('form_data.payment_method');

        /** check for the availability of the product in the inventory table */
        $this->updateStockOrFail($productIdArray, $quantityArray);

        $order = new Order();
        $order->order_code = 'c' . Carbon::now()->format('yds') . strtolower(Str::random('3'));
        $order->user_id = auth()->id();
        $order->total_price = $request->json('form_data.total_amount');
        $order->description = 'Payment test description';
        
        if($paymentMethod == 'cash')
        {
            $order->payment_type = $paymentMethod;
            $this->cancelPayment($request->json('payment_intent_id'));
        }
        if($paymentMethod == 'card')
        {
            $order->payment_intent_id = $request->json('payment_intent_id');
            $order->payment_type = $paymentMethod;
        }

        $order->save();
        
        for($i = 0; $i < count($productIdArray); ++ $i)
        {
            $records[$productIdArray[$i]] = ['quantity' => $quantityArray[$i]];
        }

        /** create order_product records */
        $order->products()->attach($records);

        /** update analytics */
        $this->productStats($productIdArray, $quantityArray);

        /** create transaction records */
        $this->createTransaction($order);

        return $order;
    }

    /**
     * update the items from the inventory table
     * 
     * @param array $ids - array of product id
     * @param array $quantities - array of purchased product quantities
     */
    protected function updateStockOrFail($ids, $quantities)
    {
        $products = Product::with('inventory')->whereIn('id', $ids)->get();

        foreach($products as $index => $product)
        {
            $inventory = $product->inventory;
            if($inventory->available_quantity >= $quantities[$index])
            {
                $inventory->available_quantity = $inventory->available_quantity - $quantities[$index];
                $inventory->in_stock_quantity = $inventory->in_stock_quantity - $quantities[$index];
                $inventory->save();
            }
            else 
            {
                throw new Exception('Not enough stock items');
            }
        }
    }

    /**
     * @param array $ids - array of product id
     * @param array $quantities - array of purchased quantities in same order as product ids
     */
    protected function productStats($ids, $quantities)
    {
        $products = Product::whereIn('id', $ids)->get();
        foreach($products as $index => $product)
        {
            $this->dailyProductStats($product, 'order', [
                'quantity' => $quantities[$index], 
                'revenue' => $quantities[$index] * $product->price,
            ]);
        }
    }

    // TODO: implement with queues and event listener in the future
    protected function createTransaction($order)
    {
        try {
            foreach ($order->products as $product) {
                $transaction = new Transaction();
                $transaction->user_id = $order->user_id;
                $transaction->vendor_id = $product->inventory->vendor->id;
                $transaction->transaction_type = $order->payment_intent_id ? 'card' : 'cash';
                $transaction->gross_amount = $product->price;
                $transaction->tax = $product->price * 0.1;
                $transaction->other_fees = 0;
                $transaction->status = 'succeed';   // pending, refund, succeed
                $transaction->save();
            }
        } catch(Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
