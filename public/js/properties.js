$(function(){
    // For New Property and edit Property
    $('#add-image').click(function(){
        //Je récupère le numero des futurs champs que je vais créer
        const index = +$('#widgets-counter').val(); //Le + sert a convertir en nombre
        //Je récupère le prototype des entrées
        const tmpl = $('#properties_images').data('prototype').replace(/__name__/g, index);

        //J'injecte ce code au sein de la div

        $('#properties_images').append(tmpl);

        $('#widgets-counter').val(index + 1);

        //Je gère le button supprimer
        handleDeleteButtons();
    });

    function handleDeleteButtons()
    {
        $('button[data-action="delete"]').click(function(){
            const target = this.dataset.target;
            $(target).remove();
        });
    }

    function updateCounter()//Cette fonction sert pour la modification d'une annonce! sinon bug
    {
        const count = +$('#properties_images div.form-group').length;

        $('#widgets-counter').val(count);
    }

    updateCounter();

    handleDeleteButtons();

    // CREATE PROPERTY

    $("#btn-create-property").on("click", function(){

        valid = true;
        const city = $("#properties_city").val();
        const address = $("#properties_address").val();
        const postalCode = $("#properties_postalCode").val();
        const price = $("#properties_price").val();
        const description = $("#properties_description").val();
        const bedroom = $("#properties_bedrooms").val();
        const shower = $("#properties_shower").val();
        const area = $("#properties_area").val();
        const coverImage = $("#properties_coverImage").val();

        if(city === '')
        {
            $("#properties_city").css("borderColor", "red");
            $(".errorCity").fadeIn().text("Veuillez indiquer une ville !");
            valid = false;
        }
        else if(!city.match(/^[a-zéèçâäï\- ]+$/i))
        {
            $(".errorCity").hide("");
            $("#properties_city").css("borderColor", "red");
            $(".errorCity").fadeIn().text("La ville ne doit contenir que des lettres !");
            valid = false;
        }
        else if(city.length < 2 || city.length > 255)
        {
            $(".errorCity").hide("");
            $("#properties_city").css("borderColor", "red");
            $(".errorCity").fadeIn().text("Le nombre de caractère pour la ville doit être compris entre 2 et 255 caractères !");
            valid = false;
        }
        else
        {
            $(".errorCity").hide("");
            $("#properties_city").css("borderColor", "green");
        }

        if(address === '')
        {
            $("#properties_address").css("borderColor", "red");
            $(".errorAddress").fadeIn().text("Veuillez indiquer une adresse !");
            valid = false;
        }
        else if(!address.match(/^[a-zéèçâäï'0-9\- ]+$/i))
        {
            $(".errorAddress").hide("");
            $("#properties_address").css("borderColor", "red");
            $(".errorAddress").fadeIn().text("L'adresse ne doit contenir que des lettres et des chiffres !");
            valid = false;
        }
        else if(address.length < 5 || city.length > 255)
        {
            $(".errorAddress").hide("");
            $("#properties_address").css("borderColor", "red");
            $(".errorAddress").fadeIn().text("Le nombre de caractère pour l'adresse doit être compris entre 5 et 255 caractères !");
            valid = false;
        }
        else
        {
            $(".errorAddress").hide("");
            $("#properties_address").css("borderColor", "green");
        }

        if(postalCode === '')
        {
            $("#properties_postalCode").css("borderColor", "red");
            $(".errorPostalCode").fadeIn().text("Veuillez indiquer un code postal !");
            valid = false;
        }
        else if(!postalCode.match(/^[0-9]+$/))
        {
            $(".errorPostalCode").hide("");
            $("#properties_postalCode").css("borderColor", "red");
            $(".errorPostalCode").fadeIn().text("Le code postal ne doit contenir que des chiffres !");
            valid = false;
        }
        else if(postalCode.length < 4 || postalCode.length > 10)
        {
            $(".errorPostalCode").hide("");
            $("#properties_postalCode").css("borderColor", "red");
            $(".errorPostalCode").fadeIn().text("Le nombre de caractère pour le code postal doit être compris entre 4 et 10 caractères !");
            valid = false;
        }
        else
        {
            $(".errorPostalCode").hide("");
            $("#properties_postalCode").css("borderColor", "green");
        }

        if(price === '')
        {
            $("#properties_price").css("borderColor", "red");
            $(".errorPrice").fadeIn().text("Veuillez indiquer un prix !");
            valid = false;
        }
        else if(!price.match(/^[0-9\.]+$/))
        {
            $(".errorPrice").hide("");
            $("#properties_price").css("borderColor", "red");
            $(".errorPrice").fadeIn().text("Le prix ne doit contenir que des chiffres !");
            valid = false;
        }
        else if(price.length < 2 || price.length > 12)
        {
            $(".errorPrice").hide("");
            $("#properties_price").css("borderColor", "red");
            $(".errorPrice").fadeIn().text("Le nombre de chiffre pour le prix doit être compris entre 2 et 12 caractères !");
            valid = false;
        }
        else
        {
            $(".errorPrice").hide("");
            $("#properties_price").css("borderColor", "green");
        }

        if(description === '')
        {
            $("#properties_description").css("borderColor", "red");
            $(".errorDescription").fadeIn().text("Veuillez indiquer une description!");
            valid = false;
        }
        else if(!description.match(/[^<>]+$/i))
        {
            $(".errorDescription").hide().text("");
            $("#properties_description").css("borderColor", "red");
            $(".errorDescription").fadeIn().text("Le format de votre description n'est pas valide !");
            valid = false;
        }
        else if(description.length < 50)
        {
            $(".errorDescription").hide().text("");
            $("#properties_description").css("borderColor", "red");
            $(".errorDescription").fadeIn().text("La description doit faire au moins 50 caractères !");
            valid = false;
        }
        else
        {
            $("#properties_description").css("borderColor", "green");
            $(".errorDescription").hide().text("");
        }

        if(bedroom === '')
        {
            $("#properties_bedrooms").css("borderColor", "red");
            $(".errorBedroom").fadeIn().text("Veuillez indiquer le nombre de chambre !");
            valid = false;
        }
        else if(!bedroom.match(/^[0-9 ]{1,2}$/))
        {
            $(".errorBedroom").hide().text("");
            $("#properties_bedrooms").css("borderColor", "red");
            $(".errorBedroom").fadeIn().text("Le nombre de chambres doit être un chiffre à 2 nombres maximum !");
            valid = false;
        }
        else if(bedroom < 0)
        {
            $(".errorBedroom").hide().text("");
            $("#properties_bedrooms").css("borderColor", "red");
            $(".errorBedroom").fadeIn().text("Le nombre de chambre doit être supérieur à 1 !");
            valid = false;
        }
        else
        {
            $("#properties_bedrooms").css("borderColor", "green");
            $(".errorBedroom").hide().text("");
        }

        if(shower === '')
        {
            $("#properties_shower").css("borderColor", "red");
            $(".errorShower").fadeIn().text("Veuillez indiquer le nombre de douches !");
            valid = false;
        }
        else if(!shower.match(/^[0-9 ]{1,2}$/))
        {
            $(".errorShower").hide().text("");
            $("#properties_shower").css("borderColor", "red");
            $(".errorShower").fadeIn().text("Le nombre de douches doit être un chiffre à 2 nombres maximum !");
            valid = false;
        }
        else if(shower < 0)
        {
            $(".errorShower").hide().text("");
            $("#properties_shower").css("borderColor", "red");
            $(".errorShower").fadeIn().text("Le nombre de douches doit être supérieur à 1 !");
            valid = false;
        }
        else
        {
            $("#properties_shower").css("borderColor", "green");
            $(".errorShower").hide().text("");
        }

        if(area === '')
        {
            $("#properties_area").css("borderColor", "red");
            $(".errorArea").fadeIn().text("Veuillez indiquer la surface en m2 !");
            valid = false;
        }
        else if(!area.match(/^[0-9 ]{2,3}$/))
        {
            $(".errorArea").hide().text("");
            $("#properties_area").css("borderColor", "red");
            $(".errorArea").fadeIn().text("La surface doit être un chiffre à 3 nombres maximum !");
            valid = false;
        }
        else if(area < 0)
        {
            $(".errorArea").hide().text("");
            $("#properties_area").css("borderColor", "red");
            $(".errorArea").fadeIn().text("La surface doit être supérieur à 1 !");
            valid = false;
        }
        else
        {
            $("#properties_area").css("borderColor", "green");
            $(".errorArea").hide().text("");
        }

        if(coverImage === '')
        {
            $("#properties_coverImage").css("borderColor", "red");
            $(".errorCoverImage").fadeIn().text("Veuillez indiquer une image principale !");
            valid = false;
        }
        else if(!coverImage.match(/https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,}/i))
        {
            $(".errorCoverImage").hide().text("");
            $("#properties_coverImage").css("borderColor", "red");
            $(".errorCoverImage").fadeIn().text("Veuillez indiquer une adresse URL valide !");
            valid = false;
        }
        else
        {
            $("#properties_coverImage").css("borderColor", "green");
            $(".errorCoverImage").hide().text("");
        }

        return valid;
    });
});
