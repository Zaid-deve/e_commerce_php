const add_to_cart_btns = document.querySelectorAll('.btn-addto-cart');

add_to_cart_btns.forEach(cart_btn => {
    cart_btn.addEventListener("click", function () {
        add_to_cart(this, this.dataset.pid);
    })
})

const add_to_cart = async function (cart_btn, pid) {
    const cart_btn_text = cart_btn.querySelector('span');

    if (pid != '' || pid != undefined) {
        // puase access request 
        cart_btn.disabled = true
        // create a request to add / remove prioduct from car
        const response = await fetch('http://localhost/e_commerce_design/product/add_to_cart.php', {
            method: "POST",
            body: `pid=${pid}`,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).catch(() => alert('something went wrong'));
        cart_btn.disabled = false

        if (response.ok) {
            response.text().then(res => {
                if (res == 'CART_ADDED') {
                    cart_btn_text.innerHTML = 'Remove From Cart'
                    update_cart(true);
                }
                else if (res == 'CART_REMOVED') {
                    cart_btn_text.innerHTML = 'Add To Cart'
                    update_cart(false);
                } else if (res == 'LOGIN_REQUIRED') location.replace('auth/login')
                else alert(res);
            })
        }

    }
}

const update_cart = function (update = true) {
    let cart_btn = document.querySelector('.header-btns .btn-shop-cart'),
        cart_text = cart_btn.querySelector('span'),
        card_items = Number(cart_text.innerHTML);

    if (update) {
        card_items += 1;
    }
    else {
        if (card_items <= 0) card_items = 0
        else card_items -= 1;
    }
    cart_text.innerHTML = card_items;
}