<?php
require_once "dbconfig.in.php";
include "Product.php";

function check_img()
{ // this function to check the type of the image uploaded
    if (isset($_FILES['image'])) {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $type = $_FILES["image"]["type"];
            if (!$type === 'image/jpeg' || !$type === 'image/jpg') {
                echo "<p><em> error Pleas just upload jpeg/jpg image</em></p>";
                exit;
            }
        } else {
            echo "<p><em>Upload unsuccessful!</em></p><br>\n";
            exit;
        }
    } else {
        echo "<p><em>Pleas upload product image</em></p><br>\n";
        exit;
    }
}
if (isset($_POST["update"])) {
    html_header();


    if (empty($_POST["name"])) error_message("pleas enter the product name");
    if (empty($_POST["price"])) error_message("pleas enter the product price");
    if ($_POST["price"] < 1) error_message("pleas enter Valid product price");
    if (empty($_POST["description"])) error_message("pleas enter the product description");
    if (empty($_POST["quantity"])) error_message("pleas enter the product quantity");
    if ($_POST["quantity"] < 0) error_message("pleas enter Valid product quantity");

    check_img();

    $name = $_POST["name"];
    $price = $_POST["price"];
    $desc = $_POST["description"];
    $quant = $_POST["quantity"];
    $id = $_POST["id"];
    $_FILES['image']['name'] = $id . ".jpeg";
    $image = $_FILES['image']['name'];

    $archive_dir = "images";

    $pdo = connect_database();

    $query = "UPDATE products SET product_name = ?, price = ?, description = ?, Quantity = ?, product_image_name = ? WHERE product_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$name, $price, $desc, $quant, $image, $id]);


    move_uploaded_file($_FILES['image']['tmp_name'], "$archive_dir/" . $_FILES['image']['name']);
    if ($stmt) {
        echo "the Update is Successful";
    } else {
        echo "Something is wrong";
    }
    html_footer();
} else {

    $id = $_GET["id"];

    $pdo = connect_database();
    $query = "SELECT * FROM products WHERE product_id = $id;";
    $result = $pdo->query($query);
    $product = $result->fetchObject('Product');
    html_header();

?>

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Product Record:</legend>
            <input type="hidden" name="id" value="<?php echo $product->getProductID(); ?>">
            <label>Product ID: </label><input type="text" name="id" value="<?php echo $product->getProductID(); ?>" disabled> <br /><br />

            <label>Product Name: </label><input type="text" name="name" value="<?php echo $product->getProductName(); ?>"> <br /><br />
            <label>Category</label>
            <select name="category" disabled>
                <option value="Tops" <?php if ($product->getCategory() === "Tops") echo " selected"; ?>>Tops</option>
                <option value="Bottoms" <?php if ($product->getCategory() === "Bottoms") echo " selected"; ?>>Bottoms</option>
                <option value="Dresses" <?php if ($product->getCategory() === "Dresses") echo " selected"; ?>>Dresses</option>
            </select>
            <br /><br />
            <label>Price: </label><input type="number" name="price" value="<?php echo $product->getPrice(); ?>"> <br><br>
            <label>Quantity: </label><input type="number" name="quantity" value="<?php echo $product->getQuantity(); ?>"> <br><br>
            <label>Rating: </label><input type="number" name="rating" value="<?php echo $product->getRating(); ?>" disabled> <br><br>
            <label>Description: </label> <br><textarea name="description" rows="9" cols="70"><?php echo $product->getDescription(); ?></textarea><br><br>

            <label> Product Photo: </label> <input type="file" name="image"> <br><br>
            <input type="submit" name="update" value="update">

        </fieldset>
    </form>
<?php
    html_footer();
}
$pdo = null;
?>