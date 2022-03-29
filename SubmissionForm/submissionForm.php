<?php
if(($_POST['action'] ?? false) === 'generate_price') {

    include_once('../Classes/Basket.php');

    $skus = $_POST['values'];

    $Basket = new Basket();

    foreach($skus as $sku => $quantity) {
        $Basket->addProduct($sku, $quantity);
    }

    $Basket->applyDiscounts();
    $Basket->workOutReduction();

    $returnArray = array("total" => $Basket->promotionalTotal, "savings" => $Basket->promotionalReduction);

    echo json_encode($returnArray);

} else {
    include 'submissionForm.html';
}