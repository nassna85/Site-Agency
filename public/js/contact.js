$(function(){
    $("#btn-send-contact").on("click", function(){

        valid = true;
        const name = $("#contact_name").val();
        const email = $("#contact_email").val();
        const message = $("#contact_message").val();
        const phone = $("#contact_phoneNumber").val();

        if(name === '')
        {
            $("#contact_name").css("borderColor", "red");
            $(".errorName").fadeIn().text("Veuillez indiquer votre nom");
            valid = false;
        }
        else if(name.length < 2 || firstName.length > 50)
        {
            $(".errorName").hide().text("");
            $("#contact_name").css("borderColor", "red");
            $(".errorName").fadeIn().text("Votre nom doit contenir entre 2 et 50 caractères !");
            valid = false;
        }
        else if(!name.match(/^[a-zïâéèçà\- ]+$/i))
        {
            $(".errorName").hide().text("");
            $("#contact_name").css("borderColor", "red");
            $(".errorName").fadeIn().text("Votre nom ne doit contenir que des lettres !");
            valid = false;
        }
        else
        {
            $(".errorName").hide().text("");
            $("#contact_name").css("borderColor", "green");
        }

        if(email === '')
        {
            $("#contact_email").css("borderColor", "red");
            $(".errorEmail").fadeIn().text("Veuillez indiquer une adresse email !");
            valid = false;
        }
        else if(!email.match(/^[a-z0-9]+[@]{1}[a-z]{3,8}[\.][a-z]{2,3}$/i))
        {
            $(".errorEmail").hide().text("");
            $("#contact_email").css("borderColor", "red");
            $(".errorEmail").fadeIn().text("Le format de votre email est incorrect !");
            valid = false;
        }
        else
        {
            $(".errorEmail").hide().text("");
            $("#contact_email").css("borderColor", "green");
        }

        if(message === '')
        {
            $("#contact_message").css("borderColor", "red");
            $(".errorMessageContact").fadeIn().text("Veuillez indiquer une description !");
            valid = false;
        }
        else if(message.length < 50)
        {
            $(".errorMessageContact").hide().text("");
            $("#contact_message").css("borderColor", "red");
            $(".errorMessageContact").fadeIn().text("Votre description doit contenir au moins 50 caractères !");
            valid = false;
        }
        else if(!message.match(/[^<>]+$/i))
        {
            $(".errorMessageContact").hide().text("");
            $("#contact_message").css("borderColor", "red");
            $(".errorMessageContact").fadeIn().text("Le format de votre description est incorrect !");
            valid = false;
        }
        else
        {
            $(".errorMessageContact").hide().text("");
            $("#contact_message").css("borderColor", "green");
        }

        if(phone && !phone.match(/[0-9]+$/i))
        {
            $(".errorPhoneNumber").hide().text("");
            $("#contact_phoneNumber").css("borderColor", "red");
            $(".errorPhoneNumber").fadeIn().text("Le format de votre numéro de téléphone est incorrect !");
            valid = false;
        }
        else
        {
            $(".errorPhoneNumber").hide().text("");
            $("#contact_phoneNumber").css("borderColor", "green");
        }


        return valid;

    });
});