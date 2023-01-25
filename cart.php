<?php
if (isset($_COOKIE['cart'])) {
    require_once '../db.php';

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

    $productsSql = "SELECT * FROM products WHERE id IN (" . implode(',', json_decode($_COOKIE['cart'])) . ")";
    $productsQuery = $pdo->prepare($productsSql);
    $productsQuery->execute();

    $products = $productsQuery->fetchAll(PDO::FETCH_ASSOC);
}

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
?>

<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>E-Commerce</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<h1>Garamante Mall</h1>
<hr>
<div style="width: 100%">
    <a href="index.php" style="display: inline">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"/>
            <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"/>
        </svg>
    </a>
    <a href="buy.php" id="payNowButton" style="display: <?php echo (isset($_COOKIE['cart'])) ? "inline" : "none"; ?>; float: right;">
        Paga ora (€<span id="totalPrice"><?php echo $totalPrice ?></span>)
    </a>
</div>
<hr>
<h3>Carrello</h3>
<?php if (isset($_COOKIE['cart'])): ?>
    <div class="products">
        <?php foreach ($products as $product): ?>
            <div class="product" id="<?php echo $product['id']; ?>">
                <h2><?php echo $product['name']; ?></h2>
                <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
                <p class="description"><?php echo $product['description']; ?></p>
                <p><?php echo $product['price']; ?> €</p>
                <button onclick="removeFromCart(<?php echo $product['id']; ?>, <?php echo $product['price'] ?>)">Rimuovi</button>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php if (!isset($_COOKIE['cart'])): ?>
    <h2>Vuoto</h2>
<?php endif; ?>
</body>
<script>
    function removeFromCart(id, price) {
        $.ajax({
            url: 'removeFromCart.php',
            type: 'POST',
            data: {
                id: id
            },
            success: function () {
                $('#' + id).remove();

                let totalPriceSpan = $('#totalPrice');
                if (totalPriceSpan.text() === '0') {
                    totalPriceSpan.text(price);
                } else {
                    console.log(parseFloat(totalPriceSpan.text()));
                    totalPriceSpan.text((parseFloat(totalPriceSpan.text()) - price).toFixed(2));
                }

                if (parseFloat(totalPriceSpan.text()) === 0) {
                    window.location.href = 'index.php';
                }
            }
        });
    }
</script>
</html>
