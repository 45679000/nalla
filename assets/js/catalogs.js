
function buyingSummary(){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "list-buying"
        },
        cache: true,
        url: "catalog_action.php",
        success: function (data) {
         $('#listBuying').html(data);

        }
    });
}


