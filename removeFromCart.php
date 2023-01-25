<?php
if (isset($_POST['id'])) {
    if (isset($_COOKIE['cart'])) {
        $cart = json_decode($_COOKIE['cart']);
    }
    else {
        $cart = array();
    }
    $cart = array_filter($cart, function ($value) {
        return $value != $_POST['id'];
    });
    $cart = array_values($cart);
    if (sizeof($cart) == 0) {
        setcookie('cart', '', time() - 3600);
    }
    else {
        setcookie('cart', json_encode($cart), time() + 3600);
    }
}
