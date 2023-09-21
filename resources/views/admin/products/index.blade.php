@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">products</div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class=" mb-2 d-flex flex-wrap justify-content-end">
                <a class="btn btn-success" href="{{ route('products.create') }}">Add new</a>
            </div>

            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($products))
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <a href="{{ route('products.edit', ['product' => $product->id]) }}"
                                        class="btn btn-primary">Edit</a>
                                    <button data-id="{{ $product->id }}" type="button"
                                        class="btn-delete-product btn btn-danger">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <form id="form_delete_product" method="post" data-url="{{route('products.index')}}" action="{{route('products.destroy' , ['product' => 0])}}" style="display: none">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" id="delete-id">
                <input type="submit" id="delete-submit">
            </form>
            {{-- pagination --}}
            {{ $products->links() }}
        </div>
    </div>
    </div>
@endsection
