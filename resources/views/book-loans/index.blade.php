<div class="col-12">
    <div class="row mb-3">
        <div class="col-md-9">
            <h3>Book Loans</h3>
        </div>
        <div class="col-md-3">
            <form action="{{ route('home') }}" method="GET" id="searchForm">
                <input
                    type="text"
                    class="form-control"
                    name="search"
                    placeholder="Search"
                    id="search"
                    value="{{ request('search', '') }}"
                >
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
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
                        @forelse ($bookLoans as $key => $bookLoan)
                            <tr class="clickable-row" data-href="{{ route('book-lendings.show', ['book_lending' => $bookLoan->id]) }}">
                                <td>{{ $recordsOnPage + $key + 1 }}</td>
                                <td>{{ $bookLoan->book_copy->book->title }}</td>
                                <td>{{ $bookLoan->book_copy->book->author->name }}</td>
                                <td>{{ $bookLoan->book_copy->book->isbn }}</td>
                                <td>{{ $bookLoan->user->name }}</td>
                                <td>{{ $bookLoan->formatted_deadline }}</td>
                                <td>
                                    @if ($bookLoan->return_date)
                                        <i class="fas fa-check-circle"></i>
                                    @else
                                        <i class="fas fa-times-circle"></i>
                                    @endif
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="9">No loans with the requested parameters have been found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer clearfix">
            <div class="float-right">
                {{ $bookLoans->links() }}
            </div>
        </div>
        <!-- /.card-body -->
    </div>
</div>

@section('additional_scripts')
    <script>
        // document.getElementById('search').
        $('#search').on('keyup', function (e) {
            $('#searchForm').submit();
        })
    </script>
@endsection
