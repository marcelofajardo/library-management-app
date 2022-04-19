<tr class="clickable-row" data-href="{{ route('books.show', ['book' => $book->id]) }}">
    <td>{{ (($currentPage * App\Models\Book::PER_PAGE) + $key + 1) }}.</td>
    <td>{{ $book->title }}</td>
    <td>{{ $book->author->name }}</td>
    <td>{{ $book->publisher->name }}</td>
    <td>{{ $book->isbn }}</td>
    <td>{{ $book->book_copies_count }}</td>
    <td>
        <a href="/books/{{ $book->id }}/edit">
            <i class="fas fa-edit"></i>
        </a>
    </td>
    <td>
        <form action="{{ route('books.destroy', ['book' => $book->id]) }}" method="POST">
            @method('DELETE')
            @csrf
            <button type="submit" class="delete-btn">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    </td>
</tr>
