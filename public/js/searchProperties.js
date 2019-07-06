$(function(){
    $("#js-btn-search-property").on("click", function(){

        valid = true;
        const maxPrice = $("#properties_search_maxPrice").val();
        const minBedroom = $("#properties_search_minBedroom").val();
        const minArea = $("#properties_search_minArea").val();

        if(maxPrice)
        {
            if(!maxPrice.match(/^[0-9\.?]+$/))
            {
                $("#properties_search_maxPrice").css("borderColor", "red");
                $(".errorMaxPrice").fadeIn().text("Le prix maximum ne doit contenir que des chiffres !");
                valid = false;
            }
            else
            {
                $(".errorMaxPrice").hide().text("");
                $("#properties_search_maxPrice").css("borderColor", "green");
            }
        }

        if(minBedroom)
        {
            if(!minBedroom.match(/^[0-9\.?]+$/))
            {
                $("#properties_search_minBedroom").css("borderColor", "red");
                $(".errorMinBedroom").fadeIn().text("Le nombre de chambre minimum doit être un nombre !");
                valid = false;
            }
            else
            {
                $(".errorMinBedroom").hide().text("");
                $("#properties_search_minBedroom").css("borderColor", "green");
            }
        }

        if(minArea)
        {
            if(!minArea.match(/^[0-9\.?]+$/))
            {
                $("#properties_search_minArea").css("borderColor", "red");
                $(".errorMinArea").fadeIn().text("La surface minimum ne doit contenir que des chiffres !");
                valid = false;
            }
            else
            {
                $(".errorMinArea").hide().text("");
                $("#properties_search_minArea").css("borderColor", "green");
            }
        }

        return valid;

    }) ;
});