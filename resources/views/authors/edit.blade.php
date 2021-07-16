@extends('layouts.main')
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
                <input type="text" value="{{ $author->name }}" class="form-control" name="name">
                <button class="btn btn-primary ml-2">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection