@extends('layouts.main')

@section('page_title') Lend Books @endsection
@section('content_header') Step 1: Insert user details @endsection
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
    </div>
    <div class="col-4">
        <form method="POST" action="{{ route('book-lendings-post-step1') }}">
            @csrf
            <input type="hidden" name="user_id" id="user_id" value="{{ $user != '' ? $user->id : '' }}">
            <input type="text" disabled class="form-control mb-1" id="name_id" value="{{ $user != '' ? $user->name : '' }}">
            <input type="text" disabled class="form-control mb-1" id="email_id" value="{{ $user != '' ? $user->email : '' }}">
            <input type="text" disabled class="form-control mb-1" id="role_id" value="{{ $user != '' ? $user->role->name : '' }}">
            <button class="btn btn-primary float-right mt-2">
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
            
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
            Instascan.Camera.getCameras().then(cameras => {
                scanner.camera = cameras[cameras.length - 1];
                scanner.start();
            }).catch(e => console.error(e));

            scanner.addListener('scan', content => {
                // console.log(content);

                $.ajax({
                    'url' : content,
                    'type' : 'POST',
                    'data' : {_token:token},
                    'success' : (res) => {
                        if (res['name'] && res['email'] && res['role']) {
                            $('#name_id').val(res['name']);
                            $('#email_id').val(res['email']);
                            $('#role_id').val(res['role']['name']);
                            user_id.val(res['id']);
                        // console.log(user_id.val());
                        }
                    },
                    'error' : (res) => {
                        console.log('error', res);
                    }
                });
            });

            // $('#submit_form_btn').on('click', function(e) {
            //     e.preventDefault();
            //     let user_val = user_id.val();

            //     $.ajax({
            //         'url' : '/book-lendings/post-one',
            //         'type' : 'POST',
            //         'data' : {_token:token, 'user_id':user_val},
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