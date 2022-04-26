<form action="{{ route('books.pdf') }}" method="POST">
    <div class="row">
        @csrf
        <div class="col-12 col-md-9 mb-3 mb-md-0">
            <select class="books_slt m-0" name="book_ids[]" multiple="multiple" style="width: 100%">
                @foreach ($books as $book)
                    <option value="{{$book->id}}">{{ $book->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-3">
            <button class="btn btn-primary" type="submit" style="width: 100%">
                Get QR codes
                <i class="fas fa-download ml-1"></i>
            </button>
        </div>
    </div>
</form>
