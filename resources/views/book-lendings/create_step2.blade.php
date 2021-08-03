@extends('layouts.main')

@section('page_title') Lend Books @endsection
@section('content_header') Step 2: Insert book details @endsection
@section('content')

@section('additional_styles')
<style>
    #preview {
        width: 300px;
        height: 300px;
        outline: 1px solid red;
    }
</style>
@endsection

<div class="row">
    <div class="col-5 justify-content-start">
        <video id="preview"></video>
    </div>
    <div class="col-2" id="labels_div">
        @if ($book_copies != '')
            @foreach ($book_copies as $book_copy)
                <p>Title:</p>
                <p>Author:</p>
                <p>Publisher:</p>
                <p>Edition:</p>
                <p>Publication date:</p>
                <p class="mb-5">Condition:</p>
            @endforeach
        @endif
    </div>
    <div class="col-4">
    
        <form action="{{ route('book-lendings-post-step2') }}" method="POST" id="inputs_form">
            @csrf

            @if ($book_copies != '')
                @foreach ($book_copies as $book_copy)
                    <input type="hidden" name="book_copy_ids[]" value="{{ $book_copy->id }}">
                    <input type="text" disabled class="form-control mb-1" value="{{ $book_copy->book->title }}">
                    <input type="text" disabled class="form-control mb-1" value="{{ $book_copy->book->author->name }}">
                    <input type="text" disabled class="form-control mb-1" value="{{ $book_copy->book->publisher->name }}">
                    <input type="text" disabled class="form-control mb-1" value="{{ $book_copy->edition }}">
                    <input type="text" disabled class="form-control mb-1" value="{{ $book_copy->publication_date }}">
                    <input type="text" disabled class="form-control mb-5" value="{{ $book_copy->condition->name }}">
                @endforeach
            @endif
            
            <button 
                class="btn btn-primary float-right mt-2 {{ $book_copies != '' ? '' : 'd-none' }}" 
                id="submit_form_btn"
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
            
            // let book_copy_id = $('#book_copy_id');
            let token =  $('meta[name="csrf-token"]').attr('content'); 
            const inputs_div = $('#inputs_form');
            const labels_div = $('#labels_div');
            const submit_btn = $('#submit_form_btn');
            const cancel_btn = $('#back_btn');
            
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
            Instascan.Camera.getCameras().then(cameras => {
                scanner.camera = cameras[cameras.length - 1];
                scanner.start();
            }).catch(e => console.error(e));

            scanner.addListener('scan', content => {
                console.log(content);

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
                                <p  class="mb-5">Condition:</p>
                                `
                            );
                         

                            inputs_div.prepend(
                                `
                                <input type="hidden" name="book_copy_id[]" value="${id}">
                                <input type="text" disabled class="form-control mb-1" value="${title}">
                                <input type="text" disabled class="form-control mb-1" value="${author}">
                                <input type="text" disabled class="form-control mb-1" value="${publisher}">
                                <input type="text" disabled class="form-control mb-1" value="${edition}">
                                <input type="text" disabled class="form-control mb-1" value="${publication_date}">
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
                        console.log('error', res);
                    }
                });
            });

            // $('#submit_form_btn').on('click', function(e) {
            //     e.preventDefault();
            //     let book_copy_val = book_copy_id.val();
            //     let user_val = user_id.val();

            //     $.ajax({
            //         'url' : '/book-lendings',
            //         'type' : 'POST',
            //         'data' : {_token:token, 'book_copy_id':book_copy_val, 'user_id':user_val},
            //         'success' : (res) => {
            //             // location.reload();
            //             console.log(res);
            //         },
            //         'error' : (res) => {
            //             console.log(res);
            //         }
            //     });
            // })
        });

    </script>
@endsection

@endsection