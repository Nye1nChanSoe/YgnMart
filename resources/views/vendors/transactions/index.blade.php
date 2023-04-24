<x-vendor-layout>
    <x-slot:title>
        Manage transactions - YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.dashboard') }}" class="{{ request()->routeIs('vendor.dashboard') ? 'text-blue-700' : 'text-gray-700' }} hover:text-blue-600">Dashboard</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.transactions') }}" class="{{ request()->routeIs('vendor.transactions') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Transactions</a>
        </li>
    </ul>

    <section class="mt-4 px-3 py-3 shadow rounded-lg">
        <div class="flex justify-between items-center mt-2 mb-4">
            <h1 class="text-xl text-black font-medium">
                Transactions
            </h1>
        </div>
        @unless ($transactions->isEmpty())
        <div class="relative overflow-x-auto shadow rounded">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Order Code
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Payment
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Currency
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Revenue
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Net Revenue
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Time
                        </th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($transactions as $transaction)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100">
                        <td class="px-6 py-2">
                            <div>{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</div>
                        </td>
                        <td class="px-6 py-4 text-purple-700">
                            {{ strtoupper($transaction->order->order_code) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ ucwords($transaction->payment_type) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ strtoupper($transaction->currency) }}
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                {{ ($transaction->gross_amount) }}
                                <span class="text-red-400 text-[10px]">-{{ $transaction->tax }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-900">
                            {{ number_format($transaction->net_revenue, 0, '.', ',') }}
                            <span class="ml-1 text-xs text-gray-400">Kyat</span>
                        </td>
                        <td class="px-6 py-4 text-green-600">
                            {{ $transaction->status }}
                        </td>
                        <td class="px-6 py-4">
                            <time>{{ $transaction->order->created_at->format('M d Y g:i A') }}</time>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="flex items-center justify-center w-full h-60">
            <p class="text-gray-400">You do not have any transactions yet!</p>
        </div>
        @endunless
        <div class="text-sm mt-4">
            {{ $transactions->links('vendor.pagination.links') }}
        </div>

    </section>
</x-vendor-layout>