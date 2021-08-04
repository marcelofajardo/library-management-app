@extends('layouts.main')

@section('page_title') Return Books @endsection
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
    <div class="col-12 mb-3">
        <p>Instructions:</p>
        <p>1. Enable use of camera.</p>
        <p>2. Scan the QR code of a book you wish to return.</p>
    </div>
    <div class="col-12 d-flex justify-content-center">
        <video id="preview"></video>
    </div>
</div>  

@section('additional_scripts')

<script type="text/javascript">
        document.addEventListener("DOMContentLoaded", event => {
            
            let token =  $('meta[name="csrf-token"]').attr('content'); 
            
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
            Instascan.Camera.getCameras().then(cameras => {
                scanner.camera = cameras[cameras.length - 1];
                scanner.start();
            }).catch(e => console.error(e));

            scanner.addListener('scan', content => {
                console.log(content);

                let splitString = content.split('/');
                let borrowed_book_id = splitString[splitString.length - 1];

                $.ajax({
                    'url' : '/book-lendings/redirect/',
                    'type' : 'POST',
                    'data' : {_token:token, borrowed_book_id:borrowed_book_id},
                    'success' : (res) => {
                        window.location.href = '/book-lendings/' + res['lending_id'];
                    },
                    'error' : (res) => {
                        console.log('error', res);
                    }
                });
            });

            $('#submit_form_btn').on('click', function(e) {
                e.preventDefault();
                let book_copy_val = book_copy_id.val();
                let user_val = user_id.val();

                $.ajax({
                    'url' : '/book-lendings',
                    'type' : 'POST',
                    'data' : {_token:token, 'book_copy_id':book_copy_val, 'user_id':user_val},
                    'success' : (res) => {
                        // location.reload();
                        console.log(res);
                    },
                    'error' : (res) => {
                        console.log(res);
                    }
                });
            })
        });

    </script>
@endsection

@endsection