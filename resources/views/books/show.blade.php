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

    @forelse ($book->book_copies as $key => $copy)
        <div class="col-4">
            <div class="card">
                <div class="card-header ui-sortable-handle">
                    <h3 class="card-title">
                        <i class="fas fa-book mr-2"></i>
                        Copy {{ $key + 1 }}
                    </h3>
                    <div class="card-tools">
                        <a 
                            href="{{ route('qrcode.download', ['bookCopy' => $copy]) }}"
                            class="btn btn-sm btn-info call_qr_modal"
                        >
                            QR Code
                            <i class="fas fa-download ml-1"></i>
                        </a>
                        <button
                            data-target="#editBookCopyModal"
                            class="btn btn-sm btn-primary call_edit_modal"
                            data-toggle="modal"
                            data-id="{{ $copy->id }}"
                            data-price = {{ $copy->price }}
                            data-purchase = {{ $copy->date_of_purchase }}
                            data-publ = {{ $copy->publication_date }}
                            data-cond = {{ $copy->condition->id }}
                            data-edition = {{ $copy->edition }}
                        >
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
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
                                <td>{{ $copy->formatted_purchase_date }}</td>
                            </tr>
                            <tr>
                                <td>Publication date:</td>
                                <td>{{ $copy->formatted_publication_date }}</td>
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
                            <tr>
                                <td>Status:</td>
                                <td>
                                    <span class="badge {{ $copy->book_status->icon}}"">{{ $copy->book_status->status }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>QR Code:</td>
                                <td>
                                    {!! QrCode::generate(App\Models\BookCopy::QR_BASE_URL.strval($copy->id)); !!}
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
    @empty

    @endforelse
</div>
@include('books/modals.copies')
@include('books/modals.edit_book_copy')

@section('additional_scripts')
    <script src="{{ asset('/js/books/show.js') }}"></script>
@endsection

@endsection