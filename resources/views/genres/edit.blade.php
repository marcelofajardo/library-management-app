@extends('layouts.main')
@section('page_title')
    Update genre details
@endsection
@section('content_header')
    Update genre details
@endsection

@section('content')

<form action="/genres/{{ $genre->id }}" method="POST">
    <div class="row">
        <div class="col-5">
            @method('PUT')
            @csrf
            <input 
                type="text" 
                value="{{ $genre->name }}" 
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