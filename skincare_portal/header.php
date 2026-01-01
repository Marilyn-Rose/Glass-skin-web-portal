<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$current = basename($_SERVER['PHP_SELF']);

$cart_count = 0;
if(isset($_SESSION['cart'])){
    foreach($_SESSION['cart'] as $qty){
        $cart_count += $qty;
    }
}
?>

<link rel="stylesheet" href="style.css">

<div class="navbar">
    <!-- Logo -->
    <a class="logo" href="index.php">
        <img src="images/logo.png" alt="GlowSkin Logo">
    </a>

    <!-- Center Menu -->
    <div class="menu">
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="stores.php">Stores</a>
    </div>

    <!-- Right Icons -->
    <div class="right-icons">

        <!-- Search Icon -->
        <a href="#" class="search-icon" id="search-toggle">🔍</a>

        <!-- Search Bar -->
        <form id="search-form" action="products.php" method="GET">
            <input type="text" name="search" placeholder="Search products...">
            <button type="submit">Search</button>
        </form>

        <!-- Cart Icon -->
        <a href="cart.php" class="cart-icon">
            🛒 <span><?php echo $cart_count; ?></span>
        </a>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchToggle = document.getElementById("search-toggle"); // <-- FIXED
    const searchForm = document.getElementById("search-form");

    if(searchToggle && searchForm){
        searchToggle.addEventListener("click", function(e){
            e.preventDefault();
            searchForm.classList.toggle("show");
        });
    }
});
</script>


