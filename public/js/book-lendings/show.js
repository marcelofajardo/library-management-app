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
    let val = $('#damage_select').val();
    
    if (val == 1){
        displayOrHideDiv(true);
    } else if (val == 2 || val == '') {
        displayOrHideDiv(false);
    }
}

let fine_checkbox = $('#fine_checkbox');
let lateness_fine = $('#lateness_fine');

function displayOrHideDiv(flag) {
    if (flag) {
        $('#condition_select').removeClass('d-none');
        $('#damage_desc').removeClass('d-none');
        $('#damage_fine').removeClass('d-none');

        if (fine_checkbox.hasClass('d-none')) {
            fine_checkbox.removeClass('d-none');
        }
    } else {
        $('#condition_select').addClass('d-none');
        $('#damage_desc').addClass('d-none');
        $('#damage_fine').addClass('d-none');
        
        if (!lateness_fine.length) {
            fine_checkbox.addClass('d-none');
        }
    }
}