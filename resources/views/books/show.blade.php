@extends('layouts.main')

@section('page_title') Books @endsection
{{-- @section('content_header') Users @endsection --}}

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
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Price</th>
                                    <th>Date of purchase</th>
                                    <th>Publication date</th>
                                    <th>Condition</th>
                                    <th>Edition</th>
                                    <th>Status</th>
                                    <th colspan="3"></th>
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
                                        <span class="badge {{ $copy->book_status->icon}}"">{{ $copy->book_status->status }}</span>
                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('qrcode.download', ['bookCopy' => $copy]) }}"
                                            class="btn btn-sm btn-info call_qr_modal"
                                        >
                                            QR Code
                                            <i class="fas fa-download ml-1"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <button
                                            data-target="#editBookCopyModal"
                                            class="btn btn-sm btn-primary call_edit_modal"
                                            data-toggle="modal"
                                            data-id="{{ $copy->id }}"
                                            data-price = "{{ $copy->price }}"
                                            data-purchase = "{{ $copy->date_of_purchase }}"
                                            data-publ = "{{ $copy->publication_date }}"
                                            data-cond = "{{ $copy->condition->id }}"
                                            data-edition = "{{ $copy->edition }}"
                                            data-status = "{{ $copy->book_status_id }}"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <form action="{{ route('book-copies.destroy', ['book_copy' => $copy->id]) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-sm btn-danger" type="submit">
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
@include('books/modals.copies')
@include('books/modals.edit_book_copy')

@section('additional_scripts')
    <script src="{{ asset('/js/books/show.js') }}"></script>
@endsection

@endsection
