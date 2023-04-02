<x-vendor-layout>
    <x-slot:title>
        {{ $product->name }} - YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.dashboard') }}" class="{{ request()->routeIs('vendor.dashboard') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Dashboard</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products') }}" class="{{ request()->routeIs('vendor.products') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Products</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products.show', $product->slug) }}" class="{{ request()->routeIs('vendor.products.*') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Current Product</a>
        </li>
    </ul>

    <div class="flex items-center justify-end gap-x-2 px-5 py-1.5 mt-6">
        <a href="{{ route('vendor.products.edit', $product->slug) }}" class="text-sm text-gray-500 hover:text-blue-600">Edit</a>
    </div>
    <section class="px-5 py-5 mt-1 shadow rounded">
        <div class="text-gray-700">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h1 class="text-lg">Daily Sales data of {{ $product->name }}</h1>
                    <div class="mt-1.5">
                        <span class="text-2xl text-green-600 font-medium">{{ number_format($revenueData->reduce(fn($total, $item) => $total + $item) / ($revenueData->count() ? $revenueData->count() : 1), 0, '.', ',') }}</span>
                        <span class="text-gray-500 font-normal text-sm">Kyat (daily average)</span>
                    </div>
                </div>
                <div class="flex flex-col gap-y-1.5 items-end">
                    <time class="text-gray-700 text-sm">{{ $product->inventory->created_at->format('d M Y') }}</time>
                    <span class="text-gray-500 block text-xs">(last stocked date)</span>
                </div>
            </div>

            <!-- Monthly Sales Chart -->
            <div>
                <div class="bg-white px-3 py-5 h-[320px] rounded-lg md:h-[420px]">
                    <canvas id="product-revenue-chart"></canvas>
                </div>
            </div>

            <!-- Product, Inventory details -->
            <div class="flex gap-x-4 mt-8">
                <div class="w-1/2 shadow p-4">
                    <h1 class="text-lg font-medium">
                        Product Info
                        @if ($product->inventory->status == 'sell')
                        <span class="bg-slate-100 text-blue-500 rounded-lg px-2.5 py-1 text-sm mr-1.5">Selling</span>
                        @else
                        <span class="bg-slate-100 text-gray-700 rounded-lg px-2.5 py-1 text-sm mr-1.5">Closed</span>
                        @endif
                    </h1>
                    <div class="flex flex-col gap-y-1.5 mt-3 text-sm">
                        <p>Name: "<span class="text-green-600 font-medium text-sm">{{ $product->name }}</span>"</p>
                        <p>Price: <span class="text-amber-500 font-medium text-sm">{{ number_format($product->price, 0, '.', ',') }}</span></p>
                        <p>Metadata: "<span class="text-green-600 font-medium text-sm">{{ $product->meta_type }}</span>"</p>
                        <div class="flex items-center gap-x-2">
                            <span>Ratings: </span>
                            <x-product-review :product="$product"/>
                        </div>
                    </div>
                </div>
                <div class="w-1/2 shadow p-4">
                    <h1 class="text-lg font-medium">
                        Stock Info
                        @if ($product->inventory->in_stock)
                        <span class="bg-slate-100 rounded-lg text-sm text-green-500 px-2.5 py-1 mr-1.5">In Stock</span>
                        @elseif($product->inventory->low_stock)
                        <span class="bg-slate-100 rounded-lg text-sm text-yellow-500 px-2.5 py-1 mr-1.5">Low Stock</span>
                        @else
                        <span class="bg-slate-100 rounded-lg text-sm text-red-500 px-2.5 py-1 mr-1.5">Out of Stock</span>
                        @endif
                    </h1>
                    <div class="flex flex-col gap-y-1.5 mt-3 text-sm">
                        <p>SKU Number: "<span class="text-green-600 font-medium text-sm">{{ $product->inventory->sku }}</span>"</p>
                        <p>Total Stock: <span class="text-amber-500 font-medium text-sm">{{ number_format($product->inventory->in_stock_quantity, 0, '.', ',') }}</span></p>
                        <p>Minimum Stock: <span class="text-amber-500 font-medium text-sm">{{ number_format($product->inventory->minimum_quantity, 0, '.', ',') }}</span></p>
                        <p>Available Stock: <span class="text-amber-500 font-medium text-sm">{{ number_format($product->inventory->available_quantity, 0, '.', ',') }}</span></p>
                    </div>
                </div>
            </div>

            @if ($product->analytics()->count() > 7)
                <!--Daily Checkouts and Orders Chart -->
            <div class="mt-8">
                <div class="w-full h-72 p-4 shadow md:h-96">
                    <canvas id="product-checkout-order-chart"></canvas>
                </div>
            </div>

            <!--Daily Views and Carts Chart -->
            <div class="flex gap-x-4 mt-8">
                <div class="w-1/2 h-60 p-4 shadow md:h-72">
                    <canvas id="product-view-chart"></canvas>
                </div>
                <div class="w-1/2 h-60 p-4 shadow md:h-72">
                    <canvas id="product-cart-chart"></canvas>
                </div>
            </div>
            
            <div class="flex gap-x-4 mt-8">
                <div class="w-1/2 h-60 p-4 shadow md:h-72">
                    <h1 class="text-lg font-medium">Product Description</h1>
                    <div class="flex flex-col gap-y-1.5 mt-3 text-sm">
                        <p>"<span class="text-green-600 font-medium text-sm">{{ $product->description }}</span>"</p>
                    </div>
                </div>
                <div class="w-1/2 h-60 p-4 shadow md:h-72">
                    <canvas id="product-rating-chart"></canvas>
                </div>
            </div>
            @else
            <div class="w-full p-4 shadow mt-4">
                <h1 class="text-lg font-medium">Product Description</h1>
                <div>
                    <p>"<span class="text-green-600 font-medium text-sm">{{ $product->description }}</span>"</p>
                </div>
            </div>
            <div class="w-full h-72 flex items-center justify-center mt-4">
                <p class="text-gray-500">Insufficient product data to display</p>
            </div>
            @endif
        </div>
    </section>

    {{-- <div class="text-white bg-red-500 rounded-lg px-2.5 py-1.5 mt-6 w-fit hover:bg-red-700">
        <form action="{{ route('vendor.products.destroy', $product->slug) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Request Delete</button>
        </form>
    </div> --}}
</x-vendor-layout>

<script type="module">
    const revenueData = {!! json_encode($revenueData) !!};
    const ctxRevenue = document.getElementById('product-revenue-chart').getContext('2d');
    
    const revenueChart = new Chart(ctxRevenue, {
        type: 'bar',
        data: {
            labels: Object.keys(revenueData),
            datasets: [{
                label: 'Daily Sales Revenue',
                data: Object.values(revenueData),
                fill: true,
                borderColor: '#2a9df4',
                tension: 0.1,
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
                    // title: {
                    //     display: true,
                    //     text: 'Kyat',
                    //     padding: {
                    //         bottom: 15,
                    //     },
                    //     font: {
                    //         size: 16
                    //     }
                    // }
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
                    text: 'Daily Sales Revenue',
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
            maintainAspectRatio: false
        }
    });

    const viewData = {!! json_encode($viewData) !!};
    const ctxView = document.getElementById('product-view-chart').getContext('2d');

    const viewChart = new Chart(ctxView, {
        type: 'line',
        data: {
            labels: Object.keys(viewData).map(key => key.split(' ')[0]),
            datasets: [{
                label: 'Daily Views',
                data: Object.values(viewData),
                fill: false,
                borderColor: 'rgb(96 165 250)',
                tension: 0.4,
                backgroundColor: 'white',
            }],
        },
        options: {
            scales: {
                y: {
                    ticks: {
                        stepSize: 200 // set y-axis tick interval to 20
                    },
                    title: {
                        display: true,
                        text: 'Views',
                        padding: {
                            bottom: 15,
                        },
                        font: {
                            size: 13
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,  
                    },
                    ticks: {
                        maxRotation: 0,
                        minRotation: 0
                    },
                    title: {
                        display: true,
                        text: 'March',
                        padding: {
                            top: 15,
                        },
                        font: {
                            size: 13
                        }
                    }
                },
            },
            layout: {
                padding: {
                    top: 0,
                    bottom: 0,
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Daily Views',
                    font: {
                        size: 16,
                        weight: 'bold',
                    },
                    color: 'rgb(55 65 81)'
                },
                legend: {
                    display: false,
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        title: function(tooltipItems) {
                            // Use the first tooltip item to get the label (i.e., the date)
                            const label = Object.keys(viewData)[tooltipItems[0].dataIndex];
                            return label;
                        },
                    },
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    const cartData = {!! json_encode($cartData) !!};
    const ctxCart = document.getElementById('product-cart-chart').getContext('2d');

    const cartChart = new Chart(ctxCart, {
        type: 'line',
        data: {
            labels: Object.keys(cartData).map(key => key.split(' ')[0]),
            datasets: [{
                label: 'Daily Added to Cart',
                data: Object.values(cartData),
                fill: false,
                borderColor: 'rgb(96 165 250)',
                tension: 0.4,
                backgroundColor: 'white',
            }],
        },
        options: {
            scales: {
                y: {
                    ticks: {
                        stepSize: 100 // set y-axis tick interval to 20
                    },
                    title: {
                        display: true,
                        text: 'Carts',
                        padding: {
                            bottom: 15,
                        },
                        font: {
                            size: 13
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,  
                    },
                    ticks: {
                        maxRotation: 0,
                        minRotation: 0
                    },
                    title: {
                        display: true,
                        text: 'March',
                        padding: {
                            top: 15,
                        },
                        font: {
                            size: 13
                        }
                    }
                },
            },
            layout: {
                padding: {
                    top: 0,
                    bottom: 0,
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Daily Added to Cart',
                    font: {
                        size: 16,
                        weight: 'bold',
                    },
                    color: 'rgb(55 65 81)'
                },
                legend: {
                    display: false,
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        title: function(tooltipItems) {
                            // Use the first tooltip item to get the label (i.e., the date)
                            const label = Object.keys(cartData)[tooltipItems[0].dataIndex];
                            return label;
                        },
                    },
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    /* show both checkout and order charts in a mixed chart */
    const checkoutData = {!! json_encode($checkoutData) !!};
    const orderData = {!! json_encode($orderData) !!};
    const ctxCheckout = document.getElementById('product-checkout-order-chart').getContext('2d');

    const orderCheckoutChart = new Chart(ctxCheckout, {
        type: 'bar',
        data: {
            labels: Object.keys(checkoutData),
            datasets: [{
                label: 'Checkouts',
                data: Object.values(checkoutData),
                backgroundColor: 'rgb(96 165 250)',
                order: 2,
            }, {
                label: 'Orders',
                data: Object.values(orderData),
                borderColor: 'rgb(251 146 60)',
                fill: false,
                type: 'line',
                tension: 0.2,
                order: 1,
                backgroundColor: 'white',
            }],
        },
        options: {
            scales: {
                y: {
                    ticks: {
                        stepSize: 100 // set y-axis tick interval to 20
                    },
                    title: {
                        display: true,
                        text: 'Checkouts and Orders',
                        padding: {
                            bottom: 15,
                        },
                        font: {
                            size: 13
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,  
                    },
                    ticks: {
                        maxRotation: 0,
                        minRotation: 0
                    },
                    title: {
                        display: true,
                        text: 'March',
                        padding: {
                            top: 15,
                        },
                        font: {
                            size: 13
                        }
                    }
                },
            },
            layout: {
                padding: {
                    top: 0,
                    bottom: 0,
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Daily Checkouts and Orders',
                    font: {
                        size: 16,
                        weight: 'bold',
                    },
                    color: 'rgb(55 65 81)'
                },
                legend: {
                    display: true,
                    position: 'bottom',
                },
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });


    const ratingsData = {!! json_encode($ratings) !!};
    const ctxRatings = document.getElementById('product-rating-chart').getContext('2d');
    const ratingsChart = new Chart(ctxRatings, {
        type: 'doughnut',
        data: {
            labels: ['1 star', '2 stars', '3 stars', '4 stars', '5 stars'],
            datasets: [{
                label: 'Daily Product Ratings',
                data: Object.values(ratingsData).map((val) => val.count),
                fill: false,
                borderColor: 'transparent',
                tension: 0.1,
                backgroundColor: [
                    "rgb(239 68 68)",
                    "rgb(249 115 22)",
                    "rgb(234 179 8)",
                    "rgb(132 204 22)",
                    "rgb(34 197 94)",
                ]
            }],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: false,
                    grid: {
                        display: false,
                        drawBorder: false // hide y-axis ticks border
                    },
                    ticks: {
                        display: false,
                    },
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                datalabels: {
                    color: '#fff',
                    font: {
                        size: '18'
                    },
                    formatter: function(value, context) {
                        return value;
                    }
                },
                title: {
                    display: true,
                    text: 'Ratings',
                    font: {
                        size: 16,
                        weight: 'bold',
                    },
                    color: 'rgb(55 65 81)',
                    padding: {
                        bottom: 14,
                    }
                },
                legend: {
                    display: true,
                    position: 'bottom',
                },
            },
        }
    });
</script>