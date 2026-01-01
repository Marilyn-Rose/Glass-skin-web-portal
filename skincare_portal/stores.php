<?php
include "header.php";
include "db.php";
?>

<link rel="stylesheet" href="style.css">

<section class="stores-page">
    
    <div class="stores-hero">
        <h1>Available Stores</h1>
        <p>Shop from trusted skincare vendors offering quality beauty and wellness products</p>
    </div>

    <div class="stores-grid">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM vendors");
        while($store = mysqli_fetch_assoc($result)){ ?>
        
        <div class="store-card">
            
            <div class="store-header">
                <h3><?php echo htmlspecialchars($store['name']); ?></h3>
            </div>

            <p class="store-desc">
                <?php echo htmlspecialchars($store['description'] ?? 'No description available'); ?>
            </p>

            <a href="products.php?vendor=<?php echo $store['id']; ?>" class="store-btn">
                View Products →
            </a>
        </div>

        <?php } ?>
    </div>

</section>
