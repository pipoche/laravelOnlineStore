<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('dashboardassets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('dashboardassets/images/logo-dark.png') }}" alt="" height="17">
                    </span>
                </a>

                <a href="{{ route('dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('dashboardassets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('dashboardassets/images/logo-light.png') }}" alt="" height="18">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>


        </div>



        <div class="d-flex">
            @php
                use App\Models\Order;

                $orders = Order::where('notificationstatus', false)->orderBy('created_at', 'desc')->get();
                $totalOrders = $orders->count();
            @endphp
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="mdi mdi-bell-outline"></i>
                    @if ($totalOrders > 0)
                    <span class="badge bg-danger rounded-pill">{{ $totalOrders }}</span>

                        
                    @endif
                </button>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    @if ($totalOrders > 0)
                        @foreach ($orders as $order)
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('orders.show', $order->id) }}">
                                <div class="ms-3">
                                    <h6 class="mb-1">Order #{{ $order->id }}</h6>
                                    <p class="mb-0 font-size-12 text-muted">Placed by: {{ $order->customer_name }}</p>
                                    <p class="mb-0 font-size-12 text-muted">Total price: {{ $order->total_price }}</p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                        @endforeach
                    @else
                        <a class="dropdown-item text-center" href="#">No new orders</a>
                    @endif
                </div>
            </div>


            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="dashboardassets/images/users/user-4.jpg"
                        alt="Header Avatar">
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- Profile and Logout -->
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        Edit profile &nbsp; <i class="fas fa-pen"></i>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item text-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout &nbsp; &nbsp; &nbsp;<i class="fas fa-sign-out-alt"></i>
                    </a>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                        @csrf
                    </form>


                </div>
            </div>

            <div class="dropdown d-none d-lg-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen"></i>
                </button>
            </div>
        </div>
    </div>
</header>
