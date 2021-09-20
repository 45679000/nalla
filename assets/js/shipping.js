function clientOptions() {
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "load-clients"
        },
        cache: true,
        url: "shipping_action.php",
        success: function (data) {
            $('#client').html(data);

        }
    });
}










function clientWithcodeList(){
    $.ajax({
        url: "../../ajax/common.php",
        type: "POST",
        dataType: "html",
        data: {
            action: "clients"
        },
        success: function(data) {
            $("#clientwithcode").html(data);

        }

    });
    
}




