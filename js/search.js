const searchbar = document.querySelector(".header-search-inp"),
    search_results = document.querySelector('.header-search-results')
searchbar.addEventListener('keypress', function (e) {
    if (this.value != "") {
        if (e.keyCode == 13) {
            location.href = "localhost/e_commerce_design/includes/product/search.php?qry=" + this.value
            return;
        }
        reqSearch(this.value)
        search_results.classList.add('show')
        return;
    }
    search_results.classList.remove('show')
})

const reqSearch = async function (qry) {
    const response = await fetch('http://localhost/e_commerce_design/includes/layout/search.php', {
        method: 'POST',
        body: `search=${qry}`,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })

    if (response.ok) {
        response.text().then(resp => {
            search_results.innerHTML = resp
        })
    } else search_results.innerHTML = 'Something Went Wrong !';
}