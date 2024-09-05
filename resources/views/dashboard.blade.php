@extends('layouts.dashboard')

@section('pagecontent')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<!-- start page title -->
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="page-title">Dashboard</h6>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">{{ Auth::user()->name }} Welcome to our dashboard </li>
            </ol>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary text-white">
            <div class="card-body">
                <div class="mb-4">
                    <div class="float-start mini-stat-img me-4">
                        <img src="{{ asset('dashboardassets/images/services-icon/01.png') }}" alt="">
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">Categories</h5>
                    <h4 class="fw-medium font-size-24">{{ $categoriesCount }} <i class="mdi mdi-arrow-up text-success ms-2"></i></h4>
                    <div class="mini-stat-label bg-success">
                        <p class="mb-0">+ 12%</p>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="float-end">
                        <a href="#" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                    </div>
                    <p class="text-white-50 mb-0 mt-1">Since last month</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary text-white">
            <div class="card-body">
                <div class="mb-4">
                    <div class="float-start mini-stat-img me-4">
                        <img src="{{ asset('dashboardassets/images/services-icon/02.png') }}" alt="">
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">Products</h5>
                    <h4 class="fw-medium font-size-24">{{ $productsCount }} <i class="mdi mdi-arrow-down text-danger ms-2"></i></h4>
                    <div class="mini-stat-label bg-danger">
                        <p class="mb-0">- 28%</p>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="float-end">
                        <a href="#" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                    </div>
                    <p class="text-white-50 mb-0 mt-1">Since last month</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary text-white">
            <div class="card-body">
                <div class="mb-4">
                    <div class="float-start mini-stat-img me-4">
                        <img src="{{ asset('dashboardassets/images/services-icon/03.png') }}" alt="">
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">Packs</h5>
                    <h4 class="fw-medium font-size-24">{{ $packsCount }} <i class="mdi mdi-arrow-up text-success ms-2"></i></h4>
                    <div class="mini-stat-label bg-info">
                        <p class="mb-0">00%</p>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="float-end">
                        <a href="#" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                    </div>
                    <p class="text-white-50 mb-0 mt-1">Since last month</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary text-white">
            <div class="card-body">
                <div class="mb-4">
                    <div class="float-start mini-stat-img me-4">
                        <img src="{{ asset('dashboardassets/images/services-icon/04.png') }}" alt="">
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">Promotions</h5>
                    <h4 class="fw-medium font-size-24">{{ $promotionsCount }} <i class="mdi mdi-arrow-up text-success ms-2"></i></h4>
                    <div class="mini-stat-label bg-warning">
                        <p class="mb-0">+ 84%</p>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="float-end">
                        <a href="#" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                    </div>
                    <p class="text-white-50 mb-0 mt-1">Since last month</p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl-9">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Monthly Earning</h4>
                <div class="row">
                    <div class="col-lg-7">
                        <div>
                            <div id="chart-with-area" class="ct-chart earning ct-golden-section">
                                <!-- Include your chart or data visualization library here -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-center">
                                    <p class="text-muted mb-4">This month</p>
                                    <h3>{{ number_format($currentMonthEarnings, 2) }} MAD</h3>
                                    <p class="text-muted mb-5">Earnings for the current month.</p>
                                    <span class="peity-donut"
                                        data-peity='{ "fill": ["#02a499", "#f2f2f2"], "innerRadius": 28, "radius": 32 }'
                                        data-width="72" data-height="72">4/5</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center">
                                    <p class="text-muted mb-4">Last month</p>
                                    <h3>{{ number_format($previousMonthEarnings, 2) }} MAD</h3>
                                    <p class="text-muted mb-5">Earnings for the previous month.</p>
                                    <span class="peity-donut"
                                        data-peity='{ "fill": ["#02a499", "#f2f2f2"], "innerRadius": 28, "radius": 32 }'
                                        data-width="72" data-height="72">3/5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- end card -->
    </div>
    <div class="col-xl-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Order Status Breakdown</h4>
                <canvas id="statusChart" width="400" height="600"></canvas>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    const ctx = document.getElementById('statusChart').getContext('2d');
                    const statusChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['Pending', 'Delivering', 'Cancelled', 'Success'],
                            datasets: [{
                                label: 'Order Status',
                                data: [{{ $pendingOrders }}, {{ $deliveringOrders }}, {{ $cancelledOrders }}, {{ $successOrders }}],
                                backgroundColor: [
                                    'rgba(255, 159, 64, 0.6)', // Pending
                                    'rgba(54, 162, 235, 0.6)', // Delivering
                                    'rgba(255, 99, 132, 0.6)', // Cancelled
                                    'rgba(75, 192, 192, 0.6)'  // Success
                                ],
                                borderColor: [
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(75, 192, 192, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true
                        }
                    });
                </script>
            </div>
        </div>
    </div>
   
</div>

<div class="row">
    <div class="col-xl-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Sales Analytics by Status</h4>

                <!-- Pending Orders -->
                <div class="wid-peity mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <p class="text-muted">Pending</p>
                                <h5 class="mb-4">{{ $pendingOrders }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivering Orders -->
                <div class="wid-peity mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <p class="text-muted">Delivering</p>
                                <h5 class="mb-4">{{ $deliveringOrders }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cancelled Orders -->
                <div class="wid-peity mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <p class="text-muted">Cancelled</p>
                                <h5 class="mb-4">{{ $cancelledOrders }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Success Orders -->
                <div class="wid-peity mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <p class="text-muted">Success</p>
                                <h5 class="mb-4">{{ $successOrders }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
