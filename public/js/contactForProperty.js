$(function(){

    // FOR MESSAGE FOR PROPERTY

    $("#btn_send_contactForProperty").on("click", function(){

        valid = true;
        const message = $("#contact_for_property_message").val();

        if(message === '')
        {
            $("#contact_for_property_message").css("borderColor", "red");
            $(".errorMessageForProperty").fadeIn().text("Veuillez indiquer un message !");
            valid = false;
        }
        else if(message.length < 20)
        {
            $(".errorMessageForProperty").hide("");
            $("#contact_for_property_message").css("borderColor", "red");
            $(".errorMessageForProperty").fadeIn().text("Votre message doit au moins contenir 20 caractères !");
            valid = false;
        }
        else
        {
            $(".errorMessageForProperty").hide("");
            $("#contact_for_property_message").css("borderColor", "green");
        }

        return valid;

    });

    // FOR COMMENT

    $("#btn-send-comment").on("click", function(){

        valid = true;
        const messageComment = $("#comment_message").val();

        if(messageComment === '')
        {
            $("#comment_message").css("borderColor", "red");
            $(".errorMessageComment").fadeIn().text("Veuillez indiquer un message !");
            valid = false;
        }
        else if(messageComment.length < 15)
        {
            $(".errorMessageComment").hide("");
            $("#comment_message").css("borderColor", "red");
            $(".errorMessageComment").fadeIn().text("Votre message doit au moins contenir 15 caractères !");
            valid = false;
        }
        else
        {
            $(".errorMessageComment").hide("");
            $("#comment_message").css("borderColor", "green");
        }

        return valid;
    });
});