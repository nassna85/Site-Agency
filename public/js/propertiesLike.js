function onClickBtnLike(event)
{
    event.preventDefault();

    const url = this.href;
    const icone = this.querySelector('i');

    axios.get(url).then(function (response) {

        if(icone.classList.contains('fas'))
        {
            icone.classList.replace('fas', 'far');
        }
        else
        {
            icone.classList.replace('far', 'fas');
        }

    }).catch(function (error) {
        if(error.response.status === 403)
        {
            alert("Vous devez être connecté...");
        }
        else
        {
            alert("Une erreur est survenue. Veuillez rééssayer plus tard");
        }
    });
}

document.querySelectorAll('a.js-like').forEach(function(link){
    link.addEventListener('click', onClickBtnLike);
});