<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title"></li>
                <li class="menu-title"></li>
                <li class="menu-title"></li>
                <li class="menu-title">Main</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">

                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    @php
                        use App\Models\Order;

                        $orders = Order::where('notificationstatus', false)->orderBy('created_at', 'desc')->get();
                        $totalOrders = $orders->count();
                    @endphp


                    <a href="{{ route('inbox') }}" class="waves-effect">
                        @if ($totalOrders > 0)
                        <i class="ion ion-md-mail-open"></i><span
                        class="badge rounded-pill bg-primary float-end">{{$totalOrders}}</span>
                        @endif
                     
                        <span>Inbox</span>
                    </a>
                </li>
                <li class="menu-title"></li>


                <li class="menu-title">Components</li>
                <li>
                    <a href="{{ route('categories') }}" class="waves-effect">
                        <i class="fas fa-clipboard-list"></i>

                        <span>Categories List</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('products') }}" class="waves-effect">
                        <i class="fas fa-clipboard-list"></i>

                        <span>Products List</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.promotions') }}" class="waves-effect">
                        <i class="fas fa-clipboard-list"></i>

                        <span>promotions List</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('packs') }}" class="waves-effect">
                        <i class="fas fa-clipboard-list"></i>

                        <span>Packs List</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('orders.index') }}" class="waves-effect">
                        <i class="fas fa-clipboard-list"></i>
                        <span> Orders List</span>
                    </a>
                </li>

                <li class="menu-title"></li>
                <li class="menu-title"></li>

                <li class="menu-title">Admin Actions</li>
                <li>
                    <a href="{{ route('profile.edit') }}" class="waves-effect">
                        <i class="fas fa-pen"></i>
                        <span>Edit Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('register') }}" class="waves-effect">
                        <i class="fas fa-plus"></i>
                        <span>Create New User</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="waves-effect"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-power-off"></i>&nbsp; Logout
                    </a>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                        @csrf
                    </form>
                </li>


            </ul>
        </div>
    </div>
</div>
