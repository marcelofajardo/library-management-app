@extends('layouts.main')

@section('page_title') Download QR codes @endsection
@section('content_header') Download QR codes @endsection

@section('content')
    <div class="card">
        <div class="card-header">
        <!-- /.card-header -->
        <div class="card-body p-0">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-books" role="tab" aria-controls="pills-book" aria-selected="true">
                        Books
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-users" role="tab" aria-controls="pills-user" aria-selected="false">
                        Users
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-books" role="tabpanel" aria-labelledby="pills-book-tab">
                    @include('download.tab1')
                </div>
                <div class="tab-pane fade" id="pills-users" role="tabpanel" aria-labelledby="pills-user-tab">
                    @include('download.tab2')
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
@endsection

@section('additional_scripts')
    <script>
        $(document).ready(function() {

            $('.' + 'books_slt').select2({
                placeholder: 'Select books',
                theme: "classic"
            });

            $('.' + 'users_slt').select2({
                placeholder: 'Select users',
                theme: "classic"
            });

        });
    </script>
@endsection

