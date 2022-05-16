@extends('layouts.main')
@section('page_title')
    Update publisher details
@endsection

@section('content_header')
    Update publisher details
@endsection

@section('content')
<form action="/publishers/{{ $publisher->id }}" method="POST" id="publisher_edit_form">
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
            <button class="btn btn-primary ml-2" id="form_submit">Update</button>
        </div>
    </div>
</form>
@endsection

@section('additional_scripts')
    <script src="{{ asset('/js/submit.js') }}"></script>
    <script>
        document.getElementById('form_submit').addEventListener('click', function () {
            disableBtnAndSubmitForm(this, 'publisher_edit_form');
        })
    </script>
@endsection
