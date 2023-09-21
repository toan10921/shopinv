@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Update product</div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('brand_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('price')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('desc')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <form action="{{ route('products.update', ['product' => $product->id]) }}" method="post" enctype="multipart/form-data">
                {{-- put method --}}
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input required type="text" class="form-control" id="name" name="name"
                        value="{{ $product->name }}" placeholder="Enter product name">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Product Brand</label>
                    <select name="brand_id" class="form-select" aria-label="Default select example">
                        @foreach ($brands as $brand)
                            <option @if ($brand->id === $product->brand_id) selected @endif value="{{ $brand->id }}">
                                {{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Product Price</label>
                    <input type="number" value="{{ $product->price }}" class="form-control" id="price" name="price"
                        placeholder="Enter product name" required max:100000>
                </div>
                <div class="mb-3">
                    <label for="desc" class="form-label">Product description</label>
                    <textarea class="form-control" id="description" name="desc" rows="3">{{ $product->desc }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file" class="form-control" id="image" name="image"
                        placeholder="Enter product name">
                    @php
                        if ($product->thumbnail) {
                            echo "<img src='" . asset('storage/uploads/' . $product->thumbnail) . "' width='100px' />";
                        }
                    @endphp
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Product Galleries (multiple files)</label>
                    <input type="file" class="form-control" id="image" name="image_galleries[]" multiple
                        placeholder="Enter product galleries (multiple files)">
                    <div class="d-flex flex-wrap">
                        @php
                            if (count($image_galleries) > 0) {
                                foreach ($image_galleries as $gallery) {
                                    echo "<img src='" . asset('storage/uploads/' . $gallery->image_path) . "' width='100px' />";
                                }
                            }
                        @endphp
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
