
function removeErrors() {
    $('.invalid-message').remove();
    $(".is-invalid").removeClass('is-invalid');
}

function createErrorEl(message) {
    let error_message = document.createElement('p');

    error_message.innerHTML = message;
    error_message.setAttribute("style", "color: red;");
    error_message.classList.add('invalid-message');

    return error_message;
}

function appendErrorMsg(array, index, error_message) {
    array[index].after(error_message);
    array[index].classList.add("is-invalid");
}

function handleErrorMessages(err_array) {

    for (let key in err_array) {
        // the message is in the form serial_numbers.0 so we just take the index so we know where to add the message 
        let index = key.split(".")[1];
        let field_name = key.split('.')[0];
        let message = err_array[key][0];

        // remove the number from the second word so that the message looks fine
        message = message.split(" ");
        message[1] = field_name;
        message = message.join(" "); 

        let error_message = createErrorEl(message);

        // console.log(error_message);
        let price_els = $('input[name="price[]"]');
        let condition_els = $('select[name="condition_id[]"]');
        let purchase_els = $('input[name="date_of_purchase[]"]');
        let publication_els = $('input[name="publication_date[]"]');
        let edition_els = $('input[name="edition[]"]');
        let book_status_els = $('select[name="book_status_id[]"]');

        if (field_name == 'price') {
            appendErrorMsg(price_els, index, error_message);
        } else if (field_name == 'date_of_purchase') {
            appendErrorMsg(purchase_els, index, error_message);
        } else if (field_name == 'edition') {
            appendErrorMsg(edition_els, index, error_message);
        } else if (field_name == 'publication_date') {
            appendErrorMsg(publication_els, index, error_message);
        } else if (field_name == 'condition_id') {
            appendErrorMsg(condition_els, index, error_message);
        } else if (field_name == 'book_status_id') {
            appendErrorMsg(book_status_els, index, error_message);
        }
    } 
}

$('#submit_copies').on('click', function(e) {
    e.preventDefault();

    let token = $('#token_copies').val();
    let prices = [];
    $("input[name='price[]']").each(function() {
        prices.push($(this).val());
    });
    
    let dates_of_purchase = [];
    $("input[name='date_of_purchase[]']").each(function() {
        dates_of_purchase.push($(this).val());
    });

    let publication_dates = [];
    $("input[name='publication_date[]']").each(function() {
        publication_dates.push($(this).val());
    });

    let editions = [];
    $("input[name='edition[]']").each(function() {
        editions.push($(this).val());
    });

    let conditions = [];
    $("select[name='condition_id[]']").each(function() {
        conditions.push($(this).val());
    });

    let book_status_ids = [];
    $("select[name='book_status_id[]']").each(function() {
        book_status_ids.push($(this).val());
    });

    let book_id = $('#book_id').val();

    $.ajax( {
        'url' : '/book-copies',
        'type' : 'POST',
        'data' : {
            _token:token, 
            'price[]':prices, 
            'date_of_purchase[]':dates_of_purchase, 
            'publication_date[]':publication_dates, 
            'edition[]':editions, 
            'condition_id[]':conditions, 
            'book_id':book_id, 
            'book_status_id[]':book_status_ids
        }, 
        'success': (res) => {  
            location.reload(); 
        }, 
        'error': (res) => {

            removeErrors();

            let errors = res['responseJSON']['errors'];

            handleErrorMessages(errors);
            }
    });
});

$('.call_edit_modal').on('click', function(e) {
    let id = $(this).data('id');
    $('#edit_modal_submit').data('id', id);
    let price = $(this).data('price');
    let purchase_date = $(this).data('purchase');
    let publ_date = $(this).data('publ');
    let condition = $(this).data('cond');
    let edition = $(this).data('edition');
    let status = $(this).data('status');

    $('#edition').val(edition);
    $('#price').val(price);
    $('#publication_date').val(publ_date);
    $('#date_of_purchase').val(purchase_date);
    $('#condition_id').val(condition);
    $('#book_status_id').val(status);
});

function handleErrorsBookCopy(err_array) {
    for (let key in err_array) {

        let message = err_array[key][0];

        let error_message = createErrorEl(message);

        let field = $('#' + key);

        field.after(error_message);
        field.classList.add("is-invalid");
    } 
}

$('#edit_modal_submit').on('click', function(e) {
    e.preventDefault();
    let edition = $('#edition').val();
    let price = $('#price').val();
    let publication_date = $('#publication_date').val();
    let date_of_purchase = $('#date_of_purchase').val();
    let condition_id = $('#condition_id').val();
    let id = $(this).data('id');
    let csrf = $('meta[name="csrf-token"]').attr('content');
    
    // console.log(edition, price, publication_date, date_of_purchase, condition_id, id, csrf);
    $.ajax({
            'url' : '/book-copies/' + id,
            'method' : 'PUT', 
            'data' : {_token: csrf, edition:edition, price:price, condition_id: condition_id, 
                        publication_date:publication_date, date_of_purchase:date_of_purchase, id:id},
            'success' : (res) => {
                location.reload()        
            },
            'error' : (res) => {

                console.log(res['responseJSON']['errors']);

                removeErrors();

                let errors = res['responseJSON']['errors'];
        
                handleErrorsBookCopy(errors);
            }
    });
});
