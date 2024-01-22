const cancel_btn = document.querySelectorAll(".btn-cancel-item");

cancel_btn.forEach(b => {
    b.addEventListener("click", function () {
        // puase access request
        this.disabled = true

        // del order request
        del_order(this.dataset.oid);

        // resume reques
        this.disabled = false
    })
})

const del_order = async function (oid) {

    if (oid != '') {
        const response = await fetch('http://localhost/e_commerce_design/account/php/del_order.php', {
            method: 'POST',
            body: `order_id=${oid}`,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })

        if (response.ok) {
            response.text().then(resp => {
                if (resp == 'success') location.reload()
                else alert(resp)
            })
        }


    }
}