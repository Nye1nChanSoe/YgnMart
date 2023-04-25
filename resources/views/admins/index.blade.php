<x-admin-layout>
    <section class="px-3 py-3 mt-6 rounded">
        <div class="text-gray-200">
            <div class="rounded bg-gray-700 px-5 py-3 pb-5">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-medium">Total Active Users</h1>
                        <div class="mt-1.5">
                            <span class="text-5xl text-orange-300 font-medium">{{ number_format($visitors->sum('users'), 0, '.'. ',') }}</span>
                        </div>
                    </div>
                    <div class="text-gray-300 text-sm">
                        <span>{{ now()->format('d M Y') }}</span>
                    </div>
                </div>

                <!-- Daily Active Users -->
                <div>
                    <div class="bg-gray-800 rounded px-3 py-5 h-[160px] md:h-[210px]">
                        <canvas id="active-users-chart"></canvas>
                    </div>
                    <div class="mt-2.5">
                        <h1 class="text-lg font-medium">Unique Active Users</h1>
                    </div>
                    <div class="mt-1.5 bg-gray-800 rounded px-3 py-5 h-[160px] md:h-[210px]">
                        <canvas id="unique-active-users-chart"></canvas>
                    </div>
                </div>
            </div>

            @php
                $todayVisitors = $visitors->filter(fn($item) => $item->day == date('d M'));
                $todayUniqueVisitors = $uniqueVisitors->filter(fn($item) => $item->day == date('d M'));
            @endphp
            <div class="mt-8">
                <div class="flex gap-x-4">
                    <div class="w-1/4 bg-gray-700 py-2 px-4 rounded">
                        <div class="mt-2.5">
                            <span class="text-4xl text-blue-400 font-medium">{{ number_format($todayVisitors->sum('users'), 0, '.'. ',') }}</span>
                        </div>
                        <h1 class="mt-3 font-medium text-lg">Active Users</h1>
                        <div class="mt-1 text-xs text-gray-300">Total number of active users for today</div>
                    </div>
                    <div class="w-1/4 bg-gray-700 py-2 px-4 rounded">
                        <div class="mt-2.5">
                            <span class="text-4xl text-purple-400 font-medium">{{ number_format($todayUniqueVisitors->sum('unique_users'), 0, '.'. ',') }}</span>
                        </div>
                        <h1 class="mt-3 font-medium text-lg">Unique Users</h1>
                        <div class="mt-1 text-xs text-gray-300">Total number of unique users for today</div>
                    </div>
                    <div class="w-1/4 bg-gray-700 py-2 px-4 rounded">
                        <div class="mt-2.5">
                            <span class="text-4xl text-blue-400 font-medium">{{ number_format($todayVisitors->sum('views'), 0, '.', ',') }}</span>
                        </div>
                        <h1 class="mt-3 font-medium text-lg">Page Views</h1>
                        <div class="mt-1 text-xs text-gray-300">Total number of pages viewed today</div>
                    </div>
                    <div class="w-1/4 bg-gray-700 py-2 px-4 rounded">
                        <div class="mt-2.5">
                            <span class="text-4xl text-purple-400 font-medium">{{ number_format($todayUniqueVisitors->sum('unique_views'), 0, '.', ',') }}</span>
                        </div>
                        <h1 class="mt-3 font-medium text-lg">Unique Page Views</h1>
                        <div class="mt-1 text-xs text-gray-300">Total number of unique pages viewd today</div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <div class="flex gap-x-4">
                    <div class="w-1/2 bg-gray-700 py-3 px-4 rounded">
                        <h1 class="mt-2 font-medium text-lg">Daily Page Views</h1>
                        <div class="mt-1 text-xs text-gray-300">Total number of pages visited by users daily</div>

                        <!-- Cart Chart -->
                        <div class="h-64 mt-2.5 bg-gray-800 rounded py-6 px-2 md:h-80">
                            <canvas id="page-views-chart"></canvas>
                        </div>
                    </div>
                    <div class="w-1/2 bg-gray-700 py-2 px-4 rounded">
                        <h1 class="mt-2 font-medium text-lg">Daily Unique Page Views</h1>
                        <div class="mt-1 text-xs text-gray-300">Total number of unique pages visited by users daily</div>

                        <!-- Order Chart -->
                        <div class="h-64 mt-2.5 bg-gray-800 rounded py-6 px-2 md:h-80">
                            <canvas id="unique-page-views-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>

