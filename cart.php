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
</head>
<body>
<h1>E-Commerce</h1>
<hr>
<a href="index.php">Torna indietro</a>
<hr>
<h3>Carrello</h3>
<?php if (isset($_COOKIE['cart'])): ?>
    <div class="cart">>
        <ul>
            <?php foreach ($products as $product): ?>
                <?php if (in_array($product['id'], $_COOKIE['cart'])): ?>
                    <div class="product">
                        <h2><?php echo $product['name']; ?></h2>
                        <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name'];?>">
                        <p><?php echo $product['description']; ?></p>
                        <p><?php echo $product['price']; ?> €</p>
                        <button onclick="<?php $_COOKIE['cart'][] = $product['id']; ?>">Rimuovi</button>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<?php if (!isset($_COOKIE['cart'])): ?>
    <h2>Vuoto</h2>
<?php endif; ?>
</body>
</html>
