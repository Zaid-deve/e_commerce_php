const header = document.querySelector(".header-nav"),
    nav_toggler = document.querySelector(".btn-nav-toggle"),
    search_toggler = document.querySelector(".btn-toggle-search-bar"),
    search_close = document.querySelector(".btn-search-close"),
    search_inp = document.querySelector('.header-search-field .inp'),
    search_bar = document.querySelector(".header-search");

search_toggler.addEventListener('click', function () {
    if (search_bar.classList.contains('show')) {
        search_bar.classList.remove('show')
    }
    else {
        search_bar.classList.add('show')
        search_inp.focus();
    }
})

search_close.addEventListener('click', function () {
    search_bar.classList.remove('show')
})

nav_toggler.addEventListener("click", function () {
    header.classList.toggle('show')
    this.addEventListener('blur', function () {
        if (header.classList.contains('show')) header.classList.remove('show')
    })
})

// active current navbar menu

var page = new URLSearchParams(location.search),
    curr_mod = page.get('page')

if (curr_mod != null) {
    document.querySelector(`#${curr_mod}`).classList.add('active')
}