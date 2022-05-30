<?php
$title = 'Mua hàng';
require_once("./layouts/header.php");
session_start();
require_once("dbcontroller.php");
$db = new DBController();
?>

<?php
$product_array = $db->runQuery("SELECT * FROM tblproduct ORDER BY id ASC");
if (!empty($product_array)) {
	foreach ($product_array as $key => $value) {
?>
		<div class="col-sm-6 col-lg-4">
			<div class="card card-show-item">
				<form method="post" action="cart.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
					<img src="<?php echo $product_array[$key]["image"]; ?>" class="card-img-top">
					<div class="card-body">
						<h5 class="card-title"><?php echo $product_array[$key]["name"]; ?></h5>
						<div class="row">
							<div class="col-md-6 col-xs-6">
								<span class="badge bg-success">Còn hàng</span>
							</div>
							<div class="col-md-6 col-xs-6 price">
								<h5>
								<label><?php echo number_format($product_array[$key]["price"])." VNĐ"; ?></label></h5>
							</div>
						</div>
						<label>Số lượng mua:</label>
						<input type="text" class="form-control" name="quantity" value="1" size="2" /><br>
						<button type="submit" value="Add to Cart" class="btn btn-primary">Đặt hàng</button>
					</div>
				</form>
			</div>
		</div>
<?php
	}
}
?>
</div>
<?php
require_once("./layouts/footer.php");
?>