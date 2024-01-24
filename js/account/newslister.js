const newslister_inp = document.querySelector(".news-lister-inp"),
    btn_add_newslister = document.querySelector(".btn-news-lister-add")


btn_add_newslister.addEventListener('click', function () {
    let val = newslister_inp.value
    if (!isEmail(val)) {
        err(newslister_inp.parentElement.parentElement, 'please enter a valid email addres !')
    }
    else {
        err(newslister_inp.parentElement.parentElement, '')
        this.disabled = true
        addNewsLister(val)
    }
})

async function addNewsLister(email) {

    btn_add_newslister.setAttribute('disabled', true)
    const response = await fetch("http://localhost/e_commerce_design/account/addnewslister.php", {
        method: 'POST',
        body: `email=${email}`,
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
    })

    if (response.ok) {
        const result = await response.text();
        if (result == 'success') {
            email.value = ''
            alert('Thankyou for joining with us, you will be notified for each time theres as update for you !')
            newslister_inp.parentElement.remove()
            return;
        }

        err(newslister_inp.parentElement.parentElement, result)
    }else err(newslister_inp.parentElement.parentElement, result)

    btn_add_newslister.setAttribute('disabled', false)
}