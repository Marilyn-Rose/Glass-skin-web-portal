<?php
session_start();

$id = intval($_GET['id']);

// Initialize cart if it doesn't exist
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

// Increment quantity or add product
if(isset($_SESSION['cart'][$id])){
    $_SESSION['cart'][$id]++;
}else{
    $_SESSION['cart'][$id] = 1;
}

// Return JSON with updated cart count
$cart_count = array_sum($_SESSION['cart']);
header('Content-Type: application/json');
echo json_encode(['cart_count' => $cart_count]);
exit;
