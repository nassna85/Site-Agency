function onClickBtnLike(event) {
    event.preventDefault();

    const url = this.href;
    const icone = this.querySelector('i');

    axios.get(url).then(function (response) {

        if (icone.classList.contains('fas')) {
            icone.classList.replace('fas', 'far');
        }
        else {
            icone.classList.replace('far', 'fas');
        }

    }).catch(function (error) {
        if (error.response.status === 403) {
            window.location.href = "/login";
        }
        else {
            window.location.href = "/not-found";
        }
    });
}

document.querySelectorAll('a.js-like').forEach(function (link) {
    link.addEventListener('click', onClickBtnLike);
});
