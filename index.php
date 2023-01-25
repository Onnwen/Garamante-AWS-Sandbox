<?php
session_start();

require_once 'db.php';

$db_config = $db['db_engine'] . ":host=".$db['db_host'] . ";dbname=" . $db['db_name'];

try {
    $pdo = new PDO($db_config, $db['db_user'], $db['db_password'], [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ]);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    exit("Impossibile connettersi al database: " . $e->getMessage());
}

$productsSql = "SELECT * FROM products";
$productsQuery = $pdo->prepare($productsSql);
$productsQuery->execute();

$products = $productsQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>E-Commerce</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h1>E-Commerce</h1>
    <hr>
    <a href="cart.php">Vedi carrello</a>
    <hr>
    <h3>Prodotti</h3>
    <div class="products">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <h2><?php echo $product['name']; ?></h2>
                <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name'];?>">
                <p><?php echo $product['description']; ?></p>
                <p><?php echo $product['price']; ?> €</p>
                <button onclick="addToCart(<?php echo $product['id'] ?>)">Aggiungi al carrello</button>
            </div>
        <?php endforeach; ?>
    </div>
</body>
<script>
    function addToCart(id) {
        $.ajax({
            url: 'addToCart.php',
            type: 'POST',
            data: {
                id: id
            }
        });
    }
</script>
</html>