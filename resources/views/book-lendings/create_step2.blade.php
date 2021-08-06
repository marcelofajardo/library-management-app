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
    <div class="col-6" id="inputs_div">
        @if ($book_copies != '')
            @foreach ($book_copies as $book_copy)
                @include('book-lendings.card')
            @endforeach

        @endif
        
        @include('book-lendings.buttons')
    </div>
</div>  

@section('additional_scripts')

<script type="text/javascript">
        document.addEventListener("DOMContentLoaded", event => {
            
            let token =  $('meta[name="csrf-token"]').attr('content'); 
            const inputs_div = $('#inputs_div');
            const submit_btn = $('#custom_btn');
            const cancel_btn = $('#back_btn');
            let err_div = $('#errors_div');
            let buttons_div = $('#buttons_div');

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

                            buttons_div.prepend(
                                `
                                <div class="card book-${id}">
                                    <div class="card-header border-0">
                                        <div class="card-tools">
                                            <form action="/book-copies/remove/${id}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-tool remove-btn">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-valign-middle table-sm table-borderless">
                                            <tbody>
                                                <input type="hidden" name="book_copy_id[]" value="${id}">
                                                <tr>
                                                    <td>Title:</td>
                                                    <td>
                                                        <input type="text" disabled class="form-control" value="${title}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Author:</td>
                                                    <td>
                                                        <input type="text" disabled class="form-control" value="${author}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Publisher:</td>
                                                    <td>
                                                        <input type="text" disabled class="form-control" value="${publisher}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Edition:</td>
                                                    <td>
                                                        <input type="text" disabled class="form-control" value="${edition}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Publication date:</td>
                                                    <td>
                                                        <input type="text" disabled class="form-control" value="${publication_date}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Condition:</td>
                                                    <td>
                                                        <input type="text" disabled class="form-control" value="${condition}">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="card-footer"></div>
                                    </div>
                                </div>
                                `
                            );

                            if ((buttons_div).hasClass('d-none')) {
                               (buttons_div).removeClass('d-none');
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
                        let err = res['responseJSON']['message'];

                        if (res['status'] == 418) {
                            let splitMsg = err.split('.');
                            let index = splitMsg[1];
                            err = splitMsg[0] + '.';

                            // add border around the book in question
                            $('.book-' + index).addClass('border border-danger');
                        }

                        err_div.addClass('alert-danger');
                        err_div.append(`<li>${err}</li>`);
                    }
                });
            });
        });

    </script>
@endsection

@endsection