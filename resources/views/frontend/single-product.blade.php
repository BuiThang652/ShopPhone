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
                <div class="col-md-4">
                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Search Products</h2>
                        <form action="">
                            <input type="text" placeholder="Search products...">
                            <input type="submit" value="Search">
                        </form>
                    </div>

                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Products</h2>
                        <div class="single-sidebar">
                            @foreach ($top_products as $item)
                                <div class="thubmnail-recent">
                                    <img src="{{ asset('ustora/img/' . $item->thumbnail) }}" class="recent-thumb"
                                        alt="">
                                    <h2><a
                                            href="{{ Route('frontend.single-product', ['id' => $item->id]) }}">{{ $item->name }}</a>
                                    </h2>
                                    <div class="product-sidebar-price">
                                        <ins>{{ $item->price }}</ins>
                                        {{-- <del>$800.00</del> --}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="product-content-right">
                        <div class="product-breadcroumb">
                            <a href="{{ route('frontend.home') }}">Home</a>
                            <a href="{{ route('frontend.category') }}">Category Name</a>
                            <a href="{{ Route('frontend.single-product', ['id' => $product->id]) }}">Sony Smart TV -
                                2015</a>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="product-images">
                                    <div class="product-main-img">
                                        <img src="{{ asset('ustora/img/' . $product->thumbnail) }}" alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="product-inner">
                                    <h2 class="product-name">{{ $product->name }}</h2>
                                    <div class="product-inner-price">
                                        <ins>{{ $product->price }}</ins>
                                        {{-- <del>$100.00</del> --}}
                                    </div>

                                    <form action="" class="cart" method="POST">
                                        @csrf
                                        <div class="quantity">
                                            <input type="number" size="4" class="input-text qty text"
                                                title="Qty" value="1" name="quantity" min="1"
                                                step="1">
                                        </div>
                                        <button class="add_to_cart_button" type="submit">Add to cart</button>
                                    </form>

                                    <div class="product-inner-category">
                                        <p>Category: <a href="#">{{ $category }}</a>.
                                        </p>
                                    </div>

                                    <div role="tabpanel">
                                        <ul class="product-tab" role="tablist">
                                            <li role="presentation" class="active"><a href="#home"
                                                    aria-controls="home" role="tab"
                                                    data-toggle="tab">Description</a></li>
                                            <li role="presentation"><a href="#profile" aria-controls="profile"
                                                    role="tab" data-toggle="tab">Reviews</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="home">
                                                <h2>Product Description</h2>
                                                <p>{{ $product->description }}</p>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade" id="profile">
                                                <h2>Reviews</h2>
                                                <div class="submit-review">
                                                    <p><label for="name">Name</label> <input name="name"
                                                            type="text"></p>
                                                    <p><label for="email">Email</label> <input name="email"
                                                            type="email"></p>
                                                    <div class="rating-chooser">
                                                        <p>Your rating</p>

                                                        <div class="rating-wrap-post">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        </div>
                                                    </div>
                                                    <p><label for="review">Your review</label>
                                                        <textarea name="review" id="" cols="30" rows="10"></textarea>
                                                    </p>
                                                    <p><input type="submit" value="Submit"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="related-products-wrapper">
                            <h2 class="related-products-title">Related Products</h2>
                            <div class="related-products-carousel">
                                @foreach ($products as $item)
                                    <div class="single-product">
                                        <div class="product-f-image">
                                            <img src="{{ asset('ustora/img/' . $item->thumbnail) }}" alt="">
                                            <div class="product-hover">
                                                <a href="{{ route('frontend.single-product.order', ['id' => $item->id]) }}"
                                                    class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> Add
                                                    to cart</a>
                                                <a href="{{ route('frontend.single-product', ['id' => $item->id]) }}"
                                                    class="view-details-link"><i class="fa fa-link"></i>
                                                    See details</a>
                                            </div>
                                        </div>

                                        <h2><a href="">{{ $item->name }}</a></h2>

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
        </div>
    </div>

    <x-footer></x-footer>
</x-guest-layout>
