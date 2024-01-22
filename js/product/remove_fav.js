const remove_btns = document.querySelectorAll('.btn-del-item')
remove_btns.forEach(b => {
    b.addEventListener('click', function () {
        remove_fav(this, this.dataset.pid);
    })
})

const remove_fav = async function (fav_btn, fav_id) {
    fav_btn.disabled = true;

    const response = await fetch('remove_fav.php', {
        method: 'POST',
        body: `pid=${fav_id}`,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })

    if (response.ok) {
        response.text().then(resp => {
            if (resp == "LOGIN_REQUIRED") location.replace('auth/login?r=true');
            else if (resp == 'success') location.reload()
            else alert(resp);
        })
    }

    fav_btn.disabled = false;
}