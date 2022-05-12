function deleteElement(e, id) {
    e.preventDefault();
    e.stopPropagation();

    let form = document.getElementById('form_' + id);

    swal({
        title: "Are you sure?",
        icon: "warning",
        buttons: [
            'No, cancel it!',
            'Yes, I am sure!'
        ],
        dangerMode: true,
    }).then(function(isConfirm) {
        if (isConfirm) {
            form.submit();
        }
    })
}
