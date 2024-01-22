const email = document.querySelector("#email"),
    pass = document.querySelector("#pass"),
    login_btn = document.querySelector('.btn-login');

login_btn.addEventListener('click', function () {
    if (check_data()) {
        // create login request
        // block new requests
        this.disabled = true
        req_login()
    }
})


const req_login = async () => {
    let isSuccess = false;

    // prepare data

    const data = new FormData()
    data.append("email", email.value)
    data.append("pass", pass.value)

    // send request 
    const response = await fetch('php/signin.php', {
        method: 'POST',
        body: data
    })


    if (response.ok) {
        let response_data = response.text()
        response_data.then((resp) => {
            if (resp == 'success') {
                isSuccess = true
                location.replace('../account/index')
            }
        })
    }

    if (!isSuccess) login_btn.disabled = false
}

const check_data = () => {
    let form_valid = true

    // validate email 
    if (email.value == '') {
        err(email.parentElement, 'please enter your email address')
        form_valid = false
    }
    else if (!isEmail(email.value)) {
        err(email.parentElement, 'please enter a valid email address')
        form_valid = false
    }
    else err(email.parentElement, '')

    // validate pass 
    if (pass.value == '') {
        form_valid = false
        err(pass.parentElement, 'please enter your email password to continue')
    }
    else {
        err(email.parentElement, '')
    }
    return form_valid;
}