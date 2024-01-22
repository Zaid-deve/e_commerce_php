const searchbar = document.querySelector(".header-search-inp"),
    search_results = document.querySelector('.header-search-results')
searchbar.addEventListener('input', function () {
    if (this.value != "") {
        reqSearch(this.value)
        search_results.classList.add('show')
    }
    else {
        search_results.classList.remove('show')
    }
})

const reqSearch = async function (qry) {
    const response = await fetch('includes/layout/search.php', {
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
    }
}