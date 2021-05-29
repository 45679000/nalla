<?php 
   
    $path_to_root = "../";
    $path_to_root1 = "../";
    include $path_to_root.'models/Model.php';
    require $path_to_root."vendor/autoload.php";
    require_once $path_to_root.'modules/cataloguing/Catalogue.php';
    include 'Report.php';

    $db = new Database();
    $conn = $db->getConnection();
    $catalogue = new Catalogue($conn);
    if(isset($_POST['saleno']) && isset($_POST['broker']) && isset($_POST['category'])){
        echo 'Ccheking Query';
        $data = $catalogue->closingCatalogue($auction = "2021-15", $broker = "ANGL", $category = "Main");
        $rep = new Report();
        $dispArr = array(); 
        foreach($data as $data){
            $dispArr = $data['mark'];
        }
        var_dump($dispArr);
        $rep->printReport($dispArr);

    }

    
?>
<div class="col-md-8 col-lg-10">
    <div class="card">
        <div class="card-body p-6">
            <div class="col-md-12">
                <div class="expanel expanel-secondary">
                <?php
                        echo '<div class="expanel-heading">
                                    <h3 class="expanel-title">Print Catalogue</h3>
                                </div>
                                <div class="expanel-body">
                                    <form>
                                        <div class="row justify-content-center">
                                            <div class="col-md-4 well">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">AUCTION</label>
                                                    <select id="saleno" name="saleno" class="form-control" ><small>(required)</small>
                                                        <option disabled="" value="..." selected="">select</option>
                                                        <option value="2021-01"> 2021-01 </option>
                                                        <option value="2021-02"> 2021-02 </option>
                                                        <option value="2021-03"> 2021-03 </option>
                                                        <option value="2021-04"> 2021-04 </option>
                                                        <option value="2021-05"> 2021-05 </option>
                                                        <option value="2021-06"> 2021-06 </option>
                                                        <option value="2021-07"> 2021-07 </option>
                                                        <option value="2021-08"> 2021-08 </option>
                                                        <option value="2021-09"> 2021-09 </option>
                                                        <option value="2021-10"> 2021-10 </option>
                                                        <option value="2021-11"> 2021-11 </option>
                                                        <option value="2021-12"> 2021-12 </option>
                                                        <option value="2021-15"> 2021-15 </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 well">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">BROKER</label>
                                                    <select id="broker" name="broker" class="form-control well" ><small>(required)</small>
                                                        <option disabled="" value="..." selected="">select</option>
                                                        <option value="ANGL"> ANGL </option>
                                                        <option value="ATLC"> ATLC </option>
                                                        <option value="BICL"> BICL </option>
                                                        <option value="CENT"> CENT </option>
                                                        <option value="CTBL"> CTBL </option>
                                                        <option value="VENS"> VENS </option>
                                                        <option value="UNTB"> UNTB </option>
                                                        <option value="TBE"> TBE </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 well">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">CATEGORY</label>
                                                    <select id="category" name="category" class="form-control well" ><small>(required)</small>
                                                        <option disabled="" value="..." selected="">select</option>
                                                        <option value="Main">Main</option>
                                                        <option value="Sec">Sec</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <iframe src="files/rep.pdf" width="100%" height="800px">
                                    </iframe>
                                </div>';
                ?>
                </div>   
            </div>
            
        </div>
    </div>
</div>

<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>
                
<script type="text/javascript">

$(function() {

    $('select').on('change', function() {
         var saleno = $('#saleno').find(":selected").text();
         var broker = $('#broker').find(":selected").text();
         var category = $('#category').find(":selected").text();
         console.log("ready "+saleno+" broker "+broker+" category "+category);

         if(saleno !=='select' && broker !== 'select' && category !== 'select'){

            var formData = {
                saleno: saleno,
                broker: broker,
                category: category,
            };

          $.ajax({
                type: "POST",
                dataType: "html",
                url: "rep_broker_catalogue.php",
                data: formData,
            success: function (data) {
                console.log('Submission was successful.');
                location.reload();
                console.log(data);
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });

    }

    });

    



    
});
    
</script>
