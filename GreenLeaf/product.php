<?php
include 'includes/db_config.php';


$search = isset($_GET['search']) ? $_GET['search'] : '';
$price_filter = isset($_GET['price_filter']) ? $_GET['price_filter'] : '';
$days_filter = isset($_GET['days_filter']) ? $_GET['days_filter'] : '';


$template = file_get_contents("templates/product_template.html");


$sql = "SELECT * FROM ProductCards WHERE 1=1";

if (!empty($search)) {
    $safe = $conn->real_escape_string($search);
    $sql .= " AND (title LIKE '%$safe%' OR description LIKE '%$safe%')";
}

if ($price_filter === 'low') {
    $sql .= " AND price < 10";
} elseif ($price_filter === 'mid') {
    $sql .= " AND price BETWEEN 10 AND 15";
} elseif ($price_filter === 'high') {
    $sql .= " AND price > 15";
}

if ($days_filter === 'short') {
    $sql .= " AND days_left < 200";
} elseif ($days_filter === 'medium') {
    $sql .= " AND days_left BETWEEN 200 AND 300";
} elseif ($days_filter === 'long') {
    $sql .= " AND days_left > 300";
}

$sql .= " ORDER BY id DESC";
$result = $conn->query($sql);


$product_cards = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $product_cards .= '
<form method="POST" action="add_to_cart.php">
  <div class="product-card">
    <div class="product-image">
      <img src="' . htmlspecialchars($row['image_path']) . '" alt="' . htmlspecialchars($row['title']) . '">
      <div class="badge">' . intval($row['days_left']) . ' days left</div>
    </div>
    <div class="product-content">
      <h2 class="product-title">' . htmlspecialchars($row['title']) . '</h2>
      <p class="product-desc">' . htmlspecialchars($row['description']) . '</p>
      ' . $option_html . '

      <div class="rating">
        <div class="stars">★ ★ ★ ★ ★</div>
        <div class="review-count">' . intval($row['rating']) . '</div>
      </div>

      <input type="hidden" name="product_id" value="' . $row['id'] . '">
      <div class="price-delete">
        <div class="price">$' . number_format($row['price'], 2) . '</div>
        <div class="card-actions">
          <button type="submit" name="add_to_cart" class="cart-btn" title="Add to Cart">
            <i class="fa fa-cart-plus"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</form>';

    }
} else {
    $product_cards = "<p style='text-align:center;'>No products found.</p>";
}

$conn->close();


$output = str_replace("{{PRODUCT_CARDS}}", $product_cards, $template);
$output = str_replace("{{SEARCH_QUERY}}", htmlspecialchars($search), $output);
$output = str_replace("{{PRICE_LOW}}", $price_filter === 'low' ? 'selected' : '', $output);
$output = str_replace("{{PRICE_MID}}", $price_filter === 'mid' ? 'selected' : '', $output);
$output = str_replace("{{PRICE_HIGH}}", $price_filter === 'high' ? 'selected' : '', $output);
$output = str_replace("{{DAYS_SHORT}}", $days_filter === 'short' ? 'selected' : '', $output);
$output = str_replace("{{DAYS_MEDIUM}}", $days_filter === 'medium' ? 'selected' : '', $output);
$output = str_replace("{{DAYS_LONG}}", $days_filter === 'long' ? 'selected' : '', $output);

echo $output;
?>
