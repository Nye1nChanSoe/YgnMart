<x-vendor-layout>
    <section class="px-3 py-3 mt-6 rounded">
        <div class="text-gray-700">
            <div class="rounded shadow px-5 py-3">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h1 class="text-lg font-medium">Total Transactions</h1>
                        <div class="mt-1.5">
                            <span class="text-5xl text-green-600 font-medium">{{ number_format($transactionData->reduce(fn($total, $value) => $total += $value), 0, '.', ',') }}</span>
                            <span class="text-gray-500 font-normal text-sm">Kyat</span>
                        </div>
                    </div>
                    <div class="text-gray-500 text-sm">
                        Today <span>{{ now()->format('d M Y') }}</span>
                    </div>
                </div>

                <!-- Total Transactions -->
                <div>
                    <div class="bg-white px-3 py-5 h-[320px] md:h-[420px]">
                        <canvas id="transactions-chart"></canvas>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <div class="flex gap-x-4">
                    <div class="w-1/4 shadow py-2 px-4 rounded">
                        <div class="mt-2.5">
                            <span class="text-4xl text-green-600 font-medium">{{ number_format($transactions->reduce(fn($total, $object) => $total += $object->net_revenue), 0, '.', ',') }}</span>
                            <span class="text-gray-500 font-normal text-sm">Kyat</span>
                        </div>
                        <h1 class="mt-4 font-medium text-lg">Total Net Profit</h1>
                        <div class="mt-1 text-xs text-gray-500">After tax deduction</div>
                    </div>
                    <div class="w-1/4 shadow py-2 px-4 rounded">
                        <div class="mt-2.5">
                            <span class="text-4xl text-yellow-400 font-medium">{{ number_format($viewData->reduce(fn($total, $value) => $total += $value), 0, '.', ',') }}</span>
                        </div>
                        <h1 class="mt-4 font-medium text-lg">Total Views</h1>
                        <div class="mt-1 text-xs text-gray-500">Total number of time your products have been viewed</div>
                    </div>
                    <div class="w-1/4 shadow py-2 px-4 rounded">
                        <div class="mt-2.5">
                            <span class="text-4xl text-blue-600 font-medium">{{ number_format($orderData->reduce(fn($total, $value) => $total += $value), 0, '.', ',') }}</span>
                        </div>
                        <h1 class="mt-4 font-medium text-lg">Total Orders</h1>
                        <div class="mt-1 text-xs text-gray-500">Total number of time your products have been ordered</div>
                    </div>
                    <div class="w-1/4 shadow py-2 px-4 rounded">
                        <div class="mt-2.5">
                            <span class="text-4xl text-purple-700 font-medium">{{ number_format($quantityData->reduce(fn($total, $value) => $total += $value), 0, '.', ',') }}</span>
                        </div>
                        <h1 class="mt-4 font-medium text-lg">Total Item Sales</h1>
                        <div class="mt-1 text-xs text-gray-500">Total number of items sold</div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <div class="flex gap-x-4">
                    <div class="w-2/3 shadow py-2 px-4 rounded">
                        <h1 class="mt-2 font-medium text-lg">Daily Views</h1>
                        <div class="mt-1 text-xs text-gray-500">Total number of time your products have been viewed</div>

                        <!-- Views Chart -->
                        <div class="h-64 py-6 px-2 md:h-80">
                            <canvas id="views-chart"></canvas>
                        </div>
                    </div>
                    <div class="w-1/3 flex h-full items-center shadow py-2 px-4 rounded">
                        <div>
                            <h1 class="mt-2 font-medium text-lg">Number of unique customers</h1>
                            <div class="mt-1 text-xs text-gray-500">Total number of unique customers</div>
                            <div class="mt-2.5">
                                <span class="text-4xl text-purple-700 font-medium">{{ number_format($transactions->pluck('user_id')->unique()->count(), 0, '.', ',') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <div class="flex gap-x-4">
                    <div class="w-1/2 shadow py-2 px-4 rounded">
                        <h1 class="mt-2 font-medium text-lg">Daily Items added to Cart</h1>
                        <div class="mt-1 text-xs text-gray-500">Total number of time your products have been added to cart</div>

                        <!-- Cart Chart -->
                        <div class="h-64 py-6 px-2 md:h-80">
                            <canvas id="carts-chart"></canvas>
                        </div>
                    </div>
                    <div class="w-1/2 shadow py-2 px-4 rounded">
                        <h1 class="mt-2 font-medium text-lg">Daily Orders</h1>
                        <div class="mt-1 text-xs text-gray-500">Total number of time your products have been ordered</div>

                        <!-- Order Chart -->
                        <div class="h-64 py-6 px-2 md:h-80">
                            <canvas id="orders-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Show related data for the last 10 transactions -->
            <div class="mt-6">
                <h1 class="px-2 py-4 text-lg">Latest Orders</h1>
                <div class="relative overflow-x-auto shadow rounded">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Product name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Order Code
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Payment
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Quantity
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Total Price
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions->take(3) as $transaction)
                                @foreach ($transaction->order->products as $product)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <a href="{{ route('vendor.products.show', $product->slug) }}" class="hover:text-blue-600">
                                            {{ ucwords($product->name) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ strtoupper($transaction->order->order_code) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ ucfirst($transaction->order->payment_type) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $product->pivot->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ number_format($product->price * $product->pivot->quantity, 0, '.', ',') }}
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-vendor-layout>

<script type="module">
    const transactionData = {!! json_encode($transactionData) !!};
    const ctxTransaction = document.getElementById('transactions-chart').getContext('2d');

    const revenueChart = new Chart(ctxTransaction, {
        type: 'bar',
        data: {
            labels: Object.keys(transactionData),
            datasets: [{
                label: 'Daily Transactions',
                data: Object.values(transactionData),
                fill: true,
                borderColor: '#2a9df4',
                tension: 0.1,
                backgroundColor: 'rgb(96 165 250)',
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true
                    },
                },
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        maxRotation: 0,
                        minRotation: 0
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Daily Transactions',
                    font: {
                        size: 16,
                        weight: 'bold',
                    },
                    color: 'rgb(55 65 81)'
                },
                legend: {
                    display: false,
                }
            },
            responsive: true,
            maintainAspectRatio: false,
        }
    });


    const viewData = {!! json_encode($viewData) !!};
    const ctxViews = document.getElementById('views-chart').getContext('2d');

    const viewChart = new Chart(ctxViews, {
        type: 'line',
        data: {
            labels: Object.keys(viewData),
            datasets: [{
                label: 'Daily Views',
                data: Object.values(viewData),
                fill: true,
                borderColor: '#2a9df4',
                tension: 0.4,
                backgroundColor: 'rgb(96 165 250)',
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: false,
                    grid: {
                        display: true
                    },
                    ticks: {
                        // stepSize: 100 // set y-axis tick interval to 100
                    },
                },
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        maxRotation: 0,
                        minRotation: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false,
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });


    const cartData = {!! json_encode($cartData) !!};
    const ctxCarts = document.getElementById('carts-chart').getContext('2d');

    const cartChart = new Chart(ctxCarts, {
        type: 'line',
        data: {
            labels: Object.keys(cartData),
            datasets: [{
                label: 'Daily items added to Cart',
                data: Object.values(cartData),
                fill: true,
                borderColor: '#2a9df4',
                tension: 0.4,
                backgroundColor: 'rgb(96 165 250)',
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: false,
                    grid: {
                        display: true
                    },
                    ticks: {
                        stepSize: 100 // set y-axis tick interval to 100
                    },
                },
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        maxRotation: 0,
                        minRotation: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false,
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });


    const orderData = {!! json_encode($orderData) !!};
    const ctxOrder = document.getElementById('orders-chart').getContext('2d');

    const orderChart = new Chart(ctxOrder, {
        type: 'line',
        data: {
            labels: Object.keys(orderData),
            datasets: [{
                label: 'Daily Views',
                data: Object.values(orderData),
                fill: true,
                borderColor: '#2a9df4',
                tension: 0.4,
                backgroundColor: 'rgb(96 165 250)',
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: false,
                    grid: {
                        display: true
                    },
                    ticks: {
                        stepSize: 100 // set y-axis tick interval to 100
                    },
                },
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        maxRotation: 0,
                        minRotation: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false,
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>