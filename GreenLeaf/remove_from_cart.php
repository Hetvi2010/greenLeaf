<?php
include 'includes/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id'])) {
    $cart_id = intval($_POST['cart_id']);
    $conn->query("DELETE FROM Cart WHERE id = $cart_id");

    echo "<script>alert('Item removed from cart'); window.location.href='view_cart.php';</script>";
} else {
    echo "<p style='color:red;'>Invalid request.</p>";
}
$conn->close();
?>
