@extends('layouts.main')

@section('additional_styles')
    <style>
        .clickable-row{ cursor: pointer; }
    </style>
@endsection

@section('content')
<div class="row justify-content-center">
    @include('book-lendings.index')
</div>


@endsection

@section('additional_scripts')
    <script src="{{ asset('/js/book-lendings/index.js') }}"></script>
@endsection