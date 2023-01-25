<?php
if (isset($_COOKIE['cart'])) {
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

<?php if (!isset($_COOKIE['cart'])): ?>
    <script>
        window.location.href = 'index.php';
    </script>
<?php endif; ?>

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
        <a href="cart.php" style="display: inline; margin-left: 5px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-fill" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </svg>
        </a>
    </div>
    <hr>
    <h3>Ordine</h3>
    <h2 style="margin-top: 30px;">Riepilogo</h2>
    <hr style="opacity: .5">
    <?php foreach ($products as $product): ?>
        <p>
            <span style="display: inline; font-weight: 500; vertical-align: center;"><?php echo $product['name']; ?></span>
            <span style="display: inline; float: right; vertical-align: center;">€ <?php echo $product['price']; ?></span>
        </p>
    <?php endforeach; ?>
    <hr style="opacity: .5">
    <h3>
        <span style="display: inline; font-weight: 500">Prezzo totale:</span>
        <span style="display: inline; float: right">€ <?php echo $totalPrice; ?></span>
    </h3>
    <div id="paypal-button-container" style="text-align: center; margin-top: 75px;"></div>

    </body>

    <script src="https://www.paypal.com/sdk/js?client-id=AZoJrpMGV_0Syq_sg-LrKLf-YgNRfDzRhf7e8VI_LeOjxrw254-klZIjLMaXujr8R3JnieDVGw-EmqXd&currency=EUR"></script>
    <script>
        paypal.Buttons({
            style: {
                layout: 'vertical',
                color: 'blue',
                shape: 'pill',
                label: 'paypal',
                height: 40
            },
            createOrder: (data, actions) => {
                return actions.order.create({
                    "purchase_units": [{
                        "amount": {
                            "currency_code": "EUR",
                            "value": <?php echo $totalPrice; ?>,
                            "breakdown": {
                                "item_total": {
                                    "currency_code": "EUR",
                                    "value": <?php echo $totalPrice; ?>
                                }
                            }
                        },
                        "items": [
                            <?php foreach ($products as $product): ?>
                            {
                                "name": "<?php echo $product['name']; ?>",
                                "description": "<?php echo $product['description']; ?>",
                                "unit_amount": {
                                    "currency_code": "EUR",
                                    "value": "<?php echo $product['price']; ?>"
                                },
                                "quantity": "1"
                            },
                            <?php endforeach; ?>
                        ]
                    }]
                });
            },
            onApprove: (data, actions) => {
                return actions.order.capture().then(function (orderData) {
                    actions.redirect("thanks.php?first_name=" + orderData.payer.name.given_name + "&last_name=" + orderData.payer.name.surname + "&email=" + orderData.payer.email_address + "&order_id=" + orderData.id);
                });
            }
        }).render('#paypal-button-container');
    </script>
    </html>
<?php
