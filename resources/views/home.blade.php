@extends('layouts.main')

@section('additional_styles')
    <style>
        .clickable-row{ cursor: pointer; }
    </style>
@endsection

@section('content')
<div class="row justify-content-center">
    @include('book-loans.index')
</div>
@endsection
