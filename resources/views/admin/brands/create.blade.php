@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Add Brands</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form action="{{ route('brands.store') }}" method="post">
                {{-- put method --}}
                @csrf
                {{-- @method('PUT') --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Brand Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter brand name">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button
            </form>
        </div>
    </div>
@endsection
