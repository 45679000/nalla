$(document).ready(function() {
    loadPurchaseList();
    $('#purchaseListTable tbody').on('click', '#allocated', function() {
        var thisCell = table.cell(this);
        alert("table Clicked");
        SubmitData.lot = $(this).parents('tr').find("td:eq(0)").text();
        SubmitData.check = 0;
        console.log(SubmitData);
        // postData(SubmitData, "");

});

    // ('#purchaseListTable').click(function(){
    //     alert("table Clicked");
    // })
    // var trs = document.querySelectorAll("tr");
    //     for (var i = 0; i < trs.length; i++)
    //     (function (e) {
    //         trs[e].addEventListener("click", function () {
    //         console.log({
    //             "lot": this.querySelectorAll("*")[0].innerHTML.trim(),
    //         });
    //         }, false);
    //     })(i);
    function loadPurchaseList() {
        $.ajax({
            url: "../../modules/stock/stock-action.php",
            type: "POST",
            dataType: "html",
            data: {
                action: "purchase-list"
            },
            success: function(response) {
                $("#purchaseList").html(response);
            }

        });
    }
    function checkedRow(){
        var trs = document.querySelectorAll("tr");
        for (var i = 0; i < trs.length; i++)
        (function (e) {
            trs[e].addEventListener("click", function () {
                alert("cliked");
            console.log({
                "lot": this.querySelectorAll("*")[0].innerHTML.trim(),
            });
            }, false);
        })(i);

    }




function postData(formData, PostUrl) {
          $.ajax({
                type: "POST",
                dataType: "html",
                url: PostUrl,
                data: formData,
            success: function (data) {
                console.log('Submission was successful.');
                // location.reload();
                console.log(data);
                return data;
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });


}

});

