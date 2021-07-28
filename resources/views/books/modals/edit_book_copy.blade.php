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
                <input 
                    type="text" 
                    class="form-control" 
                    name="price"
                    id="price" 
                >
            </div>
            <div class="col-12 mt-2">
                <label for="">Date of purchase:</label>
                <input 
                    type="date" 
                    class="form-control" 
                    name="date_of_purchase" 
                    id="date_of_purchase"
                >
            </div>
            <div class="col-12 mt-2">
                <label for="">Date of publication:</label>
                <input 
                    type="date" 
                    class="form-control" 
                    name="publication_date" 
                    id="publication_date"
                >
            </div>
            <div class="col-12 mt-2">
                <input 
                    type="numeric" 
                    class="form-control" 
                    name="edition" 
                    placeholder="Edition"
                    id="edition"
                >
            </div>
            <div class="col-12 mt-2">
                <select name="condition_id" class="form-control mb-2" id="condition_id">
                    <option value="">-- Book condition --</option>
                    @foreach ($conditions as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
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