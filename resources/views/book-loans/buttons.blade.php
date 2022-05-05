<div id="buttons_div" class="{{ $book_copies != '' ? '' : 'd-none' }}">
    <button 
    class="btn btn-primary float-right mt-2" 
    id="custom_btn"
    >
        Submit
    </button>
    <a 
        href="{{ route('book-lendings-create-step1') }}" 
        type="button" 
        class="btn btn-secondary float-right mr-1 mt-2" 
        id="back_btn"
    >
    Back
    </a>
</div>