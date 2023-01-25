<?php
if (isset($_POST['id'])) {
    if (!isset($_COOKIE['cart'])) {
        setcookie('cart[]', $_POST['id'], time() + 3600);
    } else {
        $cart = $_COOKIE['cart'];
        $cart[] = $_POST['id'];
        setcookie('cart[]', $cart, time() + 3600);
    }
} 