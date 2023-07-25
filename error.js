// Floating error message
const floatErrorMessage = document.querySelector('.float-error');
if (floatErrorMessage) {
    setTimeout(function() {
        floatErrorMessage.style.display = 'none';
    }, 4000);
}

//success creating account
const floatSuccessMessage = document.querySelector('.float-success');
if (floatSuccessMessage) {
    setTimeout(function() {
        floatSuccessMessage.style.display = 'none';
    }, 4000);
}

function showErrorMessage() {
    const floatErrorMessageLogin = document.querySelector('.float-error-login');
    if (floatErrorMessageLogin) {
        floatErrorMessageLogin.style.display = 'block';
        setTimeout(function () {
            floatErrorMessageLogin.style.display = 'none';
        }, 4000);
    }
}

// Call the function to show the error message when the page loads
window.onload = showErrorMessage;