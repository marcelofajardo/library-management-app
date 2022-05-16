
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

function handleErrorMessages(err_array, edit=false) {

    for (let key in err_array) {

        let error_message = createErrorEl(err_array[key][0]);

        // edit modal ima drugacije id-ijeve
        if (edit) {
            appendErrorMsg($('#' + key + '_edit'), error_message);
        } else {
            appendErrorMsg($('#' + key), error_message);
        }
    }
}

let submitNewBookCopyBtn = $('#submit_copies');

submitNewBookCopyBtn.on('click', function(e) {
    e.preventDefault();

    submitNewBookCopyBtn.attr('disabled', true);

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
            submitNewBookCopyBtn.attr('disabled', false);

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

let submitBookCopyBtn = $('#edit_modal_submit');

submitBookCopyBtn.on('click', function(e) {
    e.preventDefault();

    submitBookCopyBtn.attr('disabled', true);

    let edition = $('#edition_edit').val();
    let price = $('#price_edit').val();
    let publication_date = $('#publication_date_edit').val();
    let date_of_purchase = $('#date_of_purchase_edit').val();
    let condition_id = $('#condition_id_edit').val();
    let book_status_id = $('#book_status_id_edit').val();
    let id = $(this).data('id');
    let csrf = $('meta[name="csrf-token"]').attr('content');

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
                submitBookCopyBtn.attr('disabled', false);

                removeErrors();

                let errors = res['responseJSON']['errors'];

                handleErrorMessages(errors, true);
            }
    });
});
