@extends('layouts.main')

@section('page_title') Lend Books @endsection
@section('content_header') Lend Books @endsection
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
    <div class="col-2">
        <p>Full name:</p>
        <p>Email:</p>
        <p>Role:</p>
        <p class="mt-5">Title:</p>
        <p>Author:</p>
        <p>Publisher:</p>
        <p>Edition:</p>
        <p>Publication date:</p>
        <p>Condition:</p>
    </div>
    <div class="col-4">
        <form>
            <input type="hidden" name="book_copy_id" id="book_copy_id">
            <input type="hidden" name="user_id" id="user_id">
            <input type="text" disabled class="form-control mb-1" id="name_id">
            <input type="text" disabled class="form-control mb-1" id="email_id">
            <input type="text" disabled class="form-control mb-1" id="role_id">
            <input type="text" disabled class="form-control mb-1 mt-4" id="title_id">
            <input type="text" disabled class="form-control mb-1" id="author_id">
            <input type="text" disabled class="form-control mb-1" id="publisher_id">
            <input type="text" disabled class="form-control mb-1" id="edition_id">
            <input type="text" disabled class="form-control mb-1" id="publication_date_id">
            <input type="text" disabled class="form-control mb-1" id="condition_id">
            <button class="btn btn-primary float-right mt-2" id="submit_form_btn">
                Submit
            </button>
            <a href="{{ route('home') }}" type="button" class="btn btn-secondary float-right mr-1 mt-2">Cancel</a>
        </form>
    </div>
</div>

@section('additional_scripts')

<script type="text/javascript">
        document.addEventListener("DOMContentLoaded", event => {

            let user_id = $('#user_id');
            let book_copy_id = $('#book_copy_id');
            let token =  $('meta[name="csrf-token"]').attr('content');

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
                    'data' : {_token:token},
                    'success' : (res) => {
                        console.log(res);
                        if (res['name'] && res['email'] && res['role']) {
                            $('#name_id').val(res['name']);
                            $('#email_id').val(res['email']);
                            $('#role_id').val(res['role']['name']);
                            user_id.val(res['id']);
                        } else if (res['book']['title'] && res['book']['author']['name']) {
                            $('#title_id').val(res['book']['title']);
                            $('#author_id').val(res['book']['author']['name']);
                            $('#publisher_id').val(res['book']['publisher']['name']);
                            $('#edition_id').val(res['edition']);
                            $('#publication_date_id').val(res['publication_date']);
                            $('#condition_id').val(res['condition']['name']);
                            book_copy_id.val(res['id']);
                        }

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
                    'url' : '/book-loans',
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
