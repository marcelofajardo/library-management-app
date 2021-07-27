@extends('layouts.main')

@section('page_title') Books @endsection
{{-- @section('content_header') Users @endsection --}}

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="fas fa-book mr-2"></i>
                    Book details
                </h3>
                <button 
                    class="btn btn-primary float-right" 
                    data-toggle="modal" 
                    data-target="#copies_modal"
                    @if ($book->requiredCopies() == '0')
                        disabled
                    @endif
                >
                    Add copies
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td>ID</td>
                            <td>{{ $book->id }}</td>
                        </tr>
                        <tr>
                            <td>Title:</td>
                            <td>{{ $book->title }}</td>
                        </tr>
                        <tr>
                            <td>ISBN:</td>
                            <td>{{ $book->isbn }}</td>
                        </tr>
                        <tr>
                            <td>Author:</td>
                            <td>{{ $book->author->name }}</td>
                        </tr>
                        <tr>
                            <td>Publisher:</td>
                            <td>{{ $book->publisher->name }}</td>
                        </tr>
                        <tr>
                            <td>Available copies:</td>
                            <td>
                                {{ $book->available_quantity }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    @if ($copies != '')
        
    @foreach ($copies as $key => $copy)
    <div class="col-4">
        <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="fas fa-book mr-2"></i>
                    Copy {{ $key+1 }}
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td>ID</td>
                            <td>{{ $copy->id }}</td>
                        </tr>
                        <tr>
                            <td>Price:</td>
                            <td>{{ $copy->price }} €</td>
                        </tr>
                        <tr>
                            <td>Date of purchase:</td>
                            <td>{{ $copy->date_of_purchase }}</td>
                        </tr>
                        <tr>
                            <td>Publication date:</td>
                            <td>{{ $copy->publication_date }}</td>
                        </tr>
                        <tr>
                            <td>Condition:</td>
                            <td>{{ $copy->condition->name }}</td>
                        </tr>
                        <tr>
                            <td>Edition:</td>
                            <td>
                                {{ $copy->edition }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    @endforeach
    @endif
</div>
@include('books/modals.copies')

@section('additional_scripts')
    <script src="{{ asset('/js/books/show.js') }}"></script>
@endsection

@endsection