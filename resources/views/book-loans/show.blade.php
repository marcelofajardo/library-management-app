@extends('layouts.main')

@section('page_title') Book Loan Details @endsection

@section('content_header') Book Loan Details @endsection

@section('additional_styles')
    <style>
        form.custom {
            display: inline-block;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header ui-sortable-handle">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h3 class="card-title mb-3 mb-md-0">
                                <i class="fas fa-info-circle mr-2"></i>
                                Loan
                            </h3>
                        </div>
                        <div class="col-12 col-md-6 d-flex flex-row justify-content-center justify-content-md-end">
                            <div class="card-tools">
                                <form
                                    action="{{ route('book-loans.extend-deadline', ['bookLoan' => $bookLoan]) }}"
                                    method="POST"
                                    id="extend_deadline_form"
                                    class="custom"
                                >
                                    @csrf
                                    <button
                                        class="btn btn-info"
                                        type="submit"
                                        id="extend_deadline_btn"
                                        @if ($bookLoan->return_date != null) disabled @endif
                                    >
                                        Extend deadline
                                    </button>
                                </form>
                                <button
                                    data-toggle="modal"
                                    data-target="#return_modal"
                                    class="btn btn-primary"
                                    @if ($bookLoan->return_date != null) disabled @endif
                                >
                                    Return book
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body py-2">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td>Deadline:</td>
                                <td>{{ $bookLoan->formatted_deadline }}</td>
                            </tr>
                            <tr>
                                <td>Lateness fine:</td>
                                <td>{{ $latenessFine }} €</td>
                            </tr>
                            @if ($bookLoan->returned)
                                <tr>
                                    <td>Damage fine:</td>
                                    <td>
                                        @if ($bookLoan->condition_fine)
                                            {{ $bookLoan->condition_fine }} €
                                        @else 0€
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Damage description:</td>
                                    <td>
                                        @if ($bookLoan->damage_desc)
                                            {{ $bookLoan->damage_desc }}
                                        @else N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Return date:</td>
                                    <td>
                                        @if ($bookLoan->return_date)
                                            {{ $bookLoan->formatted_return_date }}
                                        @else /
                                        @endif
                                    </td>
                                </tr>
                            @endif
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
                            <input type="hidden" value="{{ $lendingPeriod }}" id="lending_period_id">
                            <tr>
                                <td>Title:</td>
                                <td>
                                    <a href="{{ route('books.show', ['book' => $bookLoan->book_copy->book->id]) }}">
                                        {{ $bookLoan->book_copy->book->title }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>ISBN:</td>
                                <td>{{ $bookLoan->book_copy->book->isbn }}</td>
                            </tr>
                            <tr>
                                <td>Author:</td>
                                <td>{{ $bookLoan->book_copy->book->author->name }}</td>
                            </tr>
                            <tr>
                                <td>Publisher:</td>
                                <td>{{ $bookLoan->book_copy->book->publisher->name }}</td>
                            </tr>
                            <tr>
                                <td>Edition:</td>
                                <td>
                                    {{ $bookLoan->book_copy->edition }}
                                </td>
                            </tr>
                            <tr>
                                <td>Publication date:</td>
                                <td>{{ $bookLoan->book_copy->formatted_publication_date }}</td>
                            </tr>
                            <tr>
                                <td>Price:</td>
                                <td>{{ $bookLoan->book_copy->price }} €</td>
                            </tr>
                            <tr>
                                <td>Condition:</td>
                                <td>{{ $bookLoan->book_copy->condition->name }}</td>
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
                                    <a href="{{ route('users.show', ['user' => $bookLoan->user->id]) }}">
                                        {{ $bookLoan->user->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td>{{ $bookLoan->user->email }}</td>
                            </tr>
                            <tr>
                                <td>Role:</td>
                                <td>{{ $bookLoan->user->role->name }}</td>
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
    @include('book-loans/modals.return')
@endsection

@section('additional_scripts')
    <script src="{{ asset('js/book-loans/show.js') }}"></script>
@endsection
