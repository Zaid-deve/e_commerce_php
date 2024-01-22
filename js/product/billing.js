const user_info = {
    fname: document.querySelector("#fname"),
    company: document.querySelector("#company_name"),
    street_address: document.querySelector("#street_add"),
    apartment: document.querySelector("#fname"),
    town_city: document.querySelector("#town_city_add"),
    phone: document.querySelector("#phone"),
    email: document.querySelector("#email")
},
    check_btn = document.querySelector("#remember-details"),
    place_order_btn = document.querySelector(".btn-place-order"),
    pid = document.querySelector('#pid'),
    quantity = document.querySelector("#quantity");

place_order_btn.addEventListener('click', async function () {
    if (checkReqFields()) {
        this.disabled = true
        // preapre data
        let data = [];
        for (const f in user_info) {
            data.push(f + "=" + user_info[f].value);
        }

        // push optional data
        data.push(`save_info=${check_btn.checked}`)
        data.push(`paymode=0`)
        data.push(`coupon=false`)
        data.push(`pid=${pid.value}`)
        data.push(`quantity=${quantity.value}`)

        const response = await fetch('placeorder.php', {
            method: 'POST',
            body:data.join('&'),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })

        if (response.ok) {
            response.text().then(resp => {
                if (resp == 'LOGIN_REQUIRED') location.replace('../auth/login');
                else if(resp == 'success') location.replace('../account/orders');
                else alert(resp);
            })
        }
        this.disabled = false
    }
})

function checkReqFields() {
    // check mandatory fields
    let form_valid = true;
    for (const f in user_info) {
        if (user_info[f].dataset.required == 1) {
            if (user_info[f].value == '') {
                err(user_info[f].parentElement, 'this field is required and cannot be empty')
                user_info[f].focus()
                form_valid = false;
            }
            else err(user_info[f].parentElement, '')
        }
    }
    return form_valid;
}