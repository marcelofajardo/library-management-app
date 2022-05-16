function disableBtnAndSubmitForm(element, formId) {
    element.disabled = true;
    document.getElementById(formId).submit();
}
