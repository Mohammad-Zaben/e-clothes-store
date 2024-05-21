<?php
require_once "dbconfig.in.php";
include "Product.php";

function show_all_records()
{
    $pdo = connect_database();
    $query = "SELECT * FROM products ORDER BY product_id";

    $result = $pdo->query($query);
    display_records($result);
}

function show_filter_records()
{
    $pdo = connect_database();


    if (!empty($_POST["prodName"])) {
        if ($_POST["search"] === "Name" && !isset($_POST["category"])) {
            $name = $_POST["prodName"];
            $query = "SELECT * FROM products WHERE product_name LIKE '%$name%'";
            $result = $pdo->query($query);
            display_records($result);
        } else if ($_POST["search"] === "Price" && !isset($_POST["category"])) {
            $price = $_POST["prodName"];
            $query = "SELECT * FROM products WHERE price >= '$price'";
            $result = $pdo->query($query);
            display_records($result);
        } else if ($_POST["search"] === "Price" && isset($_POST["category"])) {
            $category = $_POST["category"];
            $price = $_POST["prodName"];
            $query = "SELECT * FROM products WHERE price >= '$price' AND category ='$category'";
            $result = $pdo->query($query);
            display_records($result);
        } else if ($_POST["search"] === "Name" && isset($_POST["category"])) {
            $category = $_POST["category"];
            $name = $_POST["prodName"];
            $query = "SELECT * FROM products WHERE product_name LIKE '%$name%' AND category ='$category'";
            $result = $pdo->query($query);
            display_records($result);
        }
    } else {
        show_all_records();
    }
}

function display_records($result)
{
?>
    <p>To Add New Product click on the following link <a href="add.php">Add Product</a> </p>
    <p>Or use the actions below to edit or delete a Product's record</p>


    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
        <fieldset>
            <input type="hidden" name="action" value="filter">
            <legend>Advandced Product Search</legend>
            <input type="text" name="prodName" placeholder="Product Name">
            <input type="radio" name="search" value="Name" checked> Name
            <input type="radio" name="search" value="Price"> Price


            <select name="category">
                <option value="" selected disabled>select category</option>
                <option value="Tops">Tops</option>
                <option value="Bottoms">Bottoms</option>
                <option value="Dresses">Dresses</option>
            </select>
            <input type="submit" value="Filter">
            <br>



            <table border="\0">
                <caption>Products Table Result</caption>
                <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Prodect ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Prce</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($product = $result->fetchObject('Product'))
                        echo $product->displayInTable();
                    echo "</tbody>";
                    echo "</table>";
                    $pdo = null;
                    ?>
        </fieldset>
    </form>
<?php
}

if (empty($_POST)) {
    $_POST['action'] = "";
}

switch ($_POST['action']) {
    case "filter":
        html_header();
        show_filter_records();
        html_footer();
        break;
    default:
        html_header();
        show_all_records();
        html_footer();
}
$pdo = null;

?>