const buy_now_btn = document.querySelector(".btn-buynow"),
    pid = document.querySelector("#pid"),
    imgs = document.querySelectorAll(".item-imgs img"),
    prev_img = document.querySelector(".item-img-preview img"),
    btn_inc_quantity = document.querySelector(".btn-inc-range"),
    btn_dec_quantity = document.querySelector(".btn-dec-range"),
    quantity_count = document.querySelector(".quantity-count")

imgs.forEach((img) => {
    img.addEventListener('click', function () {
        if (prev_img.src != this.src) prev_img.setAttribute('src', this.src)
    })
})

// quantity selection
let quantity = 1;
btn_inc_quantity.addEventListener('click', function () {
    quantity++
    quantity_count.innerHTML = quantity
})

btn_dec_quantity.addEventListener('click', function () {
    if (quantity > 1) quantity--
    quantity_count.innerHTML = quantity
})

// quantity change
buy_now_btn.addEventListener("click", function () {
    // prepare data
    let info = []

    // push product id
    info.push(`pid=${pid.value}`);
    info.push(`quantity=${quantity}`)

    // redirect to checkout page
    location.replace('checkout?' + info.join('&'))
})