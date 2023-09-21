@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Brands</div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class=" mb-2 d-flex flex-wrap justify-content-end">
                <a class="btn btn-success" href="{{ route('brands.create') }}">Add new</a>
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
                    @if (!empty($brands))
                        @foreach ($brands as $brand)
                            <tr>
                                <td>{{ $brand->id }}</td>
                                <td>{{ $brand->name }}</td>
                                <td>
                                    <a href="" class="btn btn-primary">Edit</a>
                                    <a href="" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{-- pagination --}}
            {{-- {{ $brands->links() }} --}}
        </div>

    </div>
    </div>
@endsection
