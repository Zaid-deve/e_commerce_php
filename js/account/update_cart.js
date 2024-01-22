// defaults
let change_values = [],
    delete_rows = []

// get all cart row
const rows = document.querySelectorAll('.cart-grid-row'),
    update_btn = document.querySelector('.btn-update'),
    cart_total = document.querySelector(".price-grid-total"),
    cart_subtotal = document.querySelector('.price-grid-subtotal');

rows.forEach((row) => {
    // get values
    let quantity_inp = row.querySelector('#quantity-change-inp')

    // add values to be changed in change array if quantity changed
    quantity_inp.addEventListener("change", function () {
        let cid = this.dataset.cid,
            price = row.querySelector('.cart-item-price'),
            newQuantity = this.value,
            subtotal = row.querySelector('.cart-subtotal-price span')

        var findIndex = change_values.findIndex(item => item.cid == cid)


        if (findIndex > 0) {
            change_values.splice(findIndex, 1)
        }

        change_values.push({ cid, quantity: newQuantity })
        subtotal.innerHTML = (price.dataset.price * newQuantity);

        if (change_values.length > 0 || delete_rows > 0) update_btn.disabled = false
        else update_btn.disabled = false
    })
})

const removeItem = (item, cid) => {
    if (delete_rows.includes(cid)) {
        delete_rows = delete_rows.filter(di => di != cid);
    }
    else {
        delete_rows.push(cid)
    }

    if (change_values.length > 0 || delete_rows > 0) update_btn.disabled = false
    else update_btn.disabled = false

    remove_icon = item.querySelector('.remove-icon');
    remove_icon.classList.toggle('show')
}

update_btn.addEventListener('click', async function () {
    if (change_values.length > 0 || delete_rows.length > 0) {
        this.disabled = true

        const data_items = {
            to_change: change_values,
            to_delete: delete_rows
        }

        const response = await fetch('php/update_cart.php', {
            method: 'POST',
            body: JSON.stringify(data_items),
            headers: {
                'Content-Type': 'application/json'
            }
        })


        if (response.ok) {
            response.text().then(resp => {
                if (resp == "LOGIN_REQUIRED") location.replace('../auth/login')
                else if (resp == "success") location.reload()
                else alert(resp)
            })
        }

        this.disabled = false
    }
})

// process to checkout
const checkout_btn = document.querySelector('.btn-redto-checkout')
checkout_btn.addEventListener('click', function () {
    // prepare data
    alert('feature not available')
})