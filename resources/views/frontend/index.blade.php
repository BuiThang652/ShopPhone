<x-guest-layout>
    <x-header></x-header>

    <div class="slider-area">
        <!-- Slider -->
        <div class="block-slider block-slider4">
            <ul class="" id="bxslider-home4">
                <li>
                    <img src="{{ asset('ustora/img/h4-slide.png') }}" alt="Slide">
                    <div class="caption-group">
                        <h2 class="caption title">
                            iPhone <span class="primary">6 <strong>Plus</strong></span>
                        </h2>
                        <h4 class="caption subtitle">Dual SIM</h4>
                        <a class="caption button-radius" href="{{ Route('frontend.products') }}"><span
                                class="icon"></span>Shop now</a>
                    </div>
                </li>
                <li><img src="{{ asset('ustora/img/h4-slide2.png') }}" alt="Slide">
                    <div class="caption-group">
                        <h2 class="caption title">
                            by one, get one <span class="primary">50% <strong>off</strong></span>
                        </h2>
                        <h4 class="caption subtitle">school supplies & backpacks.*</h4>
                        <a class="caption button-radius" href="{{ Route('frontend.products') }}"><span
                                class="icon"></span>Shop now</a>
                    </div>
                </li>
                <li><img src="{{ asset('ustora/img/h4-slide3.png') }}" alt="Slide">
                    <div class="caption-group">
                        <h2 class="caption title">
                            Apple <span class="primary">Store <strong>Ipod</strong></span>
                        </h2>
                        <h4 class="caption subtitle">Select Item</h4>
                        <a class="caption button-radius" href="{{ Route('frontend.products') }}"><span
                                class="icon"></span>Shop now</a>
                    </div>
                </li>
                <li><img src="{{ asset('ustora/img/h4-slide4.png') }}" alt="Slide">
                    <div class="caption-group">
                        <h2 class="caption title">
                            Apple <span class="primary">Store <strong>Ipod</strong></span>
                        </h2>
                        <h4 class="caption subtitle">& Phone</h4>
                        <a class="caption button-radius" href="{{ Route('frontend.products') }}"><span
                                class="icon"></span>Shop now</a>
                    </div>
                </li>
            </ul>
        </div>
        <!-- ./Slider -->
    </div> <!-- End slider area -->

    <div class="promo-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo promo1">
                        <i class="fa fa-refresh"></i>
                        <p>30 Days return</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo promo2">
                        <i class="fa fa-truck"></i>
                        <p>Free shipping</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo promo3">
                        <i class="fa fa-lock"></i>
                        <p>Secure payments</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo promo4">
                        <i class="fa fa-gift"></i>
                        <p>New products</p>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End promo area -->

    <div class="maincontent-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="latest-product">
                        <h2 class="section-title">Latest Products</h2>
                        <div class="product-carousel">
                            @foreach ($top_products as $item)
                                <div class="single-product">
                                    <div class="product-f-image">
                                        <img src="{{ asset('ustora/img/' . $item->thumbnail) }}" alt="">
                                        <div class="product-hover">
                                            <a href="{{ route('frontend.home.order', ['id' => $item->id]) }}"
                                                class="add-to-cart-link"><i class="fa fa-shopping-cart"></i>
                                                Add to cart</a>
                                            <a href="{{ route('frontend.single-product', ['id' => $item->id]) }}"
                                                class="view-details-link"><i class="fa fa-link"></i> See details</a>
                                        </div>
                                    </div>

                                    <h2><a
                                            href="{{ route('frontend.single-product', ['id' => $item->id]) }}">{{ $item->name }}</a>
                                    </h2>

                                    <div class="product-carousel-price">
                                        <ins>{{ $item->price }}</ins>
                                        {{-- <del>$100.00</del> --}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End main content area -->

    <div class="brands-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="brand-wrapper">
                        <div class="brand-list">
                            <img src="{{ asset('ustora/img/brand1.png') }}" alt="">
                            <img src="{{ asset('ustora/img/brand2.png') }}" alt="">
                            <img src="{{ asset('ustora/img/brand3.png') }}" alt="">
                            <img src="{{ asset('ustora/img/brand4.png') }}" alt="">
                            <img src="{{ asset('ustora/img/brand5.png') }}" alt="">
                            <img src="{{ asset('ustora/img/brand6.png') }}" alt="">
                            <img src="{{ asset('ustora/img/brand1.png') }}" alt="">
                            <img src="{{ asset('ustora/img/brand2.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End brands area -->

    <div class="product-widget-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="single-product-widget">
                        <h2 class="product-wid-title">Top Sellers</h2>
                        {{-- <a href="" class="wid-view-more">View All</a> --}}
                        @foreach ($top_seller as $seller)
                            <div class="single-wid-product">
                                <a href="{{ Route('frontend.single-product', ['id' => $seller->id]) }}"><img
                                        src="{{ asset('ustora/img/' . $seller->thumbnail) }}" alt=""
                                        class="product-thumb"></a>
                                <h2><a
                                        href="{{ Route('frontend.single-product', ['id' => $seller->id]) }}">{{ $seller->name }}</a>
                                </h2>
                                <div class="product-wid-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product-wid-price">
                                    <ins>{{ $seller->price }}</ins>
                                    {{-- <del>$425.00</del> --}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-product-widget">
                        <h2 class="product-wid-title">Recently Viewed</h2>
                        <a href="#" class="wid-view-more">View All</a>
                        @foreach ($top_view as $view)
                            <div class="single-wid-product">
                                <a href="{{ Route('frontend.single-product', ['id' => $view->id]) }}"><img
                                        src="{{ asset('ustora/img/' . $view->thumbnail) }}" alt=""
                                        class="product-thumb"></a>
                                <h2><a
                                        href="{{ Route('frontend.single-product', ['id' => $view->id]) }}">{{ $view->name }}</a>
                                </h2>
                                <div class="product-wid-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product-wid-price">
                                    <ins>{{ $view->price }}</ins>
                                    {{-- <del>$425.00</del> --}}
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-product-widget">
                        <h2 class="product-wid-title">Top New</h2>
                        <a href="#" class="wid-view-more">View All</a>
                        @foreach ($top_new as $new)
                            <div class="single-wid-product">
                                <a href="{{ Route('frontend.single-product', ['id' => $new->id]) }}"><img
                                        src="{{ asset('ustora/img/' . $new->thumbnail) }}" alt=""
                                        class="product-thumb"></a>
                                <h2><a
                                        href="{{ Route('frontend.single-product', ['id' => $new->id]) }}">{{ $new->name }}</a>
                                </h2>
                                <div class="product-wid-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product-wid-price">
                                    <ins>{{ $new->price }}</ins>
                                    {{-- <del>$425.00</del> --}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End product widget area -->


    <x-footer></x-footer>
</x-guest-layout>
