@extends('layouts.main')

@section('page_title') Scan QRs @endsection
@section('content_header') Search by QR code @endsection
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

<div class="row justify-content-center">
    <video id="preview"></video>
</div>    

@section('additional_scripts')

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", event => {
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
            Instascan.Camera.getCameras().then(cameras => {
                scanner.camera = cameras[cameras.length - 1];
                scanner.start();
            }).catch(e => console.error(e));

            scanner.addListener('scan', content => {
                window.location.href = content;
                console.log(content);
            });
        });
    </script>

@endsection

@endsection