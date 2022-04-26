@extends('layouts.main')

@section('page_title') Lend Books @endsection
@section('content_header') Step 1: Scan user QR @endsection
@section('content')

@section('additional_styles')
<style>
    #preview {
        width: 250px;
        height: 250px;
        outline: 1px solid red;
    }

    @media(min-width: 600px) {
        #preview {
            width: 300px;
            height: 300px;
        }
    }
</style>
@endsection
<div class="row">
    <div class="col-12 offset-md-5 col-md-6 alert mb-1" id="errors_div"></div>
</div>
<div class="row">
    <div class="col-12 col-md-5 d-flex flex-row justify-content-center justify-content-md-start mb-4 mb-md-0">
        <video id="preview"></video>
    </div>
    <div class="col-4 col-md-2">
        <p>Full name:</p>
        <p>Email:</p>
        <p>Role:</p>
    </div>
    <div class="col-8 col-md-4 mb-5">
        <form method="POST" action="{{ route('book-lendings-post-step1') }}">
            <input type="hidden" name="user_id" id="user_id" value="{{ $user != '' ? $user->id : '' }}">
            <input type="text" disabled class="form-control mb-1" id="name_id" value="{{ $user != '' ? $user->name : '' }}">
            <input type="text" disabled class="form-control mb-1" id="email_id" value="{{ $user != '' ? $user->email : '' }}">
            <input type="text" disabled class="form-control mb-1" id="role_id" value="{{ $user != '' ? $user->role->name : '' }}">
            <button class="btn btn-primary float-right mt-2" id="post_user_data">
                Next
            </button>
            <a href="{{ route('home') }}" type="button" class="btn btn-secondary float-right mr-1 mt-2">Cancel</a>
        </form>
        </div>
</div>

@section('additional_scripts')

<script type="text/javascript">
        document.addEventListener("DOMContentLoaded", event => {

            let user_id = $('#user_id');
            let token =  $('meta[name="csrf-token"]').attr('content');
            let err_div = $('#errors_div');

            let pattern = /^https:\/\/unilib-app.herokuapp.com\/users\/qrcode\/read\/\d*$/;

            let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
            Instascan.Camera.getCameras().then(cameras => {
                scanner.camera = cameras[cameras.length - 1];
                scanner.start();
            }).catch(e => console.error(e));

            scanner.addListener('scan', content => {
                // scanner.stop();
                err_div.removeClass('alert-danger');
                err_div.children().remove();

                if (!pattern.test(content)) {
                    err_div.addClass('alert-danger');
                    err_div.append(`<li>Please scan a valid user QR code.</li>`);
                } else {
                    $.ajax({
                        'url' : content,
                        'type' : 'POST',
                        'data' : {_token:token},
                        'success' : (res) => {
                            if (res['name'] && res['email'] && res['role']) {
                                err_div.addClass('alert-success');
                                err_div.append(`<li>User card scanned successfully!</li>`);
                                $('#name_id').val(res['name']);
                                $('#email_id').val(res['email']);
                                $('#role_id').val(res['role']['name']);
                                user_id.val(res['id']);
                            }
                        },
                        'error' : (res) => {
                            let err = res['responseJSON']['message'];
                            err_div.addClass('alert-danger');
                            err_div.append(`<li>${err}</li>`);
                            $('#name_id').val('');
                            $('#email_id').val('');
                            $('#role_id').val('');
                        }
                    });
                }
            });


            $('#post_user_data').on('click', function(e) {
                e.preventDefault();

                let user_val = user_id.val();
                // console.log(user_val);

                $.ajax({
                    'url' : '/book-lendings/post-one',
                    'type' : 'POST',
                    'data' : {_token:token, 'user_id':user_val},
                    'success' : (res) => {
                        window.location.href = '/book-lendings/create-two';
                    },
                    'error' : (res) => {
                        let err = res['responseJSON']['message'];
                        err_div.addClass('alert-danger');
                        err_div.append(`<li>${err}</li>`);
                        $('#name_id').val('');
                        $('#email_id').val('');
                        $('#role_id').val('');
                    }
                });
            })
        });

    </script>
@endsection

@endsection