<script type="module">
    const activeData = {!! json_encode($activeData) !!};
    const ctxVisitors = document.getElementById('active-users-chart').getContext('2d');

    const visitorChart = new Chart(ctxVisitors, {
        type: 'line',
        data: {
            labels: Object.keys(activeData),
            datasets: [{
                label: 'Daily Active Users',
                data: Object.values(activeData),
                fill: false,
                borderColor: 'rgb(95, 206, 232)',
                tension: 0.4,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(225, 225, 225, 0.4)', // set grid color to white with low opacity
                    },
                    ticks: {
                        color: 'rgb(255, 255, 255, 0.8)'
                    },
                },
                x: {
                    grid: {
                        display: true,
                        color: 'rgba(225, 225, 225, 0.4)', // set grid color to white with low opacity
                    },
                    ticks: {
                        maxRotation: 0,
                        minRotation: 0,
                        color: 'rgb(255, 255, 255, 0.8)'
                    },
                }
            },
            plugins: {
                legend: {
                    display: false,
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            color: '#fff' // set general color to white
        }
    });

    const uniqueActiveData = {!! json_encode($uniqueActiveData) !!};
    const ctxUniqueVisitors = document.getElementById('unique-active-users-chart').getContext('2d');

    const uniqueVisitorChart = new Chart(ctxUniqueVisitors, {
        type: 'line',
        data: {
            labels: Object.keys(uniqueActiveData),
            datasets: [{
                label: 'Daily Active Users',
                data: Object.values(uniqueActiveData),
                fill: false,
                borderColor: 'rgb(95, 206, 232)',
                tension: 0.4,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(225, 225, 225, 0.4)', // set grid color to white with low opacity
                    },
                    ticks: {
                        color: 'rgb(255, 255, 255, 0.8)'
                    },
                },
                x: {
                    grid: {
                        display: true,
                        color: 'rgba(225, 225, 225, 0.4)', // set grid color to white with low opacity
                    },
                    ticks: {
                        maxRotation: 0,
                        minRotation: 0,
                        color: 'rgb(255, 255, 255, 0.8)'
                    },
                }
            },
            plugins: {
                legend: {
                    display: false,
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            color: '#fff' // set general color to white
        }
    });

    const viewData = {!! json_encode($viewData) !!};
    const ctxViewData = document.getElementById('page-views-chart').getContext('2d');

    const viewChart = new Chart(ctxViewData, {
        type: 'line',
        data: {
            labels: Object.keys(viewData),
            datasets: [{
                label: 'Daily Active Users',
                data: Object.values(viewData),
                fill: false,
                borderColor: 'rgb(95, 206, 232)',
                tension: 0.4,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(225, 225, 225, 0.4)', // set grid color to white with low opacity
                    },
                    ticks: {
                        color: 'rgb(255, 255, 255, 0.8)'
                    },
                },
                x: {
                    grid: {
                        display: true,
                        color: 'rgba(225, 225, 225, 0.4)', // set grid color to white with low opacity
                    },
                    ticks: {
                        maxRotation: 0,
                        minRotation: 0,
                        color: 'rgb(255, 255, 255, 0.8)'
                    },
                }
            },
            plugins: {
                legend: {
                    display: false,
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            color: '#fff' // set general color to white
        }
    });

    const uniqueViewData = {!! json_encode($uniqueViewData) !!};
    const ctxUniqueViewData = document.getElementById('unique-page-views-chart').getContext('2d');

    const uniqueViewChart = new Chart(ctxUniqueViewData, {
        type: 'line',
        data: {
            labels: Object.keys(uniqueViewData),
            datasets: [{
                label: 'Daily Active Users',
                data: Object.values(uniqueViewData),
                fill: false,
                borderColor: 'rgb(95, 206, 232)',
                tension: 0.4,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(225, 225, 225, 0.4)', // set grid color to white with low opacity
                    },
                    ticks: {
                        color: 'rgb(255, 255, 255, 0.8)'
                    },
                },
                x: {
                    grid: {
                        display: true,
                        color: 'rgba(225, 225, 225, 0.4)', // set grid color to white with low opacity
                    },
                    ticks: {
                        maxRotation: 0,
                        minRotation: 0,
                        color: 'rgb(255, 255, 255, 0.8)'
                    },
                }
            },
            plugins: {
                legend: {
                    display: false,
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            color: '#fff' // set general color to white
        }
    });
</script>