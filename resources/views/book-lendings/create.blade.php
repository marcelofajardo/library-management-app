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
{{-- {{ const Instascan = require('instascan'); }} --}}

<div class="row justify-content-center">
    <video id="preview"></video>
</div>    

@section('additional_scripts')

    <script type="text/javascript">
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        scanner.addListener('scan', function (content) {
          console.log(content);
        });
        Instascan.Camera.getCameras().then(function (cameras) {
          if (cameras.length > 0) {
            scanner.start(cameras[0]);
          } else {
            console.error('No cameras found.');
          }
        }).catch(function (e) {
          console.error(e);
        });

    </script>
@endsection

@endsection