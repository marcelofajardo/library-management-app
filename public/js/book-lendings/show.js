jQuery(document).ready(function($) {
    $('#extend_deadline_btn').on('click', function(e) {
        e.preventDefault();

        let lending_period = $('#lending_period_id').val();

        swal({
            title: 'Confirm extension',
            text: 'The deadline will be extended by another ' + lending_period + ' weeks.',
            icon: 'info',
            buttons: {
                cancel: {
                text: "Cancel",
                value: null,
                visible: true,
                className: "",
                closeModal: true,
              },
              confirm: {
                text: "OK",
                value: true,
                visible: true,
                className: "",
                closeModal: true
                }},
            }).then((value) => {
                if (value) {
                    $("#extend_deadline_form").submit();
                }
        });
    });
});

function showDiv() {
    let val = $('#damage_slt').val();
    
    if (val == 1){
        displayOrHideDiv(true);
    } else if (val == 2 || val == '') {
        displayOrHideDiv(false);
    }
}

let fine_checkbox_div = $('#fine_checkbox');
let lateness_fine = $('#lateness_fine');

function displayOrHideDiv(flag) {
    if (flag) {
        $('#condition_slt').removeClass('d-none');
        $('#damage_desc_div').removeClass('d-none');
        $('#damage_fine_div').removeClass('d-none');

        if (fine_checkbox_div.hasClass('d-none')) {
            fine_checkbox_div.removeClass('d-none');
        }
    } else {
        $('#condition_slt').addClass('d-none');
        $('#damage_desc_div').addClass('d-none');
        $('#damage_fine_div').addClass('d-none');
        
        if (!lateness_fine.length) {
            fine_checkbox_div.addClass('d-none');
        }
    }
}

$('#return_form_btn').on('click', function(e) {
    e.preventDefault();

    let id = $('#book_lending_id').val();
    let token = $('meta[name="csrf-token"]').attr('content');
    let damage_slt = $('#damage_slt').val();
    let damage_desc = $('#damage_desc').val();
    let condition_id = $('#condition_id').val();
    let condition_fine = $('#condition_fine').val();
    let lateness_fine = $('#lateness_fine').val();
    var fine_checkbox = $('#fine_checkbox_input').prop('checked');

    if (fine_checkbox == false) {
        fine_checkbox = '';
    }
    
    $.ajax({
        'url' : '/book-lendings/' + id,
        'method' : 'PUT',
        'data' : {_token:token, damage_slt:damage_slt, damage_desc:damage_desc, condition_id:condition_id, condition_fine:condition_fine, lateness_fine:lateness_fine, fine_checkbox:fine_checkbox},
        'success' : (res) => {
            // location.reload();
            console.log(res);
        },
        'error' : (res) => {
            removeErrors();
            console.log(res);
            let errors = res['responseJSON']['errors'];

            handleErrorMessages(errors);
        }
    });
});

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

function handleErrorMessages(errors) {

    for (let key in errors) {
        let message = errors[key];
        let error_message = createErrorEl(message);

        let element = $('#' + key);

        appendErrorMsg(element, error_message);
    } 
}