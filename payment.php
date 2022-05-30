<?php
$title = 'Thanh toán';
require_once("./layouts/header.php");
session_start();

if (!isset($_GET['paymentMethod'])) {
    $payment = 'un';
} else {
    echo "<script>alert('Cam on ban da dat hang');location.href ='/';</script>";
    unset($_SESSION["cart_item"]);
}
?>
<div class="row">
    <?php
    if (isset($_SESSION["cart_item"])) {
        $total_quantity = 0;
        $total_price = 0;
    ?>
        <div class="col-md-5 col-lg-4 order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Giỏ hàng của bạn</span>
            </h4>
            <ul class="list-group mb-3">
                <?php
                foreach ($_SESSION["cart_item"] as $item) {
                    $item_price = $item["quantity"] * $item["price"];
                ?>

                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0"><?php echo $item["name"]; ?></h6>
                            <small class="text-muted">SL: <?php echo number_format($item["quantity"]); ?> - Giá : <?php echo number_format($item["price"]) . " VNĐ"; ?> </small>
                        </div>
                        <span class="text-muted"><?php echo number_format($item_price) . " VNĐ"; ?></span>
                    </li>
                <?php
                    $total_quantity += $item["quantity"];
                    $total_price += ($item["price"] * $item["quantity"]);
                }
                ?>

                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (VNĐ)</span>
                    <strong><?php echo "$ " . number_format($total_price); ?></strong>
                </li>
            </ul>

            <form class="card p-2">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Promo code">
                    <button type="submit" class="btn btn-secondary">Redeem</button>
                </div>
            </form>
        </div>
    <?php
    }
    ?>

    <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Thông tin thanh toán</h4>
        <form class="needs-validation" novalidate>
            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="firstName" class="form-label">First name</label>
                    <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
                    <div class="invalid-feedback">
                        Valid first name is required.
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="lastName" class="form-label">Last name</label>
                    <input type="text" class="form-control" id="lastName" placeholder="" value="" required>
                    <div class="invalid-feedback">
                        Valid last name is required.
                    </div>
                </div>

                <div class="col-12">
                    <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
                    <input type="email" class="form-control" id="email" placeholder="you@example.com">
                    <div class="invalid-feedback">
                        Please enter a valid email address for shipping updates.
                    </div>
                </div>

                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
                    <div class="invalid-feedback">
                        Please enter your shipping address.
                    </div>
                </div>

                <div class="col-md-5">
                    <label for="country" class="form-label">Country</label>
                    <select class="form-select" id="country" required>
                        <option value="">Choose...</option>
                        <option>Việt Nam</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select a valid country.
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="state" class="form-label">State</label>
                    <select class="form-select" id="state" required>
                        <option value="">Choose...</option>
                        <option>Hà Nội</option>
                    </select>
                    <div class="invalid-feedback">
                        Please provide a valid state.
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="zip" class="form-label">Zip</label>
                    <input type="text" class="form-control" id="zip" placeholder="" required>
                    <div class="invalid-feedback">
                        Zip code required.
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="same-address">
                <label class="form-check-label" for="same-address">Shipping address is the same as my billing address</label>
            </div>

            <hr class="my-4">

            <h4 class="mb-3">Phương Thức Thanh Toán</h4>

            <div class="my-3">
                <div class="form-check">
                    <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
                    <label class="form-check-label" for="cod">Nhận hàng thanh toán!</label>
                </div>
                <div class="form-check">
                    <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
                    <label class="form-check-label" for="credit">Credit card</label>
                </div>
                <hr class="my-4">

                <button class="w-100 btn btn-primary btn-lg" onclick="thanhtoan();">Thanh toán</button>
        </form>
    </div>
</div>
<?php
require_once("./layouts/footer.php");
?>