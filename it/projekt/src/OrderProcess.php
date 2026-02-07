<?php
$totalPrice = 0.0;
foreach ($validItems as $item) {
    $totalPrice += (float)$item['price'] * (int)$item['quantity'];
}
$formattedTotal = number_format($totalPrice, 2);
?>
<div class="container">
    <section class="card">
        <section class="order-details">
            <div>
                <p>Your Order Details</p>
                <?php foreach ($validItems as $item) {
                    $name = htmlspecialchars($item['name']);
                    $qty = htmlspecialchars((int)$item['quantity']);
                    $formattedPrice = number_format((float)$item['price'], 2);
                    $subtotal = number_format((float)$item['price'] * (int)$item['quantity'], 2);

                    echo "<div class=\"order-item\">
                        <h3>" . $name . "</h3>
                        <p>Quantity: " . $qty . "</p>
                        <p>Subtotal: " . $formattedPrice . " * " . $qty . " = " . $subtotal . " RSD</p>
                    </div>";
                }
                ?>
            </div>
            <div>
                <p>Checkout</p>
                <h3>Total Price: <?php echo $formattedTotal ?> RSD</h3>
                <div class="order-controls">
                    <input type="button" class="btn" value="Pay" id="payButton"/>
                    <input type="button" class="resetBtn" value="Cancel" id="cancelButton"/>
                </div>
            </div>
        </section>
    </section>
</div>