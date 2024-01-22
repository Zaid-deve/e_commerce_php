const fav_counts = document.querySelector('.badge-fav-counts'),
      add_to_fav_btns = document.querySelectorAll('.btn-card-favorite');
    
add_to_fav_btns.forEach(fav_btn => {
    fav_btn.addEventListener("click", function() {
        add_to_favorite(this,this.dataset.pid);
    })
})

const add_to_favorite = async function (fav_btn, pid) {
    // add product to user favorites
    if (pid != '') {
        // send product id to fetch api
        const response = await fetch('http://localhost/e_commerce_design/product/add_to_fav.php', {
            method: "POST",
            body: `pid=${pid}`,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })

        // check response from script
        if (response.ok) {
            response.text().then(res => {
                if (res == 'LOGIN_REQUIRED') location.replace('http://localhost/e_commerce_design/auth/login?r=true');
                else if (res == 'FAV_ADDED') {
                    update_favs()
                    fav_btn.classList.add('active')
                }
                else if (res == 'FAV_REMOVED') {
                    update_favs(false)
                    fav_btn.classList.remove
                        ('active')
                }
                else alert(res);
            })
        }
    }
}

const update_favs = function (update = true) {
    let fav_btn = document.querySelector('.header-btns .btn-favorites'),
        fav_text = fav_btn.querySelector('span'),
        fav_items = Number(fav_text.innerHTML);

    if (update) {
        fav_items += 1;
    }
    else {
        if (fav_items <= 0) fav_items = 0
        else fav_items -= 1;
    }
    fav_text.innerHTML = fav_items;
}