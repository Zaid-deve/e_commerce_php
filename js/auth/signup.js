const uname = document.querySelector("#uname"),
    email = document.querySelector("#email"),
    pass = document.querySelector("#pass"),
    signup_btn = document.querySelector(".btn-signup")

function check_data() {
    let form_valid = true;

    // check uname
    if (uname.value == '' || uname.value.length > 24) {
        err(uname.parentElement, 'username cannot be empty or contain 4-16 letters only')
        form_valid = false
    }
    else err(uname.parentElement, '');

    // validate email address
    if (email.value == '') {
        err(email.parentElement, 'please enter your email address')
        form_valid = false
    }
    else if (!isEmail(email.value)) {
        err(email.parentElement, 'please enter a valid email address')
        form_valid = false
    }
    else err(email.parentElement, '');

    // validate password
    if (pass.value == '') {
        err(pass.parentElement, 'please create your password to continue')
        form_valid = false
    }
    else if (pass.value.length > 16) {
        err(pass.parentElement, 'password canbe of 4 - 16 in length')
        form_valid = false
    }
    else err(pass.parentElement, '');

    return form_valid;
}

signup_btn.addEventListener('click', function () {
    if (check_data()) {
        // create a an xhr request to send data to server
        // block requests 
        this.disabled = true
        req_signup()
    }
})

const req_signup = async () => {
    let isSuccess = false;

    // prepare data

    const data = new FormData()
    data.append("uname", uname.value)
    data.append("email", email.value)
    data.append("pass", pass.value)

    // send request 
    const response = await fetch('php/regester.php', {
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

    if (!isSuccess) signup_btn.disabled = false
}