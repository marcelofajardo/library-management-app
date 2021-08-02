@extends('layouts.main')

@section('page_title') Book Copy Details @endsection
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">
                    <i class="fas fa-book mr-2"></i>
                    Book details
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td>Title:</td>
                            <td>{{ $book->title }}</td>
                        </tr>
                        <tr>
                            <td>ISBN:</td>
                            <td>{{ $book->isbn }}</td>
                        </tr>
                        <tr>
                            <td>Status:</td>
                            <td>
                                {{ $book->book_status->status }}
                            </td>
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
                            <td>Edition:</td>
                            <td>
                                {{ $bookCopy->edition }}
                            </td>
                        </tr>
                        <tr>
                            <td>Publication date:</td>
                            <td>{{ $bookCopy->formatted_publication_date }}</td>
                        </tr>
                        <tr>
                            <td>Price:</td>
                            <td>{{ $bookCopy->price }} €</td>
                        </tr>
                        <tr>
                            <td>Condition:</td>
                            <td>{{ $bookCopy->condition->name }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection