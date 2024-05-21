<?php
require_once "dbconfig.in.php";

$id = $_GET["id"];

function delete_product()
{
    global $id;
    $pdo = connect_database();
    $query = "DELETE FROM products WHERE product_id =  $id;";
    $result = $pdo->query($query);
    if ($result) {
        echo "Delete is done ";
    } else {
        error_message("Product not found.");
    }
}


if (isset($_GET["id"])) {
    if (!empty($_GET["id"])) {
        html_header();
        delete_product();
        html_footer();
    }
} else {
    html_header();
    error_message("invalid ID has been sent");
    html_footer();
}
