<?php
include "header.php";
include "db.php";

$q = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
?>

<div class="section">
<h2>Search Results for "<?php echo htmlspecialchars($q); ?>"</h2>

<div class="grid">

<?php
if($q !== ''){
    // Search products
    $sql_products = "SELECT products.*, vendors.name AS vendor_name 
                     FROM products 
                     JOIN vendors ON vendors.id = products.vendor_id 
                     WHERE products.name LIKE '%$q%'";
    $res_products = mysqli_query($conn, $sql_products);

    while($p = mysqli_fetch_assoc($res_products)){
        ?>
        <div class="card">
            <img src="<?php echo $p['image']; ?>" alt="<?php echo $p['name']; ?>">
            <h3><?php echo $p['name']; ?></h3>
            <p><b>Vendor:</b> <?php echo $p['vendor_name']; ?></p>
            <p><b>₦<?php echo number_format($p['price']); ?></b></p>
            <a href="add_to_cart.php?id=<?php echo $p['id']; ?>">Add to Cart</a>
        </div>
        <?php
    }

    // Search stores
    $sql_stores = "SELECT * FROM vendors WHERE name LIKE '%$q%'";
    $res_stores = mysqli_query($conn, $sql_stores);

    while($s = mysqli_fetch_assoc($res_stores)){
        ?>
        <div class="card">
            <h3><?php echo $s['name']; ?></h3>
            <p><?php echo $s['description']; ?></p>
            <a href="products.php?vendor=<?php echo $s['id']; ?>">View Products</a>
        </div>
        <?php
    }

    if(mysqli_num_rows($res_products) + mysqli_num_rows($res_stores) == 0){
        echo "<p>No results found.</p>";
    }
} else {
    echo "<p>Please enter a search term.</p>";
}
?>

</div>
</div>
