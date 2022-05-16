@extends('layouts.main')
@section('page_title')
    Update author details
@endsection
@section('content_header')
    Update author details
@endsection

@section('content')

<div class="row">
    <div class="col-12 col-md-6">
        <form action="/authors/{{ $author->id }}" method="POST" id="author_edit_form">
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
                <button class="btn btn-primary ml-2" id="form_submit">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('additional_scripts')
    <script src="{{ asset('/js/submit.js') }}"></script>
    <script>
        document.getElementById('form_submit').addEventListener('click', function () {
            disableBtnAndSubmitForm(this, 'author_edit_form');
        })
    </script>
@endsection
