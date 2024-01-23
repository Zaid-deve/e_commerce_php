const email = document.querySelector("#email"),
    pass = document.querySelector("#pass"),
    login_btn = document.querySelector('.btn-login'),
    form_err = document.querySelector(".form-err"),
    form_err_txt = form_err.querySelector(".err-txt");


login_btn.addEventListener('click', function () {
    if (check_data()) {
        // create login request
        // block new requests
        this.disabled = true
        req_login()
    }
})


const req_login = async () => {
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
        let response_data = await response.text()
        if (response_data == 'success') {
            location.replace('../account/index')
            return;
        }
        form_err_txt.textContent = response_data;
    } else form_err_txt.textContent = 'Something Went Wrong !';

    form_err.classList.add('show')
    login_btn.disabled = false
}

const check_data = () => {
    let form_valid = true
    if(!isEmail(email.value)){
        form_valid=false
        err(email.parentElement,'Please enter a valid email addres !')
    } else {
        err(email.parentElement, '')
    }

    if(pass.value == ""){
        form_valid=false
        err(pass.parentElement,'Please enter your account password !')
    } else {
        err(pass.parentElement, '')
    }

    return form_valid;
}