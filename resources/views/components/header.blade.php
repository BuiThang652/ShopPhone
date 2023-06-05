<header>
    <div class="header-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="user-menu">
                        <ul>
                            <li><a href="{{ route('profile.edit') }}"><i class="fa fa-user"></i> My Account</a></li>
                            <li><a href="#"><i class="fa fa-heart"></i> Wishlist</a></li>
                            <li><a href="{{ route('frontend.orders') }}"><i class="fa fa-shopping-cart"
                                        aria-hidden="true"></i> My Cart</a>
                            </li>
                            <li><a href="#"><i class="fa fa-user"></i> Checkout</a></li>
                            <li>
                                @if (Route::has('login'))
                                    @auth
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf

                                            <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                                <i class="fa fa-user"></i>
                                                {{ Auth::user()->name }}
                                            </x-dropdown-link>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}">
                                            <i class="fa fa-sign-in" aria-hidden="true"></i>
                                            Login</a>
                                    @endauth
                                @endif
                            </li>
                            <li>
                                @if (Route::has('login'))
                                    @auth
                                    @else
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="">Register</a>
                                        @endif
                                    @endauth
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="header-right">
                        <ul class="list-unstyled list-inline">
                            <li class="dropdown dropdown-small">
                                <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle"
                                    href="#"><span class="key">currency :</span><span class="value">USD
                                    </span><b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">USD</a></li>
                                    <li><a href="#">INR</a></li>
                                    <li><a href="#">GBP</a></li>
                                </ul>
                            </li>

                            <li class="dropdown dropdown-small">
                                <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle"
                                    href="#"><span class="key">language :</span><span class="value">English
                                    </span><b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">French</a></li>
                                    <li><a href="#">German</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End header area -->

    <div class="site-branding-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="logo">
                        <h1><a href="{{ route('frontend.home') }}"><img src="{{ asset('ustora/img/logo.png') }}"></a>
                        </h1>
                    </div>
                </div>

                <div class="col-sm-6">
                    @if (Route::has('login'))
                        @auth
                            @php
                                $user = Auth::user();
                                if ($user) {
                                    $user_id = $user->id;
                                
                                    $orders = DB::table('orders')
                                        ->where('user_id', $user_id)
                                        ->first();
                                
                                    if ($orders) {
                                        $order_items = DB::table('order_items')
                                            ->where('order_id', $orders->id)
                                            ->get();
                                
                                        $total_quantity = 0;
                                        $total_amount = 0;
                                
                                        foreach ($order_items as $item) {
                                            $total_quantity += $item->quantity;
                                            $total_amount += $item->price;
                                        }
                                    }
                                
                                    // dd($total_amount);
                                }
                            @endphp
                            @if ($orders)
                                <div class="shopping-item">
                                    <a href="{{ route('frontend.orders') }}">Cart - <span
                                            class="cart-amunt">{{ $total_amount }} VND</span> <i
                                            class="fa fa-shopping-cart"></i> <span
                                            class="product-count">{{ $total_quantity }}</span></a>
                                </div>
                            @else
                                <div class="shopping-item">
                                    <a href="{{ route('frontend.orders') }}">Cart - <span class="cart-amunt">0 VND</span>
                                        <i class="fa fa-shopping-cart"></i> <span class="product-count">0</span></a>
                                </div>
                            @endif
                        @else
                        @endauth
                    @endif

                </div>
            </div>
        </div>
    </div> <!-- End site branding area -->

    <div class="mainmenu-area" style="z-index: 999">
        <div class="container">
            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="{{ Request::route()->getName() === 'frontend.home' ? 'active' : '' }}">
                            <a href="{{ route('frontend.home') }}">Home</a>
                        </li>
                        <li class="{{ Request::route()->getName() === 'frontend.products' ? 'active' : '' }}"><a
                                href="{{ route('frontend.products') }}">Shop page</a></li>
                        {{-- <li class="{{ Request::route()->getName() === 'frontend.single-product' ? 'active' : '' }}"><a
                                href="{{ route('frontend.single-product') }}">Single product</a></li> --}}
                        <li class="{{ Request::route()->getName() === 'frontend.orders' ? 'active' : '' }}"><a
                                href="{{ route('frontend.orders') }}">Cart</a></li>
                        <li class=""><a href="#">Checkout</a></li>
                        <li class="{{ Request::route()->getName() === 'frontend.category' ? 'active' : '' }}"><a
                                href="{{ route('frontend.category') }}">Category</a></li>
                        <li class="{{ Request::route()->getName() === 'frontend.contact' ? 'active' : '' }}"><a
                                href="{{ route('frontend.contact') }}">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div> <!-- End mainmenu area -->

</header>
