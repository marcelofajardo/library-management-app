@extends('layouts.main')

@section('page_title') Download QR codes @endsection
@section('content_header') Download QR codes @endsection

@section('content')
    <div class="card">
        <div class="card-header">
        <!-- /.card-header -->
        <div class="card-body p-0">
            <form action="{{ route('download.pdf') }}" method="POST">
                <div class="row">
                    @csrf
                    <div class="col-9">
                        <select class="books_slt m-0" name="book_ids[]" multiple="multiple" style="width: 100%">
                            @foreach ($books as $book)
                                <option value="{{$book->id}}">{{ $book->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <button class="btn btn-primary" type="submit" style="width: 100%">
                            Get QR codes
                            <i class="fas fa-download ml-1"></i>
                        </button>
                    </div>
                </div>  
            </form>
        </div>
        <!-- /.card-body -->
    </div>
@endsection

@section('additional_scripts')
    <script>
        $(document).ready(function() {

        let selects = ['books_slt'];
        selects.forEach(select => {
            $('.' + select).select2({
                placeholder: 'Select books',
                theme: "classic"
            });
        });

        });
    </script>
@endsection

