@extends('layouts.main')

@section('page_title') Book Lending Details @endsection

@section('content_header') Book Lending Details @endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header ui-sortable-handle">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>
                        Lending
                    </h3>
                    <div class="card-tools">
                        <button class="btn btn-info" id="extend_deadline_btn">
                            Extend deadline
                        </button>
                        <button class="btn btn-primary">
                            Return book
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body py-2">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td>Deadline:</td>
                                <td>{{ $bookLending->formatted_deadline }}</td>
                            </tr>
                            <tr>
                                <td>Fine:</td>
                                <td>{{ $bookLending->fine }} €</td>
                            </tr>
                            <tr>
                                <td>Return date:</td>
                                <td>
                                    @if ($bookLending->return_date != '' || $bookLending->return_date != NULL)
                                        {{ $bookLending->formatted_return_date }}
                                    @else /    
                                    @endif
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
        <div class="col-12">
            <div class="card">
                <div class="card-header ui-sortable-handle">
                    <h3 class="card-title">
                        <i class="fas fa-book mr-2"></i>
                        Book
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body py-2">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td>Title:</td>
                                <td>
                                    <a href="{{ route('books.show', ['book' => $bookLending->book_copy->book->id]) }}">
                                        {{ $bookLending->book_copy->book->title }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>ISBN:</td>
                                <td>{{ $bookLending->book_copy->book->isbn }}</td>
                            </tr>
                            <tr>
                                <td>Author:</td>
                                <td>{{ $bookLending->book_copy->book->author->name }}</td>
                            </tr>
                            <tr>
                                <td>Publisher:</td>
                                <td>{{ $bookLending->book_copy->book->publisher->name }}</td>
                            </tr>
                            <tr>
                                <td>Edition:</td>
                                <td>
                                    {{ $bookLending->book_copy->edition }}
                                </td>
                            </tr>
                            <tr>
                                <td>Publication date:</td>
                                <td>{{ $bookLending->book_copy->formatted_publication_date }}</td>
                            </tr>
                            <tr>
                                <td>Price:</td>
                                <td>{{ $bookLending->book_copy->price }} €</td>
                            </tr>
                            <tr>
                                <td>Condition:</td>
                                <td>{{ $bookLending->book_copy->condition->name }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header ui-sortable-handle">
                    <h3 class="card-title">
                        <i class="fas fa-user mr-2"></i>
                        User
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body py-2">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td>Name:</td>
                                <td>
                                    <a href="{{ route('users.show', ['user' => $bookLending->user->id]) }}">
                                        {{ $bookLending->user->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td>{{ $bookLending->user->email }}</td>
                            </tr>
                            <tr>
                                <td>Role:</td>
                                <td>{{ $bookLending->user->role->name }}</td>
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

@section('additional_scripts')
    <script src="{{ asset('js/book-lendings/show.js') }}"></script>    
@endsection