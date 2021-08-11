<div class="modal fade show" id="return_modal" aria-modal="true" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form 
            action="{{ route('book-lendings.update', ['book_lending' => $bookLending ]) }}" 
            method="POST" 
            id="return_book_form" 
            class="custom"
        >
            @csrf
            @method('PUT')
            <div class="modal-body">
                <input type="hidden" name="id" value="{{ $bookLending->id }}">
                <div class="form-group">
                    <label class="form-check-label">Has the book been damaged?</label>
                    <select class="form-control" onchange="showDiv()" id="damage_select" name="damage_slt">
                      <option value="">-- select --</option>
                      <option value="1">Yes</option>
                      <option value="2">No</option>
                    </select>
                </div>
                <div class="form-group d-none" id="damage_desc">
                    <label class="form-check-label">Describe the damage:</label>
                    <textarea class="form-control" name="damage_desc"></textarea>
                </div>
                <div class="form-group d-none" id="condition_select">
                    <label class="form-check-label">Update book condition:</label>
                    <select class="form-control" name="condition_id">
                        @foreach ($bookConditions as $condition)
                            <option value="{{ $condition->id }}" {{ $condition->id == $bookLending->book_copy->condition_id ? 'selected' : ''}}>{{ $condition->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group d-none" id="damage_fine">
                    <label for="" class="form-check-label">Set damage fine (€):</label>
                    <input type="text" class="form-control" name="condition_fine">
                </div>
                @if ($lateness_fine > 0)
                    <div class="form-group">
                        <label for="" class="form-check-label">Lateness fine (€):</label>
                        <input type="text" class="form-control" value="{{ $lateness_fine }}" id="lateness_fine" name="lateness_fine">
                    </div>
                @endif
                <div class="{{ $lateness_fine > '0' ? "" : "d-none" }}" id="fine_checkbox" >
                    <div class="input-group mb-3 d-flex align-items-center">
                        <p class="my-0 mr-2">The fines have been paid.</p>
                        <input type="checkbox" name="fine_checkbox">
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                <button type="submit" class="btn btn-primary">Confirm return</button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>