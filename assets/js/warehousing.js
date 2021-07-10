function loadUnclosedBlends() {
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "show-unclosed"
        },
        cache: true,
        url: "../modules/blending/blend_action.php",
        success: function (data) {
            $('#tableData').html(data);

        }
    });
}
