<?php
if (isset($_POST['id'])) {
    if (isset($_COOKIE['cart'])) {
        $cart = json_decode($_COOKIE['cart']);
    }
    else {
        $cart = array();
    }
    $cart[] = $_POST['id'];
    setcookie('cart', json_encode($cart), time() + 3600);
}
