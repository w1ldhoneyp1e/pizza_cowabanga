document.addEventListener('DOMContentLoaded', () => {
    const userData = {
        firstName: '',
        lastName: '',
        email: '',
        phone: '',
        adress: '',
        avatar: '',
        password: ''
    }
    userForm = document.getElementById('profile');
    firstNameInput = document.getElementById('first-name');
    lastNameInput = document.getElementById('last-name');
    phoneInput = document.getElementById('phone');
    adressInput = document.getElementById('adress');
    emailInput = document.getElementById('email');
    passwordInput = document.querySelector('#password');
    avatarInput = document.querySelector('.img');

    function getLastPartOfUrl(url) {
        // Разделяем строку по слешу и берем последний элемент
        const parts = url.split('/').slice(-1)[0];
        return parts;
      }
    function onFirstNameInputChange(event) {
        userData.firstName = event.target.value;
    }
    function onLastNameInputChange(event) {
        userData.lastName = event.target.value;
    }
    function onPhoneInputChange(event) {
        userData.phone = event.target.value;
    }
    function onAdressInputChange(event) {
        userData.adress = event.target.value;
    }
    function onEmailInputChange(event) {
        userData.avatar = event.target.value;
    }
    function onPasswordInputChange(event) {
        userData.password = event.target.value;
    }
    async function onAvatarChange(event) {
        const file = event.target.files[0];
        const b64Img = await asyncReadFileAsBase64(file);
        userData.avatar = b64Img;
        document.querySelector('.img').src = userData.avatar;
    }
    
    function onUserFormSubmit(event) {
        event.preventDefault();
        let url = window.location.href;
        let id = getLastPartOfUrl(url);

        console.log(userData);

        let requestOptions = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(userData)
        };
        let response = fetch('/user/update/data/'+id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(userData)
        })
            .then(() => {
                console.log('2')
                // if (response.status >= 200 && response.status <= 399) {
                    console.log('1')
                    // window.location.href = '/user/info/'+id;
                // }
            })
            .catch((error) => {
            });

    }

    function initEventListeners() {
        userForm.addEventListener('submit', onUserFormSubmit);
        firstNameInput.addEventListener('input', onFirstNameInputChange);
        lastNameInput.addEventListener('input', onLastNameInputChange);
        phoneInput.addEventListener('input', onPhoneInputChange);
        avatarInput.addEventListener('change', onAvatarChange);
        adressInput.addEventListener('input', onAdressInputChange);
        emailInput.addEventListener('input', onEmailInputChange);
        passwordInput.addEventListener('input', onPasswordInputChange);
    }

    function asyncReadFileAsBase64(file) {
        return new Promise((resolve, reject) => {
            const fr = new FileReader();
            fr.onerror = reject;
            fr.onload = () => {
                resolve(fr.result);
            }
            fr.readAsDataURL(file);
        });
    }
    initEventListeners();
})