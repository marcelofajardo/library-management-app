
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

        let price_els = $('input[name="price[]"]');
        let condition_els = $('select[name="condition_id[]"]');
        let purchase_els = $('input[name="date_of_purchase[]"]');
        let publication_els = $('input[name="publication_date[]"]');
        let edition_els = $('input[name="edition[]"]');
        
        if (field_name == 'price') {
            appendErrorMsg(price_els, index, error_message)
        } else if (field_name == 'date_of_purchase') {
            appendErrorMsg(purchase_els, index, error_message)
        } else if (field_name == 'edition') {
            appendErrorMsg(edition_els, index, error_message)
        } else if (field_name == 'publication_date') {
            appendErrorMsg(publication_els, index, error_message)
        } else if (field_name == 'condition') {
            appendErrorMsg(condition_els, index, error_message)
        } 
    } 
}

$('#submit_copies').on('click', function(e) {
    e.preventDefault();

    let token = $('#token_copies').val();
    let price = [];
    $("input[name='price[]']").each(function() {
        price.push($(this).val());
    });
    
    let date_of_purchase = [];
    $("input[name='date_of_purchase[]']").each(function() {
        date_of_purchase.push($(this).val());
    });

    let publication_date = [];
    $("input[name='publication_date[]']").each(function() {
        publication_date.push($(this).val());
    });

    let edition = [];
    $("input[name='edition[]']").each(function() {
        edition.push($(this).val());
    });

    let condition = [];
    $("select[name='condition_id[]']").each(function() {
        condition.push($(this).val());
    });

    let book_id = $('#book_id').val();

    $.ajax( {
        'url' : '/book-copies',
        'type' : 'POST',
        'data' : {_token:token, 'price[]':price, 'date_of_purchase[]':date_of_purchase, 'publication_date[]':publication_date, 'edition[]':edition, 'condition_id[]':condition, book_id:book_id}, 
        'success': (res) => {  
            location.reload(); 
        }, 
        'error': (res) => {

            removeErrors();

            let errors = res['responseJSON']['errors'];
        //     let err_array = [];

        // // // get error messages and push them into an array
        //     for (let key in errors) {
        //         err_array.push(errors[key][0]);
        //     } 

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

    $('#edition').val(edition);
    $('#price').val(price);
    $('#publication_date').val(publ_date);
    $('#date_of_purchase').val(purchase_date);
    $('#condition_id').val(condition);

});

function handleErrorsBookCopy(err_array) {
    for (let key in err_array) {

        let message = err_array[key][0];

        let error_message = createErrorEl(message);

        let field = $('#' + key);

        field.after(error_message);
        field[0].classList.add("is-invalid");
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
    
    $.ajax({
            'url' : '/book-copies/' + id,
            'method' : 'PUT', 
            'data' : {_token: csrf, edition:edition, price:price, condition_id: condition_id, publication_date:publication_date, date_of_purchase:date_of_purchase, id:id},
            'success' : (res) => {
                location.reload()        },
            'error' : (res) => {

                removeErrors();

                let errors = res['responseJSON']['errors'];
        
                handleErrorsBookCopy(errors);
            }
    });

});

// $('.call_qr_modal').on('click', function() {
//     // alert('clicked')

//     let id = $(this).data('id');
//     let qr_code = '<?php echo {!! QrCode::generate(/read-qr-info/' + id + '!!};
//     console.log(id, qr_code);
//     $('#qr_code_display').html(qr_code);

// });

