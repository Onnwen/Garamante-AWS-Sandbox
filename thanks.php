<?php
if (!isset($_COOKIE['order_id'])) {
    header('Location: index.php');
    exit();
}

setcookie('cart', '', time() - 3600);
setcookie('first_name', $_GET['first_name'], time() + 3600);
setcookie('last_name', $_GET['last_name'], time() + 3600);
setcookie('email', $_GET['email'], time() + 3600);

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
</div>
<hr>
<h3>Ordine completato</h3>
<p>Grazie <?php echo $_GET['first_name'] . " " . $_GET['last_name'] ?> per il tuo ordine, riceverai tra poco un'email di conferma a <?php echo $_GET['email'] ?>. Il Garamante Mall ti ringrazia per aver acquistato sul nostro sito e speriamo di rivederti presto.</p>
<button onclick="window.location.href = 'index.php'" style="margin-top: 30px">Torna agli acquisti</button>
</body>
</html>