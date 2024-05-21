<?php
require_once "dbconfig.in.php";

function get_ID()
{ // the product_id in database is auto increment,So always the last id is the greater one
    $pdo = connect_database();
    $query = 'SELECT AUTO_INCREMENT
    FROM information_schema.TABLES
    WHERE TABLE_SCHEMA = "e-clothing"
    AND TABLE_NAME = "products"';
    $result = $pdo->query($query);
    return $result->fetchColumn(); // I use this ID to store the image with the same ID number that it will be stored in Database
}

function check_img()
{ // this function to check the type of the image uploaded
    if (isset($_FILES['image'])) {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $type = $_FILES["image"]["type"];
            echo $type;
            if ($type !== 'image/jpeg' && $type !== 'image/jpg') {
                error_message("error Pleas just upload jpeg/jpg image");
                exit;
            }
        } else {
            error_message("Upload Unsuccessful!");
            exit;
        }
    } else {
        error_message("Pleas upload product image");
        exit;
    }
}
if (isset($_POST["insert"])) {

    html_header();


    if (empty($_POST["name"])) error_message("pleas enter the product name");
    if (empty($_POST["category"])) error_message("pleas select the product category");
    if (empty($_POST["price"])) error_message("pleas enter the product price");
    if ($_POST["price"] < 1) error_message("pleas enter Valid product price");
    if (empty($_POST["rating"])) error_message("pleas enter the product rating");
    if ($_POST["rating"] > 5 || $_POST["rating"] < 0) error_message("pleas enter rating between 0 - 5");
    if (empty($_POST["description"])) error_message("pleas enter the product description");
    if (empty($_POST["quantity"])) error_message("pleas enter the product quantity");
    if ($_POST["quantity"] < 0) error_message("pleas enter Valid product quantity");

    check_img();


    $archive_dir = "images";
    $id = get_ID();
    $_FILES['image']['name'] = $id . ".jpg";

    $pdo = connect_database();
    $query = "INSERT INTO products (product_name,category,description,price,rating,product_image_name,Quantity)VALUE(?,?,?,?,?,?,?)";
    $statement = $pdo->prepare($query);

    $statement->bindValue(1, $_POST["name"]);
    $statement->bindValue(2, $_POST["category"]);
    $statement->bindValue(3, $_POST["description"]);
    $statement->bindValue(4, $_POST["price"]);
    $statement->bindValue(5, $_POST["rating"]);
    $statement->bindValue(6, $_FILES['image']['name']);
    $statement->bindValue(7, $_POST["quantity"]);

    $done = $statement->execute();

    move_uploaded_file($_FILES['image']['tmp_name'], "$archive_dir/" . $_FILES['image']['name']);
    if ($done) {
        echo "the Insert is Successful";
    } else {
        echo "Something is wrong";
    }
    html_footer();
} else {
    html_header();

?>

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Product Record:</legend>
            <label>Product Name: </label><input type="text" name="name"> <br /><br />
            <label>Category</label>
            <select name="category">
                <option value="" selected disabled>Select Category</option>
                <option value="Tops">Tops</option>
                <option value="Bottoms">Bottoms</option>
                <option value="Dresses">Dresses</option>
            </select>
            <br /><br />
            <label>Price: </label><input type="number" name="price"> <br><br>
            <label>Quantity: </label><input type="number" name="quantity"> <br><br>
            <label>Rating: </label><input type="number" name="rating"> <br><br>
            <label>Description: </label> <br><textarea name="description" rows="9" cols="70" placeholder="Provide a full description about the product"></textarea><br><br>

            <label> Product Photo: </label> <input type="file" name="image"> <br><br>
            <input type="submit" name="insert" value="insert">

        </fieldset>
    </form>
<?php
    html_footer();
}
$pdo = null;
?>