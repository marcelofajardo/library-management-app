<div class="col-12">
    <div class="card">
        <div class="card">
            <div class="card-header">
                {{-- <input type="text">
                <input type="text">
                <input type="text">
                <input type="text">
                <input type="text"> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>ISBN</th>
                            <th>User</th>
                            <th>Deadline</th>
                            <th>Returned</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookLendings as $key => $bookLending)
                            <tr class="clickable-row" data-href="{{ route('book-lendings.show', ['book_lending' => $bookLending->id]) }}">
                                <td>{{ $recordsOnPage + $key + 1 }}</td>
                                <td>{{ $bookLending->book_copy->book->title }}</td>
                                <td>{{ $bookLending->book_copy->book->author->name }}</td>
                                <td>{{ $bookLending->book_copy->book->isbn }}</td>
                                <td>{{ $bookLending->user->name }}</td>
                                <td>{{ $bookLending->formatted_deadline }}</td>
                                <td>
                                    @if ($bookLending->return_date)
                                        <i class="fas fa-check-circle"></i>
                                    @else
                                        <i class="fas fa-times-circle"></i>
                                    @endif
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="9">No books have yet been lent.</td>
                        </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $bookLendings->links() }}
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
