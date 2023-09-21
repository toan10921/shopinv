@extends('layouts.app')
@section('breadcrumb')
    <a href="{{ route('home') }}">Home</a>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center">List Product</h1>
                        <div class="list-product-wrap row">
                            @foreach ($products as $product)
                                <div class="product-item-outer col-4">
                                    <div class="product-item">
                                        <div class="thumbnail-wrap">
                                            <div class="thumbnail-inner">
                                                {{-- print img tags with source set --}}
                                                @php
                                                    $product_thumbnail = $product->thumbnail ? $product->thumbnail : 'no-thumbnail.jpg';
                                                @endphp
                                                <img src="{{ asset('storage/uploads/' . $product_thumbnail) }}"
                                                    alt="{{ $product->name }}" class="img-fluid">
                                            </div>
                                        </div>
                                        <div class="info-wrap">
                                            <h3><a
                                                    href="{{ route('products.single', ['id' => $product->id]) }}">{{ $product->name }}</a>
                                            </h3>
                                            <p>{{ $product->desc }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
