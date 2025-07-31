<?php
include 'includes/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $option_values = [];


    foreach ($_POST as $key => $value) {
        if (strpos($key, 'option_') === 0) {
            $label = str_replace('option_', '', $key);
            $option_values[] = ucfirst($label) . ": " . htmlspecialchars($value);
        }
    }

    $option_string = implode(", ", $option_values);

    $stmt = $conn->prepare("INSERT INTO Cart (product_id, option_values) VALUES (?, ?)");
    $stmt->bind_param("is", $product_id, $option_string);

    if ($stmt->execute()) {
        echo "<script>alert('Product added to cart!'); window.location.href='productcards.php';</script>";
    } else {
        echo "<p style='color:red;'>Error adding to cart: " . $conn->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<p style='color:red;'>Invalid request.</p>";
}
$conn->close();
?>
