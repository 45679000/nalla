<?php
$path_to_root = "../../";
require_once $path_to_root . 'templates/header.php';
// if(isset($_POST['submit'])){
//     // Count total uploaded files
//     $totalfiles = count($_FILES['file']['name']);
//     $instruction_id = $_POST['si'];
    
//     // Looping over all files
//     for($i=0;$i<$totalfiles;$i++){
//     $filename = $_FILES['file']['name'][$i];
        
//         // Upload files and store in database
//         if(move_uploaded_file($_FILES["file"]["tmp_name"][$i],$path_to_root.'upload/'.$filename)){
//             // Image db insert sql
//             // $insert = "INSERT INTO `shippmentFiles` (`id`, `file_name`, `uploaded_on`, `instruction_id`) VALUES (NULL, '$filename', CURRENT_TIMESTAMP , '$instruction_id')";
//             // if(mysqli_query($conn, $insert)){
//             //     echo 'Data inserted successfully';
//             // }
//             // else{
//             //     echo 'Error: '.mysqli_error($conn);
//             // }
//         }else{
//             echo 'Error in uploading file - '.$_FILES['file']['name'][$i].'<br/>';
//         } 
//     }
// } 
?>
<style>
    .modal {
        text-align: center;
    }

    @media screen and (min-width: 768px) {
        .modal:before {
            display: inline-block;
            vertical-align: middle;
            content: " ";
            height: 100%;
        }
    }

    .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
    }
    #allShippments p{
        padding: 1rem;
        border-bottom: 1px solid #333;
    }
</style>

<body class="container-fluid">
    <div id="global-loader"></div>
    <div class="page">
        <div class="page-main">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-light">Shippments' Supporting documents</h3>
                </div>
                <div class="alert alert-info m-5" role="alert" id="successMessage">Done! Check Table below to confirm that they are saved</div>
                <div class="col-md-6 my-5 ">
                    <form action="" id="uploadForm">
                        <select id="si" name="si" class="select form-control"><small>(required)</small></select>
                        <!-- <input type="text" name="si-no" id="si-no" placeholder="Choose si No." class="form-control"> -->
                        <input type="file" id="pdf" name="pdf[]" class="form-control" multiple>
                        <input type="submit" value="Upload Files" class="btn btn-secondary" id="uploadBtn">
                    </form>
                </div>
                <div class="col-md-6 mt-5">
                    <p class="p-2 h5">Choose Shipping instruction to view it's Uploaded documents</p>
                    <select id="shipping_instruction" name="si" class="select form-control"><small>(required)</small></select>
                </div>
                <div class="card col-12 p-md-4" id="">
                    <div class='card p-3 '><h3 class='h3'>Documents of contract Number -  <span id="contractNumber"></span></h3>
                    <div id="allShippments" class="" ></div>
                </div>
                
            </div>
        </div>
    </div>
    </div>
    



    <script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
    <script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
    <script src="../../assets/js/vendors/circle-progress.min.js"></script>
    <!-- Custom Js-->
    <script src="../../assets/js/custom.js"></script>
    <script src="../../assets/js/warehousing.js"></script>

    <script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
    <script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../../assets/js/sweet_alert2.js"></script>

    <script>
        $('#successMessage').hide()
        siList()
        function siList() {
            $.ajax({
                url: "warehousing_action.php",
                type: "POST",
                dataType: "html",
                data: {
                    action: "list-si"
                },
                success: function(response) {
                    $("#si").html(response);
                }

            });
        }
        $("#uploadForm").on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type: 'POST',
                action: 'upload-files',
                url: 'warehousing_action.php',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function(response){
                    console.log(response);
                    // $('#successMessage').show()
                },
                error: function(error) {
                    // console.error(error);
                    if(error.status == 200){
                        $('#successMessage').show()
   
                    }
                }
            });
        });
        shippingInstructionList()
        function shippingInstructionList() {
            $.ajax({
                url: "warehousing_action.php",
                type: "POST",
                dataType: "html",
                data: {
                    action: "list-si"
                },
                success: function(response) {
                    $("#shipping_instruction").html(response);
                }

            });
        }
        $("#shipping_instruction").change(
            function(e){
                si = e.target.value;
                document.getElementById('contractNumber').innerHTML = $( "#shipping_instruction option:selected" ).text();
                $.ajax({
                url: "warehousing_action.php",
                type: "POST",
                dataType: "html",
                data: {
                    si: si,
                    action: "si-documents"
                },
                success: function(response) {
                    $('#allShippments').html(response);
                    $("#all-shipping-instructions").DataTable({})
                }

            });
            }
        )
    </script>

    </html>