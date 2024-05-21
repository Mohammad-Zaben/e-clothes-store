<?php
define('DBHost', 'localhost');
define('DBName', 'e-clothing');
define('DBUser', 'root');
define('PASS', '');

function connect_database()
{
    try {

        $pdo = new PDO("mysql:host=" . DBHost . ";dbname=" . DBName, DBUser, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

function error_message($msg)
{

    echo "<p><em> error $msg</em></p>";
    html_footer();
    exit;
}

function html_header()
{
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="pragma" content="no-cache" />
        <title>Zaben e-clothing</title>
    </head>

    <body>
        <header>
            <h1>
                <img src="images/Zaben Fashion (1).png" alt="store logo" width="80" /> Zaben
                Fashion
            </h1>
            <nav>
                <a href="products.php">Home</a>
                <a href="add.php">Add New Item</a>
                <a href="contactus.html">Contact Us</a>
            </nav>
        </header>


    <?php

}

function html_footer()
{
    ?>
        <footer>
            <section>
                <p>the last update in: <time datetime="7/3/2024">7/5/2024</time> </p>
                <p>Our address is Ramallah, Al-Ersal Street</p>
            </section>
            <section>
                <a href="contact.html">Contact us</a>
                <p>
                    email:
                    <a href="mailto:mohammad.nail.zaben@gmail.com">mohammad.nail.zaben@gmail.com</a>
                </p>
                <p>Phone: 0597370661</p>
            </section>
        </footer>
    </body>

    </html>
<?php
}
