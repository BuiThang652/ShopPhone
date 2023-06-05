<x-guest-layout>
    <x-header></x-header>

    @foreach ($categories as $category)
        <div>
            <div class="maincontent-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="latest-product">
                                <h2 class="section-title">{{ $category->name }}</h2>
                                <div class="product-carousel">
                                    @foreach ($products as $product)
                                        @if ($category->id == $product->category_id)
                                            <div class="single-product">
                                                <div class="product-f-image">
                                                    <img src="{{ asset('ustora/img/' . $product->thumbnail) }}"
                                                        alt="">
                                                    <div class="product-hover">
                                                        <a href="{{ route('frontend.category.order', ['id' => $product->id]) }}"
                                                            class="add-to-cart-link"><i class="fa fa-shopping-cart"></i>
                                                            Add to cart</a>
                                                        <a href="{{ route('frontend.single-product', ['id' => $product->id]) }}"
                                                            class="view-details-link"><i class="fa fa-link"></i> See
                                                            details</a>
                                                    </div>
                                                </div>

                                                <h2><a
                                                        href="{{ route('frontend.single-product', ['id' => $product->id]) }}">{{ $product->name }}</a>
                                                </h2>

                                                <div class="product-carousel-price">
                                                    <ins>{{ $product->price }} VND</ins>
                                                    {{-- <del>$100.00</del> --}}
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <x-footer></x-footer>
</x-guest-layout>
