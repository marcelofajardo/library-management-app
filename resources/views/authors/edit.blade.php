@extends('layouts.main')
@section('page_title')
    Update author details
@endsection
@section('content_header')
    Update author details
@endsection

@section('content')

<div class="row">
    <div class="col-6">
        <form action="/authors/{{ $author->id }}" method="POST">
            @method('PUT')
            @csrf
            <div class="input-group">
                <input 
                    type="text" 
                    value="{{ $author->name }}" 
                    class="form-control @error('name') is-invalid @enderror" 
                    name="name"
                >
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <button class="btn btn-primary ml-2">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection