
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

function appendErrorMsg(element, error_message) {
    element.after(error_message);
    element.addClass("is-invalid");
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

        if (field_name == 'price') {
            appendErrorMsg($('#price'), error_message);
        } else if (field_name == 'date_of_purchase') {
            appendErrorMsg($('#date_of_purchase'), error_message);
        } else if (field_name == 'edition') {
            appendErrorMsg($('#edition'), error_message);
        } else if (field_name == 'publication_date') {
            appendErrorMsg($('#publication_date'), error_message);
        } else if (field_name == 'condition_id') {
            appendErrorMsg($('#condition_id'), error_message);
        } else if (field_name == 'book_status_id') {
            appendErrorMsg($('#book_status_id'), error_message);
        }
    }
}

$('#submit_copies').on('click', function(e) {
    e.preventDefault();

    let token = $('#token_copies').val();
    let price = $('#price').val();
    let date_of_purchase = $('#date_of_purchase').val();
    let publication_date = $('#publication_date').val();
    let edition = $('#edition').val();
    let condition_id = $('#condition_id').val();
    let book_status_id = $('#book_status_id').val();
    let book_id = $('#book_id').val();

    $.ajax( {
        'url' : '/book-copies',
        'type' : 'POST',
        'data' : {
            _token:token,
            'price':price,
            'date_of_purchase':date_of_purchase,
            'publication_date':publication_date,
            'edition':edition,
            'condition_id':condition_id,
            'book_id':book_id,
            'book_status_id':book_status_id
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

    $('#edition_edit').val(edition);
    $('#price_edit').val(price);
    $('#publication_date_edit').val(publ_date);
    $('#date_of_purchase_edit').val(purchase_date);
    $(`#condition_id_edit option[value=${condition}]`).attr("selected","selected");
    $(`#book_status_id_edit option[value=${status}]`).attr("selected","selected");
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
    let edition = $('#edition_edit').val();
    let price = $('#price_edit').val();
    let publication_date = $('#publication_date_edit').val();
    let date_of_purchase = $('#date_of_purchase_edit').val();
    let condition_id = $('#condition_id_edit').val();
    let book_status_id = $('#book_status_id_edit').val();
    let id = $(this).data('id');
    let csrf = $('meta[name="csrf-token"]').attr('content');

    // console.log(edition, price, publication_date, date_of_purchase, condition_id, id, csrf);
    $.ajax({
            'url' : '/book-copies/' + id,
            'method' : 'PUT',
            'data' : {_token: csrf, edition:edition, price:price, condition_id: condition_id,
                        publication_date:publication_date, date_of_purchase:date_of_purchase,
                        id:id, book_status_id:book_status_id},
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
