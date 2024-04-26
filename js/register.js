function validatePassword() {
    var password = document.getElementById("passwordInput").value;
    var confirmPassword = document.getElementById("confirmPasswordInput").value;

    if (password != confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }
    return true;
}