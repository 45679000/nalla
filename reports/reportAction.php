<?php
$path_to_root = '../';
include $path_to_root . 'models/Model.php';
include $path_to_root . 'database/connection.php';

$db = new Database();
$conn = $db->getConnection();

$action = isset($_POST['action']) ? $_POST['action'] : '';


$model = new Model($conn);

if (isset($_POST['action']) && $_POST['action'] == "printRA") {
    $model->query = "SELECT *FROM closing_cat WHERE ra like '%RA%' AND buyer_package = 'CSS'";
    $data = $model->executeQuery();
    $html = "";
    if (sizeOf($data) > 0) {
        $html = '<table id="closingimports" class="table table-striped table-bordered" style="width:100%">
										<thead>
											<tr>
												<th class="wd-15p">Sale No</th>
												<th class="wd-15p">Lot No</th>
												<th class="wd-15p">Broker</th>
												<th class="wd-15p">Ware Hse.</th>
												<th class="wd-20p">Company</th>
												<th class="wd-15p">Mark</th>
												<th class="wd-10p">Grade</th>
                                                <th class="wd-25p">Invoice</th>
                                                <th class="wd-25p">Type</th>
                                                <th class="wd-25p">Pkgs</th>
                                                <th class="wd-25p">Net</th>
                                                <th class="wd-25p">Kgs</th>
                                                <th class="wd-25p">RA</th>
                                                <th class="wd-25p">Value</th>
                                                <th class="wd-25p">Sale Price</th>
                                                <th class="wd-25p">Buyer Package</th>

											</tr>
										</thead>
                                        <tbody>';
        foreach ($data as $import) {
            $html .= '<tr>';
            $html .= '<td>' . $import["sale_no"] . '</td>';
            $html .= '<td>' . $import["lot"] . '</td>';
            $html .= '<td>' . $import["broker"] . '</td>';
            $html .= '<td>' . $import["ware_hse"] . '</td>';
            $html .= '<td>' . $import["company"] . '</td>';
            $html .= '<td>' . $import["mark"] . '</td>';
            $html .= '<td>' . $import["grade"] . '</td>';
            $html .= '<td>' . $import["invoice"] . '</td>';
            $html .= '<td>' . $import["type"] . '</td>';
            $html .= '<td>' . $import["pkgs"] . '</td>';
            $html .= '<td>' . $import["kgs"] . '</td>';
            $html .= '<td>' . $import["net"] . '</td>';
            $html .= '<td>' . $import["ra"] . '</td>';
            $html .= '<td>' . $import["value"] . '</td>';
            $html .= '<td>' . $import["sale_price"] . '</td>';
            $html .= '<td>' . $import["buyer_package"] . '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>
                        </table>';
    } else {
        $html = "<h3>The selection Does not seem to have any Records</h3>";
    }

    echo $html;
}
if (isset($_POST['action']) && $_POST['action'] == "purchaseList") {
    // $startDate = isset($_POST["from"]) ? $_POST["from"] : '2020-01-01';
    $startSale = isset($_POST["startDate"]) ? $_POST["startDate"] : '2020-01';
    // $endDate = isset($_POST["to"]) ? $_POST["to"] : '2030-12-31';
    $endSale = isset($_POST["endDate"]) ? $_POST["endDate"] : '2021-52';
    $model->query = "SELECT *FROM buying_list WHERE added_to_stock = 1  AND sale_no BETWEEN '$startSale' AND '$endSale' ";
    // import_date BETWEEN CAST('$startDate' AS DATE) AND CAST('$endDate' AS DATE)
    $data = $model->executeQuery();
    $html = "";
    if (sizeOf($data) > 0) {
        $html = '<table id="closingimports" class="table table-striped table-bordered" style="width:100%;">
										<thead>
											<tr>
												<th class="wd-15p">Sale No</th>
												<th class="wd-15p">Lot No</th>
												<th class="wd-15p">Broker</th>
												<th class="wd-15p">Ware Hse.</th>
												<th class="wd-15p">Mark</th>
												<th class="wd-10p">Grade</th>
                                                <th class="wd-25p">Invoice</th>
                                                <th class="wd-25p">Pkgs</th>
                                                <th class="wd-25p">Net</th>
                                                <th class="wd-25p">Kgs</th>
                                                <th class="wd-25p">Sale Price</th>
                                                <th class="wd-25p">Buyer Package</th>

											</tr>
										</thead>
                                        <tbody>';
        foreach ($data as $import) {
            $html .= '<tr>';
            $html .= '<td>' . $import["sale_no"] . '</td>';
            $html .= '<td>' . $import["lot"] . '</td>';
            $html .= '<td>' . $import["broker"] . '</td>';
            $html .= '<td>' . $import["ware_hse"] . '</td>';
            $html .= '<td>' . $import["mark"] . '</td>';
            $html .= '<td>' . $import["grade"] . '</td>';
            $html .= '<td>' . $import["invoice"] . '</td>';
            $html .= '<td>' . $import["pkgs"] . '</td>';
            $html .= '<td>' . $import["kgs"] . '</td>';
            $html .= '<td>' . $import["net"] . '</td>';
            $html .= '<td>' . $import["sale_price"] . '</td>';
            $html .= '<td>' . $import["buyer_package"] . '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>
                        </table>';
    } else {
        $html = "<h3>The selection Does not seem to have any Records</h3>";
    }

    echo $html;
}
