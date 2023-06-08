function confirmPasswordIsSame(form_name) {
    let password = document.forms[form_name]["password_name"].value;
    let password_confirm = document.forms[form_name]["password_confirm_name"].value;
    let password_validation = document.querySelector('input[name=password_confirm_name]');
    if (password != password_confirm) {
        password_validation.setCustomValidity("Passwords do not match!");
    } else {
        password_validation.setCustomValidity("");
    }
}