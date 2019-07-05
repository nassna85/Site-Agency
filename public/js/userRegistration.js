$(function(){
    $("#registration_firstName").focus();

    $("#btn-register-user").on("click", function(){
        valid = true;

        const firstName = $("#registration_firstName").val();
        const lastName = $("#registration_lastName").val();
        const avatar = $("#registration_avatar").val();
        const email = $("#registration_email").val();
        const password = $("#registration_password").val();
        const passwordConfirm = $("#registration_passwordConfirm").val();

        if(firstName === '')
        {
            $("#registration_firstName").css("borderColor", "red");
            $(".errorFirstName").fadeIn().text("Veuillez indiquer votre prénom");
            valid = false;
        }
        else if(firstName.length < 2 || firstName.length > 50)
        {
            $(".errorFirstName").hide().text("");
            $("#registration_firstName").css("borderColor", "red");
            $(".errorFirstName").fadeIn().text("Votre prénom doit contenir entre 2 et 50 caractères !");
            valid = false;
        }
        else if(!firstName.match(/^[a-zïâéèçà\- ]+$/i))
        {
            $(".errorFirstName").hide().text("");
            $("#registration_firstName").css("borderColor", "red");
            $(".errorFirstName").fadeIn().text("Votre prénom ne doit contenir que des lettres !");
            valid = false;
        }
        else
        {
            $(".errorFirstName").hide().text("");
            $("#registration_firstName").css("borderColor", "green");
        }

        if(lastName === '')
        {
            $("#registration_lastName").css("borderColor", "red");
            $(".errorLastName").fadeIn().text("Veuillez indiquer votre nom");
            valid = false;
        }
        else if(lastName.length < 2 || lastName.length > 50)
        {
            $(".errorLastName").hide().text("");
            $("#registration_lastName").css("borderColor", "red");
            $(".errorLastName").fadeIn().text("Votre nom doit contenir entre 2 et 50 caractères !");
            valid = false;
        }
        else if(!lastName.match(/^[a-zïâéèçà\- ]+$/i))
        {
            $(".errorLastName").hide().text("");
            $("#registration_lastName").css("borderColor", "red");
            $(".errorLastName").fadeIn().text("Votre nom ne doit contenir que des lettres !");
            valid = false;
        }
        else
        {
            $(".errorLastName").hide().text("");
            $("#registration_lastName").css("borderColor", "green");
        }

        if(avatar && !avatar.match(/https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,}/i))
        {
            $(".errorAvatar").hide().text("");
            $("#registration_avatar").css("borderColor", "red");
            $(".errorAvatar").fadeIn().text("Le format de votre URL est incorrect !");
            valid = false;
        }
        else
        {
            $(".errorAvatar").hide().text("");
            $("#registration_avatar").css("borderColor", "green");
        }

        if(email === '')
        {
            $("#registration_email").css("borderColor", "red");
            $(".errorEmail").fadeIn().text("Veuillez indiquer une adresse email !");
            valid = false;
        }
        else if(!email.match(/^[a-z0-9]+[@]{1}[a-z]{3,8}[\.][a-z]{2,3}$/i))
        {
            $(".errorEmail").hide().text("");
            $("#registration_email").css("borderColor", "red");
            $(".errorEmail").fadeIn().text("Le format de votre email est incorrect !");
            valid = false;
        }
        else
        {
            $(".errorEmail").hide().text("");
            $("#registration_email").css("borderColor", "green");
        }

        if(password === '')
        {
            $("#registration_password").css("borderColor", "red");
            $(".errorPassword").fadeIn().text("Veuillez indiquer un mot de passe !");
            valid = false;
        }
        else if(password.length < 6 || password.length > 12)
        {
            $(".errorPassword").hide().text("");
            $("#registration_password").css("borderColor", "red");
            $(".errorPassword").fadeIn().text("Votre mot de passe doit contenir entre 4 et 12 caractères !");
            valid = false;
        }
        else
        {
            $(".errorPassword").hide().text("");
            $("#registration_password").css("borderColor", "green");
        }

        if(passwordConfirm === '')
        {
            $("#registration_passwordConfirm").css("borderColor", "red");
            $(".errorPasswordConfirm").fadeIn().text("Veuillez indiquer une confirmation de mot de passe !");
            valid = false;
        }
        else if(passwordConfirm.length < 6 || passwordConfirm.length > 12)
        {
            $(".errorPasswordConfirm").hide().text("");
            $("#registration_passwordConfirm").css("borderColor", "red");
            $(".errorPasswordConfirm").fadeIn().text("Votre confirmation de mot de passe doit contenir entre 4 et 12 caractères !");
            valid = false;
        }
        else if(password !== passwordConfirm)
        {
            $(".errorPasswordConfirm").hide().text("");
            $("#registration_passwordConfirm").css("borderColor", "red");
            $(".errorPasswordConfirm").fadeIn().text("Veuillez indiquer un mot de passe de confirmation identique !");
            valid = false;
        }
        else
        {
            $(".errorPasswordConfirm").hide().text("");
            $("#registration_passwordConfirm").css("borderColor", "green");
        }

        return valid;
    });
});