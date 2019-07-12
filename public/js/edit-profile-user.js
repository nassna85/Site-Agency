$(function(){
    $("#btn-edit-profile-user").on("click", function(){

        valid = true;
        const firstName = $("#account_firstName").val();
        const lastName = $("#account_lastName").val();
        const avatar = $("#account_avatar").val();
        const email = $("#account_email").val();

        if(firstName === '')
        {
            $("#account_firstName").css("borderColor", "red");
            $(".errorFirstName").fadeIn().text("Veuillez indiquer votre prénom");
            valid = false;
        }
        else if(firstName.length < 2 || firstName.length > 50)
        {
            $(".errorFirstName").hide().text("");
            $("#account_firstName").css("borderColor", "red");
            $(".errorFirstName").fadeIn().text("Votre prénom doit contenir entre 2 et 50 caractères !");
            valid = false;
        }
        else if(!firstName.match(/^[a-zïâéèçà\- ]+$/i))
        {
            $(".errorFirstName").hide().text("");
            $("#account_firstName").css("borderColor", "red");
            $(".errorFirstName").fadeIn().text("Votre prénom ne doit contenir que des lettres !");
            valid = false;
        }
        else
        {
            $(".errorFirstName").hide().text("");
            $("#account_firstName").css("borderColor", "green");
        }

        if(lastName === '')
        {
            $("#account_lastName").css("borderColor", "red");
            $(".errorLastName").fadeIn().text("Veuillez indiquer votre nom");
            valid = false;
        }
        else if(lastName.length < 2 || lastName.length > 50)
        {
            $(".errorLastName").hide().text("");
            $("#account_lastName").css("borderColor", "red");
            $(".errorLastName").fadeIn().text("Votre nom doit contenir entre 2 et 50 caractères !");
            valid = false;
        }
        else if(!lastName.match(/^[a-zïâéèçà\- ]+$/i))
        {
            $(".errorLastName").hide().text("");
            $("#account_lastName").css("borderColor", "red");
            $(".errorLastName").fadeIn().text("Votre nom ne doit contenir que des lettres !");
            valid = false;
        }
        else
        {
            $(".errorLastName").hide().text("");
            $("#account_lastName").css("borderColor", "green");
        }

        if(avatar && !avatar.match(/https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,}/i))
        {
            $(".errorAvatar").hide().text("");
            $("#account_avatar").css("borderColor", "red");
            $(".errorAvatar").fadeIn().text("Le format de votre URL est incorrect !");
            valid = false;
        }
        else
        {
            $(".errorAvatar").hide().text("");
            $("#account_avatar").css("borderColor", "green");
        }

        if(email === '')
        {
            $("#account_email").css("borderColor", "red");
            $(".errorEmail").fadeIn().text("Veuillez indiquer une adresse email !");
            valid = false;
        }
        else if(!email.match(/^[a-z0-9\.\-\_]+[@]{1}[a-z]{3,8}[\.][a-z]{2,3}$/i))
        {
            $(".errorEmail").hide().text("");
            $("#account_email").css("borderColor", "red");
            $(".errorEmail").fadeIn().text("Le format de votre email est incorrect !");
            valid = false;
        }
        else
        {
            $(".errorEmail").hide().text("");
            $("#account_email").css("borderColor", "green");
        }

        return valid;
    });
});