const fields = {
    name: document.querySelector("#name"),
    email: document.querySelector("#email"),
    phone: document.querySelector("#phone"),
    des: document.querySelector("#des")
},
    sub_btn = document.querySelector(".btn-contact");

const req_fields = ['name', 'email', 'phone']
const val_fields = function () {
    let form_valid = true;
    Object.entries(fields).forEach(f => {
        if (req_fields.includes(f[0])) {

            // check if required fields are filled
            if (f[1].value == "") {
                err(f[1].parentElement, 'this field cannot be empty')
                form_valid = false
            } else {
                err(f[1].parentElement, '')

                // check if email field is filled properly
                if (f[0] == 'email') {
                    if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(f[1].value)) {
                        err(f[1].parentElement, 'Please enter a valid email address !');
                        form_valid = false

                    }
                    else err(f[1].parentElement, '');
                }
            }
        }
    })
    return form_valid;
}

sub_btn.addEventListener('click', function () {
    if (val_fields()) {
        this.disabled = true
        sub_form();
        this.disabled = false
    }
})

const sub_form = async function () {
    const data = new FormData();
    Object.entries(fields).forEach(f => {
        data.append(f[0],f[1].value);
    })

    const response = await fetch('add_contact.php', {
        method: 'POST',
        body: data,
    })

    if (response.ok) {
        response.text().then(resp => {
            if (resp == 'success'){
                alert("Thank you for contacting, we will reach you soon");
                location.reload();
            } 
            else alert(resp)
        })
    }
}