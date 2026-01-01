<?php
session_start();
include "db.php";

// Check if form was submitted
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        echo "Your cart is empty!";
        exit;
    }

    // Calculate total
    $grand_total = 0;
    foreach($_SESSION['cart'] as $id => $qty){
        $id = intval($id);
        $q = mysqli_query($conn, "SELECT price FROM products WHERE id=$id");
        $p = mysqli_fetch_assoc($q);
        $grand_total += $p['price'] * $qty;
    }

    // Save order into database (optional)
    $cart_json = json_encode($_SESSION['cart']);
    $insert = mysqli_query($conn, "INSERT INTO orders (fullname,email,phone,address,cart,total) VALUES ('$fullname','$email','$phone','$address','$cart_json',$grand_total)");

    if($insert){
        // Clear cart
        unset($_SESSION['cart']);
        header("Location: order_success.php");
        exit;
    } else {
        echo "Error placing order: " . mysqli_error($conn);
    }
}
?>
