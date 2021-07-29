@extends('layouts.main')

@section('page_title') Books @endsection
@section('content_header') Books @endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-primary float-right" href={{ route('books.create') }}>
                        Add a book
                    </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Publisher</th>
                                <th>ISBN</th>
                                <th>Available quantity</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($books as $key => $book)
                                <tr>
                                    <td>{{ (($books::resolveCurrentPage() - 1) * App\Models\Book::PER_PAGE)  + $key + 1  }}.</td>
                                    <td>
                                        <a href={{ route('books.show', ['book' => $book->id]) }}>
                                            {{ $book->title }}
                                        </a>    
                                    </td>
                                    <td>{{ $book->author->name }}</td>
                                    <td>{{ $book->publisher->name }}</td>
                                    <td>{{ $book->isbn }}</td>
                                    <td>{{ $book->available_quantity }}</td>
                                    <td>
                                        <a href="/books/{{ $book->id }}/edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td></td>
                                <td>No books have yet been added.</td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $books->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>    

@endsection