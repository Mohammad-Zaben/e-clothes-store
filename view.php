<?php
require_once "dbconfig.in.php";
include "Product.php";

function show_Det()
{
    $pdo = connect_database();
    $id = $_GET["id"];
    $query = "SELECT * FROM products WHERE product_id = $id;";
    $result = $pdo->query($query);
    $product = $result->fetchObject('Product');
    if ($product) {
        echo $product->displayProdcutPage();
    } else {
        error_message("Product not found.");
    }
}

if (isset($_GET["action"])) {
    if (!empty($_GET["id"])) {
        html_header();
        show_Det();
        html_footer();
    } else {
        html_header();
        error_message("invalid ID has been sent");
        html_footer();
    }
} else {
    html_header();
    error_message("Something is wrong!");
    html_footer();
}
