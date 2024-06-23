const emailField = document.getElementById('usernameInput');
const emailContainer = document.querySelector('.username.input');
const passwordField = document.getElementById('passwordInput');
const passwordContainer = document.querySelector('.password.input');
const emailLabelField = document.getElementById('usernameLabel');
const passwordLabelField = document.getElementById('passwordLabel');
const loginButton = document.getElementById('login-btn');
const loginForm = document.getElementById('login-form');

emailField.addEventListener('input',e => validateEmailField());
emailField.addEventListener('focusout',e => validateEmailField());

passwordField.addEventListener('input',e => validatePasswordField());
passwordField.addEventListener('focusout',e => validatePasswordField());

loginForm.addEventListener('submit',e => {
    if(! (validateEmailField() & validatePasswordField())) {
        e.preventDefault();
    }

});

function validateEmailField(){
    const email = emailField.value;

    if(email === ''){
        emailLabelField.innerText = 'NIC is required';
        emailContainer.classList.add('wrong');
        return false;
    }

    emailLabelField.innerText = '';
    emailContainer.classList.remove('wrong');
    return true;
}

function validatePasswordField(){
    const password = passwordField.value;

    if(password == ''){
        passwordLabelField.innerText = 'Password is required';
        passwordContainer.classList.add('wrong');
        return false;
    }

    passwordLabelField.innerText = '';
    passwordContainer.classList.remove('wrong');
    return true;
}
