@extends('layouts.main')
@section('page_title')
    Update publisher details
@endsection
@section('content_header')
    Update publisher details
@endsection

@section('content')

<form action="/publishers/{{ $publisher->id }}" method="POST">
    <div class="row">
        <div class="col-9 col-md-5">
            @method('PUT')
            @csrf
            <input
                type="text"
                value="{{ $publisher->name }}"
                class="form-control @error('name') is-invalid @enderror"
                name="name"
            >
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-1">
            <button class="btn btn-primary ml-2">Update</button>
        </div>
    </div>
</form>
@endsection
