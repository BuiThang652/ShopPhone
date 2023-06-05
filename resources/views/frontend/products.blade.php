<x-guest-layout>
    <x-header></x-header>

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Shop</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-4 col-sm-6">
                        <div class="single-shop-product">
                            <div class="product-upper">
                                <img src="{{ asset('ustora/img/' . $product->thumbnail) }}" alt="">
                            </div>
                            <h2><a
                                    href="{{ route('frontend.single-product', ['id' => $product->id]) }}">{{ $product->name }}</a>
                            </h2>
                            <div class="product-carousel-price">
                                <ins>{{ $product->price }} VND</ins>
                                {{-- <del>$999.00</del> --}}
                            </div>

                            <div class="product-option-shop">
                                <a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="70"
                                    rel="nofollow"
                                    href="{{ route('frontend.products.order', ['id' => $product->id]) }}">Add to
                                    cart</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="product-pagination text-center">
                        <nav>
                            <ul class="pagination">
                                @if ($products->currentPage() > 1)
                                    <li>
                                        <a href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                @endif

                                <!-- Liên kết cho từng trang -->
                                @php
                                    $start = max(1, $products->currentPage() - 2);
                                    $end = min($start + 3, $products->lastPage());
                                @endphp

                                @for ($i = $start; $i <= $end; $i++)
                                    <li class="{{ $i == $products->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $products->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <!-- Liên kết đến trang tiếp theo -->
                                @if ($products->hasMorePages())
                                    <li>
                                        <a href="{{ $products->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer></x-footer>
</x-guest-layout>
