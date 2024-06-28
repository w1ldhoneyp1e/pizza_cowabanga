document.addEventListener('DOMContentLoaded', () => {
    const userData = {
        login: '',
        password: ''
    }
    function onEmailInputChange(event) {
        userData.login = event.target.value;
    }
    function onPasswordInputChange(event) {
        userData.password = event.target.value;
    }
    function isValidEmail(email) {
        let reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        return reg.test(email);
    }
    function onLoginFormSubmit(event) {
        event.preventDefault();
        if (isValidEmail) {
            let requestOptions = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(userData)
            };
            let response = fetch('/api/login', requestOptions)
                .then((response) => {
                    if (response.ok) {
                        window.location.href = '/';
                    }
                })
                .catch(() => {});
        }
    }
    function initEventListeners() {
        document.getElementById('login-form').addEventListener('submit', onLoginFormSubmit);
        document.getElementById('email').addEventListener('input', onEmailInputChange);
        document.getElementById('password').addEventListener('input', onPasswordInputChange);
    }
    initEventListeners();
})