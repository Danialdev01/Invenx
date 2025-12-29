<?php

session_start();

include '../config/connect.php';
include '../backend/functions/system.php';
include '../backend/functions/file.php';
include '../backend/functions/csrf-token.php';

// checkCSRFToken();

//@ Create stock
if(isset($_POST['create_stock'])){

    try{
        $id_item = validateInput($_POST['id_item']);
        echo "<br>opening";
        echo $opening_stock = validateInput($_POST['opening_stock']);
        echo "<br>received";
        echo $received_stock = validateInput($_POST['received_stock']);
        echo "<br>closing";
        echo $closing_stock = validateInput($_POST['closing_stock']);
        echo "<br>sold";
        echo $sold_stock = validateInput($_POST['sold_stock']);
        echo "<br>notes";
        echo $notes_stock = validateInput($_POST['notes_stock']);
        echo "<br>date";
        echo $date_stock = validateInput($_POST['date_stock']);
        
        // Convert empty values to 0 for integer columns
        // $opening_stock = (empty($opening_stock) || !is_numeric($opening_stock)) ? 0 : (int)$opening_stock;
        // $received_stock = (empty($received_stock) || !is_numeric($received_stock)) ? 0 : (int)$received_stock;
        // $closing_stock = (empty($closing_stock) || !is_numeric($closing_stock)) ? 0 : (int)$closing_stock;
        // $sold_stock = (empty($sold_stock) || !is_numeric($sold_stock)) ? 0 : (int)$sold_stock;
        
        // Validate that id_item is not empty
        if(empty($id_item)) {
            redirectWithAlert($_SERVER["HTTP_REFERER"], "error", "Item ID diperlukan");
            exit();
        }

        $create_stock_sql = $connect->prepare("INSERT INTO stocks(id_stock, id_item, opening_stock, received_stock, closing_stock, sold_stock, discard_stock, notes_stock, update_at_stock, created_date_stock, status_stock) VALUES (NULL, :id_item, :opening_stock, :received_stock, :closing_stock, :sold_stock, 0, :notes_stock, :update_at_stock, :created_date_stock, 1)");
        
        $create_stock_sql->execute([
            ':id_item' => $id_item,
            ':opening_stock' => $opening_stock,
            ':received_stock' => $received_stock,
            ':closing_stock' => $closing_stock,
            ':sold_stock' => $sold_stock,
            ':notes_stock' => $notes_stock,
            ':update_at_stock' => date("Y-m-d"),
            ':created_date_stock' => $date_stock
        ]);

        log_activity_message("../log/user_activity_log", "Berjaya hasil stock");
        header("Location: " . $_SERVER["HTTP_REFERER"]);   

    }
    catch(Exception $e){
        redirectWithAlert($_SERVER["HTTP_REFERER"], "error", "Ralat hasilkan stock: " . $e->getMessage());
    }
}

else{
    redirectWithAlert("../", "error", "Error Function");
}

?>