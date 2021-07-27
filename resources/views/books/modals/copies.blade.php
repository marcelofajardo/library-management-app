<div class="modal fade show" id="copies_modal" aria-modal="true" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body" id="add_copies_modal_body">
            <form>
                <input type="hidden" id="token_copies" value="{{ csrf_token() }}">
                <input type="hidden" id="book_id" value="{{ $book->id }}">
                <div class="row mb-3">

                @for ($i = 0; $i < $book->requiredCopies(); $i++)
                    <div class="col-12 p-3 mb-3" style="border: 1px solid rgb(186, 179, 179);">
                        <label for="">Copy {{$i + 1}}</label>
                        <div class="col-12 mt-2">
                            <input 
                                type="text" 
                                class="form-control" 
                                name="price[]" 
                                placeholder="Price (€)"
                            >
                        </div>
                        <div class="col-12 mt-2">
                            <label for="">Date of purchase:</label>
                            <input 
                                type="date" 
                                class="form-control" 
                                name="date_of_purchase[]" 
                            >
                        </div>
                        <div class="col-12 mt-2">
                            <label for="">Date of publication:</label>
                            <input 
                                type="date" 
                                class="form-control" 
                                name="publication_date[]" 
                            >
                        </div>
                        <div class="col-12 mt-2">
                            <input 
                                type="numeric" 
                                class="form-control" 
                                name="edition[]" 
                                placeholder="Edition"
                            >
                        </div>
                        <div class="col-12 mt-2">
                            <select name="condition_id[]" class="form-control mb-2">
                                <option value="">-- Book condition --</option>
                                @foreach ($conditions as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endfor
  
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                <button type="submit" class="btn btn-primary" id="submit_copies">Save changes</button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>