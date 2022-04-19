<div class="modal fade show" id="editBookCopyModal" aria-modal="true" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="col-12 mt-2">
                <label for="">Price:</label>
                <input
                    type="text"
                    class="form-control"
                    name="price"
                    id="price_edit"
                >
            </div>
            <div class="col-12 mt-2">
                <label for="">Date of purchase:</label>
                <input
                    type="date"
                    class="form-control"
                    name="date_of_purchase"
                    id="date_of_purchase_edit"
                >
            </div>
            <div class="col-12 mt-2">
                <label for="">Date of publication:</label>
                <input
                    type="date"
                    class="form-control"
                    name="publication_date"
                    id="publication_date_edit"
                >
            </div>
            <div class="col-12 mt-2">
                <label for="">Edition:</label>
                <input
                    type="numeric"
                    class="form-control"
                    name="edition"
                    placeholder="Edition"
                    id="edition_edit"
                >
            </div>
            <div class="col-12 mt-2">
                <label for="">Book condition:</label>
                <select id="condition_id_edit" class="form-control mb-2" name="condition_id">
                    @foreach ($conditions as $condition)
                        <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 mt-2">
                <label for="">Book status:</label>
                <select name="book_status_id" class="form-control mb-2" id="book_status_id_edit">
                    @foreach ($book_statuses as $book_status)
                        <option value="{{ $book_status->id }}">{{ $book_status->status }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer justify-content-end">
          <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
          <button type="button" class="btn btn-primary" id="edit_modal_submit">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
