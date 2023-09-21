@extends('layouts.app')
@section('breadcrumb')
    <a href="{{ route('home') }}">Home</a> - <a href="#">{{ $brand->name }}</a> - <a
        href="#">{{ $product->name }}</a>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-6 col-img">
                        <div class="thumbnail-wrap">
                            <div class="thumbnail-inner mb-3">
                                @php
                                    $product_thumbnail = $product->thumbnail ? $product->thumbnail : 'no-thumbnail.jpg';
                                @endphp
                                <img src="{{ asset('storage/uploads/' . $product_thumbnail) }}" alt="{{ $product->name }}"
                                    class="img-fluid">
                            </div>
                            <div class="product-galleries  d-flex flex-wrap justify-content-center"">
                                @foreach ($image_galleries as $gallery)
                                    <div class="gallery-item">
                                        <img src="{{ asset('storage/uploads/' . $gallery->image_path) }}" class="img-fluid">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    <div class="col-6 col-info">
                        <h2 class="d-flex justify-content-between"><strong>{{ $product->name }} </strong> <strong>Price:
                                {{ $product->price }}</strong></h2>

                        <p><strong>Brand: </strong>{{ $brand->name }}</p>
                        <p><strong>Product Description:</strong> {{ $product->desc }}</p>
                        <div class="d-flex flex-wrap deli-wrap mb-5">
                            <div class="item">Description</div>
                            <div class="item">Delivery</div>
                            <div class="item">Guarantees Payment</div>
                        </div>
                        <div class="add-cart-wrap d-flex flex-wrap align-items-center">
                            <label class="me-3 mb-0">Amount</label>
                            <div class="input-wrap quantity-wrap  me-3" style="max-width: 80px">
                                <button class="btn btn-minus">-</button>
                                <input type="text" pattern="[0-9]*" value="1" class="form-control quantity"
                                    id="amount">
                                <button class="btn btn-plus">+</button>
                            </div>
                            <button class="btn btn-primary btn-add-cart" data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                                data-thumbnail="{{ asset('storage/uploads/' . $product_thumbnail) }}">Add to cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
