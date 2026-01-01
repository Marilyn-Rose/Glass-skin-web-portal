<?php
session_start();

$id = intval($_GET['id']); // Sanitize input

// Check if cart exists and product exists in cart
if(isset($_SESSION['cart'][$id])){
    unset($_SESSION['cart'][$id]); // Remove the product from cart
}

// Redirect back to cart page
header("Location: cart.php");
exit;
