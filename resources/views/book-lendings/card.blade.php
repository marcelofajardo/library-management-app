<div class="card">
    <div class="card-header border-0">
        <div class="card-tools">
            <form action="/book-copies/remove/{{ $book_copy->id }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-tool remove-btn">
                    <i class="fas fa-times"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-valign-middle table-sm table-borderless">
            <tbody>
                <input type="hidden" name="book_copy_id[]" value="{{ $book_copy->id }}">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" disabled class="form-control" value="{{ $book_copy->book->title }}">
                    </td>
                </tr>
                <tr>
                    <td>Author:</td>
                    <td>
                        <input type="text" disabled class="form-control" value="{{ $book_copy->book->author->name }}">
                    </td>
                </tr>
                <tr>
                    <td>Publisher:</td>
                    <td>
                        <input type="text" disabled class="form-control" value="{{ $book_copy->book->publisher->name }}">
                    </td>
                </tr>
                <tr>
                    <td>Edition:</td>
                    <td>
                        <input type="text" disabled class="form-control" value="{{ $book_copy->edition }}">
                    </td>
                </tr>
                <tr>
                    <td>Publication date:</td>
                    <td>
                        <input type="text" disabled class="form-control" value="{{ $book_copy->publication_date }}">
                    </td>
                </tr>
                <tr>
                    <td>Condition:</td>
                    <td>
                        <input type="text" disabled class="form-control" value="{{ $book_copy->condition->name }}">
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="card-footer"></div>
    </div>
</div>