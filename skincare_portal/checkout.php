<?php
session_start();
include "db.php";
include "header.php";

// Prevent access if cart empty
if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
    header("Location: cart.php");
    exit;
}
?>

<style>

/* -------- PAGE BACKGROUND -------- */
.checkout-page {
    width: 100%;
    min-height: 100vh;
    background: linear-gradient(to right, #ffe9f3, #fff);
    display: flex;
    justify-content: center;
    padding: 40px 10px;
}

/* -------- MAIN CARD -------- */
.checkout-wrapper {
    width: 100%;
    max-width: 1100px;
    background: #ffffff;
    border-radius: 18px;
    padding: 30px 35px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.1);
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 35px;
}

/* -------- LEFT SIDE -------- */
.checkout-left h2 {
    font-size: 26px;
    margin-bottom: 20px;
    font-weight: 800;
}

.checkout-form input {
    width: 100%;
    padding: 14px;
    margin-top: 10px;
    border-radius: 10px;
    border: 1.5px solid #ddd;
    outline: none;
    font-size: 15px;
    transition: .2s;
}

.checkout-form input:focus {
    border-color: #ff3d85;
    box-shadow: 0 0 4px rgba(255,61,133,.4);
}

/* -------- BUTTON -------- */
.place-order-btn {
    width: 100%;
    margin-top: 20px;
    padding: 14px;
    border-radius: 10px;
    border: none;
    background: linear-gradient(to right,#111,#333);
    color: white;
    font-size: 16px;
    font-weight: 800;
    cursor: pointer;
    transition: .2s;
}

.place-order-btn:hover {
    transform: translateY(-2px);
    background: linear-gradient(to right,#000,#222);
}

/* -------- ORDER SUMMARY -------- */
.summary-box {
    background: #fafafa;
    border-radius: 14px;
    padding: 20px;
    border: 1px solid #eee;
}

.summary-box h3 {
    margin-bottom: 10px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    padding: 7px 0;
    font-size: 15px;
}

.summary-total {
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px solid #ddd;
    display: flex;
    justify-content: space-between;
    font-size: 17px;
    font-weight: 800;
}

/* -------- RESPONSIVE -------- */
@media(max-width: 900px){
    .checkout-wrapper{
        grid-template-columns: 1fr;
    }
}

</style>


<div class="checkout-page">
<div class="checkout-wrapper">

<!-- LEFT SIDE -->
<div class="checkout-left">
    <h2>Checkout</h2>

    <form method="POST" action="place_order.php" class="checkout-form">

        <input type="text" name="name" placeholder="Full Name" required>
        <input type="text" name="address" placeholder="Delivery Address" required>
        <input type="text" name="phone" placeholder="Phone Number" required>

        <button type="submit" class="place-order-btn">
            Place Order
        </button>
    </form>
</div>


<!-- RIGHT SIDE – ORDER SUMMARY -->
<div class="summary-box">
    <h3>Order Summary</h3>

    <?php
    $grand_total = 0;

    foreach($_SESSION['cart'] as $id => $qty){
        $id = intval($id);
        $qty = intval($qty);

        $query = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
        $p = mysqli_fetch_assoc($query);

        $total = $p['price'] * $qty;
        $grand_total += $total;
    ?>
        <div class="summary-item">
            <span><?php echo $p['name']; ?> (x<?php echo $qty; ?>)</span>
            <span>₦<?php echo number_format($total); ?></span>
        </div>
    <?php } ?>

    <div class="summary-total">
        <span>Total to Pay</span>
        <span>₦<?php echo number_format($grand_total); ?></span>
    </div>
</div>

</div>
</div>
