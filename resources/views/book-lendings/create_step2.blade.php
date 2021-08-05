@extends('layouts.main')

@section('page_title') Lend Books @endsection
@section('content_header') Step 2: Scan book QR @endsection
@section('additional_styles')
<style>
    #preview {
        width: 300px;
        height: 300px;
        outline: 1px solid red;
    }
</style>
@endsection

@section('content')

<div class="row">
    <div class="offset-5 col-6 alert" id="errors_div"></div>
</div>
<div class="row">
    <div class="col-5 justify-content-start">
        <video id="preview"></video>
    </div>
    <div class="col-2" id="labels_div">
        @if ($book_copies != '')
            @foreach ($book_copies as $book_copy)
                <div class="div-{{$book_copy->id}}">
                    <p class="pb-1">Title:</p>
                    <p class="pb-1">Author:</p>
                    <p class="pb-1">Publisher:</p>
                    <p class="pb-1">Edition:</p>
                    <p class="pb-1">Publication date:</p>
                    <p class="mb-5 mb-1">Condition:</p>
                </div>
            @endforeach
        @endif
    </div>
    <div class="col-4">
    
        <form action="{{ route('book-lendings-post-step2') }}" method="POST" id="inputs_form">
            @csrf
            @if ($book_copies != '')
                @foreach ($book_copies as $book_copy)
                    <div class="div-{{$book_copy->id}}">
                        <input type="hidden" name="book_copy_ids[]" value="{{ $book_copy->id }}">
                        <input type="text" disabled class="form-control pb-1" value="{{ $book_copy->book->title }}">
                        <input type="text" disabled class="form-control mb-1" value="{{ $book_copy->book->author->name }}">
                        <input type="text" disabled class="form-control mb-1" value="{{ $book_copy->book->publisher->name }}">
                        <input type="text" disabled class="form-control mb-1" value="{{ $book_copy->edition }}">
                        <input type="text" disabled class="form-control mb-1" value="{{ $book_copy->publication_date }}">
                        <input type="text" disabled class="form-control mb-5" value="{{ $book_copy->condition->name }}">
                    </div>
                @endforeach
            @endif
        
            <button 
                class="btn btn-primary float-right mt-2 {{ $book_copies != '' ? '' : 'd-none' }}" 
                id="custom_btn"
            >
                Submit
            </button>
            <a 
                href="{{ route('book-lendings-create-step1') }}" 
                type="button" 
                class="btn btn-secondary float-right mr-1 mt-2 {{ $book_copies != '' ? '' : 'd-none' }}" 
                id="back_btn"
            >
            Back
            </a>
        </form>
    </div>
</div>  

@section('additional_scripts')

<script type="text/javascript">
        document.addEventListener("DOMContentLoaded", event => {
            
            let token =  $('meta[name="csrf-token"]').attr('content'); 
            const inputs_div = $('#inputs_form');
            const labels_div = $('#labels_div');
            const submit_btn = $('#custom_btn');
            const cancel_btn = $('#back_btn');
            let err_div = $('#errors_div');
            
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
            Instascan.Camera.getCameras().then(cameras => {
                scanner.camera = cameras[cameras.length - 1];
                scanner.start();
            }).catch(e => console.error(e));

            scanner.addListener('scan', content => {
                err_div.removeClass('alert-danger');
                err_div.children().remove();

                $.ajax({
                    'url' : content,
                    'type' : 'POST',
                    'data' : {_token:token, flag:true},
                    'success' : (res) => {
                        console.log(res);

                        if (res['book']['title'] && res['book']['author']['name']) {

                            let id = res['id'];
                            let title = res['book']['title'];
                            let author = res['book']['author']['name'];
                            let publisher = res['book']['publisher']['name'];
                            let edition = res['edition'];
                            let publication_date = res['publication_date'];
                            let condition = res['condition']['name'];

                            labels_div.prepend(
                                `
                                <p>Title:</p>
                                <p>Author:</p>
                                <p>Publisher:</p>
                                <p>Edition:</p>
                                <p>Publication date:</p>
                                <p class="mb-5">Condition:</p>
                                `
                            );

                            inputs_div.prepend(
                                `
                                <input type="hidden" name="book_copy_id[]" value="${id}">
                                <input type="text" disabled class="form-control" value="${title}">
                                <input type="text" disabled class="form-control" value="${author}">
                                <input type="text" disabled class="form-control" value="${publisher}">
                                <input type="text" disabled class="form-control" value="${edition}">
                                <input type="text" disabled class="form-control" value="${publication_date}">
                                <input type="text" disabled class="form-control mb-5" value="${condition}">
                                `
                            );

                            if ((submit_btn).hasClass('d-none')) {
                               (submit_btn).removeClass('d-none');
                            }
                            if ((cancel_btn).hasClass('d-none')) {
                               (cancel_btn).removeClass('d-none');
                            }
                        }
                        
                    },
                    'error' : (res) => {
                        let err = res['responseJSON']['message'];
                        err_div.addClass('alert-danger');
                        err_div.append(`<li>${err}</li>`);
                    }
                });
            });

            $('#custom_btn').on('click', function(e)  {
                e.preventDefault();

                $.ajax({
                    'url' : '/book-lendings/post-two',
                    'type' : 'POST',
                    'data' : {_token:token},
                    'success' : (res) => {
                        console.log(res);
                        window.location.href = '/';
                    },
                    'error' : (res) => {
                        console.log(res);
                    }
                });

            });
        });

    </script>
@endsection

@endsection