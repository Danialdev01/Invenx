<?php

    session_start();

    include '../config/connect.php';
    include '../backend/functions/system.php';
    // include '../backend/functions/user.php';
    include '../backend/functions/file.php';
    include '../backend/functions/csrf-token.php';

    // checkCSRFToken();

    //@ Create recipe
    if(isset($_POST['create_item'])){

        try{
            // $user = decryptUser($_SESSION[$token_name], $secret_key);
            // $id_user = $user['id_user'];

            $name_item = validateInput($_POST['name_item']);
            $unit_item = validateInput($_POST['unit_item']);

            $create_item_sql = $connect->prepare("INSERT INTO items (name_item, unit_item, update_at_item, created_date_item, status_item) VALUES (:name_item, :unit_item, :update_at_item, :created_date_item, 1)");
            $create_item_sql->execute([
                ':name_item' => $name_item,
                ':unit_item' => $unit_item,
                ':update_at_item' => date("Y-m-d H:i:s"),
                ':created_date_item' => date("Y-m-d H:i:s")
            ]);

            alert_message("success", "Berjaya hasil recipe");
            log_activity_message("../log/user_activity_log", "Berjaya hasil recipe");
            header("Location:../user/items/");

        }
        catch(Exception $e){
            redirectWithAlert("../", "error", "Ralat hasilkan item");
        }
    }

    else{
        redirectWithAlert("../", "error", "Error Function");
    }

?>