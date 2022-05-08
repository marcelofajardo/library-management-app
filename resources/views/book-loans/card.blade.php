<div class="card">
    <div class="card-header border-0"></div>
    <div class="card-body p-0 table-responsive">
        <table class="table table-valign-middle table-sm table-borderless">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Edition</th>
                    <th>Condition</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="table_body_id">
                @if ($book_copies != '')
                    @foreach ($book_copies as $key => $book_copy)
                        <tr class="book-{{ $book_copy->id }}">
                            <input type="hidden" name="book_copy_id[]" value="{{ $book_copy->id }}">
                            <td>
                                <input type="text" disabled class="form-control" value="{{ $book_copy->book->title }}">
                            </td>
                            <td>
                                <input type="text" disabled class="form-control" value="{{ $book_copy->book->author->name }}">
                            </td>
                            <td>
                                <input type="text" disabled class="form-control" value="{{ $book_copy->book->publisher->name }}">
                            </td>
                            <td>
                                <input type="text" disabled class="form-control" value="{{ $book_copy->edition }}">
                            </td>
                            <td>
                                <input type="text" disabled class="form-control" value="{{ $book_copy->condition->name }}">
                            </td>
                            <td>
                                <form action="/book-copies/remove/{{ $book_copy->id }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-tool remove-btn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="card-footer"></div>
    </div>
</div>
