<div id="buttons_div">
    <button 
    class="btn btn-primary float-right mt-2 {{ $book_copies != '' ? '' : 'd-none' }}" 
    id="custom_btn"
    >
        Submit
    </button>
    <a 
        href="{{ route('book-lendings-create-step1') }}" 
        type="button" 
        class="btn btn-secondary float-right mr-1 mt-2 {{ $book_copies != '' ? '' : 'd-none' }}" 
        id="back_btn"
    >
    Back
    </a>
</div>