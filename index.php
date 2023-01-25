<?php
require_once '../../db.php';

$db_config = $db['db_engine'] . ":host=" . $db['db_host'] . ";dbname=" . $db['db_name'];

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

$totalPrice = 0;
if (isset($_COOKIE['cart'])) {
    $cart = json_decode($_COOKIE['cart']);
    foreach ($cart as $product) {
        foreach ($products as $productData) {
            if ($productData['id'] == $product) {
                $totalPrice += $productData['price'];
            }
        }
    }
}

function isInCart(int $id): bool {
    if (isset($_COOKIE['cart'])) {
        $cart = json_decode($_COOKIE['cart']);
        foreach ($cart as $product) {
            if ($product == $id) {
                return true;
            }
        }
    }
    return false;
}
?>

<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Garamante Mall</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon.png">
</head>
<body>
<h1>Garamante Mall</h1>
<hr>
<div style="width: 100%">
    <a href="cart.php" style="display: inline">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-fill" viewBox="0 0 16 16">
        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </svg>
    </a>
    <a href="buy.php" id="payNowButton" style="display: <?php echo (isset($_COOKIE['cart'])) ? "inline" : "none"; ?>; float: right;">Paga ora (€<span id="totalPrice"><?php echo $totalPrice ?></span>)</a>
</div>
<hr>
<h3>Prodotti</h3>
<div class="products">
    <?php foreach ($products as $product): ?>
        <div class="product">
            <h2><?php echo $product['name']; ?></h2>
            <div class="imageBackground">
                <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
            </div>
            <p class="description"><?php echo $product['description']; ?></p>
            <p><?php echo $product['price']; ?> €</p>
            <button id="<?php echo $product['id'] ?>" onclick="addToCart(<?php echo $product['id'] ?>, <?php echo $product['price'] ?>)" style="opacity: <?php echo isInCart($product['id']) ? "0.5" : "1" ?>" <?php echo isInCart($product['id']) ? "disabled" : "" ?>>Aggiungi al carrello</button>
        </div>
    <?php endforeach; ?>
</div>
</body>
<script>
    function addToCart(id, price) {
        $('#' + id).prop("disabled", true);
        $('#' + id).css("opacity", "0.5");

        $.ajax({
            url: 'addToCart.php',
            type: 'POST',
            data: {
                id: id
            },
            success: function () {
                let totalPriceSpan = $('#totalPrice');

                if (totalPriceSpan.text() === '0') {
                    totalPriceSpan.text(price);
                } else {
                    totalPriceSpan.text((parseFloat(totalPriceSpan.text()) + price).toFixed(2));
                }

                $('#payNowButton').css("display", "inline");
            },
            error: function () {
                $('#' + id).prop("disabled", false);
                $('#' + id).css("opacity", "1");
            }
        });
    }
</script>
</html>