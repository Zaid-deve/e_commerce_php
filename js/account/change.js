const fields = document.querySelectorAll(".profile-info .inp"),
    change_btn = document.querySelector(".btn-change");

change_btn.disabled = false

// default values of fields
const initail_values = {}

fields.forEach((f) => {
    initail_values[f.id] = f.value
})

let curr_pass = document.querySelector("#curr_pass"),
    new_pass = document.querySelector("#new_pass"),
    cnfm_pass = document.querySelector("#confirm_pass")

change_btn.addEventListener("click", function () {
    // compare if any fields were changed
    const changed_fields = {},
        data = new FormData();

    fields.forEach((f) => {
        changed_fields[f.id] = f.value
    })


    for (f in changed_fields) {
        if (changed_fields[f] == initail_values[f]) {
            delete changed_fields[f];
        } else data.append(f, changed_fields[f])
    }

    // check if user tries to change their password
    if (curr_pass.value != '' || new_pass.value != '') {
        alert("Password change is not supported currently");
        return;
    }

    let fields_len = Object.keys(changed_fields).length
    if (fields_len > 0) {
        reqChange(data);
    }
})

async function reqChange(data) {
    const response = await fetch('php/change.php', {
        method: 'POST',
        body: data
    })

    if (response.ok) {
        response.text().then(res => {
            if (res == "success") location.reload()
        })
    }
}