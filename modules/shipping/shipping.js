function siTemplate() {
    $.ajax({
        url: "shipping_action.php",
        type: "POST",
        dataType: "html",
        data: {
            action: "si-template"
        },
        success: function(response) {
            $("#si-templates").html(response);
        }

    });

}
function editData(){
    $('#si-templates').change(function(){
        var id = $('#si-templates').val();
        $.ajax({
            url: "shipping_action.php",
            type: "POST",
            dataType: "json",
            data: {
                action: "edit-si",
                id: id
            },
            success: function(data) {
                for (const [key, value] of Object.entries(data[0])) {
                    $('#'+key).val(value);
                }

               
            }
    
        });
    });
}
function addSi(){
    $('#si_form').submit(function(e){
        e.preventDefault();
        $("<input />").attr("type", "hidden")
              .attr("name", "action")
              .attr("value", "add-si")
              .appendTo("#si_form");
        $.ajax({   
            type: "POST",
            data : $(this).serialize(),
            cache: false,  
            url: "shipping_action.php",   
            success: function(data){
                swal('',data.message, 'success');
            }   
        });   
        return false;   
    });
}
function switchView(siType){
    if(siType == "blend"){
        $('#tab2').click(function(e) {
            $.ajax({   
            type: "POST",
            dataType:"html",
            data : {
                    action:"load-unallocated",
                    type:"blend"
            },
            cache: true,  
            url: "shipping_action.php",   
                success: function(data){
                    $('#blendTable').html(data);
                    // $("table").DataTable({
                    // });
                }   
            }); 

        });
    }else{
        $('#tab2').click(function(e) {
            $.ajax({   
            type: "POST",
            data : {
                action:"load-unallocated",
                type:"straight"
            },
            cache: true,  
            url: "shipping_action.php",   
                success: function(data){
                    if(data !=null && data !='undefined'){
                        console.log(data);
                        populateDataTable(data);
                    }
                }   
            }); 

        });
    }
}
function updateAllocation(){
    $('#direct_lot tbody').on('click', '#unallocated', function() {
        var thisCell = table.cell(this);
        SubmitData.lot = $(this).parents('tr').find("td:eq(0)").text();
        SubmitData.check = 1;
        console.log(SubmitData);
        postData(SubmitData, "shipping_action.php");

    });
    $('#direct_lot tbody').on('click', '#allocated', function() {
            var thisCell = table.cell(this);
            SubmitData.lot = $(this).parents('tr').find("td:eq(0)").text();
            SubmitData.check = 0;
            console.log(SubmitData);
            postData(SubmitData, "shipping_action.php");

    });
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

function myFunction(){
    alert("I clicked Something");
}

