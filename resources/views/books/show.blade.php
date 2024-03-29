@extends('layouts.main')

@section('page_title') Books @endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">
                    <i class="fas fa-book mr-2"></i>
                    Book details
                </h3>
                <button
                    class="btn btn-primary float-right"
                    data-toggle="modal"
                    data-target="#copies_modal"
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
                            <td>Number of copies:</td>
                            <td>
                                {{ $book->book_copies_count }}
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
                        Copies
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Price</th>
                                    <th>Date of purchase</th>
                                    <th>Publication date</th>
                                    <th>Condition</th>
                                    <th>Edition</th>
                                    <th>Status</th>
                                    <th colspan="2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($book->book_copies as $key => $copy)
                                <tr>
                                    <td>{{ $copy->id }}</td>
                                    <td>{{ $copy->price }} €</td>
                                    <td>{{ $copy->formatted_purchase_date }}</td>
                                    <td>{{ $copy->formatted_publication_date }}</td>
                                    <td>{{ $copy->condition->name }}</td>
                                    <td>{{ $copy->edition }}</td>
                                    <td>
                                        <span class="badge {{ $copy->book_status->icon}}">{{ $copy->book_status->status }}</span>
                                    </td>
                                    <td>
                                        <button
                                            data-target="#editBookCopyModal"
                                            class="btn btn-sm btn-primary call_edit_modal"
                                            data-toggle="modal"
                                            data-id="{{ $copy->id }}"
                                            data-price = "{{ $copy->price }}"
                                            data-purchase = "{{ $copy->date_of_purchase->format('Y-m-d') }}"
                                            data-publ = "{{ $copy->publication_date->format('Y-m-d') }}"
                                            data-cond = "{{ $copy->condition->id }}"
                                            data-edition = "{{ $copy->edition }}"
                                            data-status = "{{ $copy->book_status_id }}"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <form
                                            action="{{ route('book-copies.destroy', ['book_copy' => $copy->id]) }}"
                                            method="POST"
                                            id="form_{{ $copy->id }}"
                                        >
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-sm btn-danger" type="button" onclick="deleteElement(event, {{ $copy->id }})">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix"></div>
                <!-- /.card-body -->
            </div>
        </div>
</div>
@include('books/modals.new_book_copy')
@include('books/modals.edit_book_copy')

@section('additional_scripts')
    <script src="{{ asset('/js/books/show.js') }}"></script>
    <script src="{{ asset('/js/delete.js') }}"></script>
@endsection

@endsection
