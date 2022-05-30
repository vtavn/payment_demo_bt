<?php
$title = 'Giỏ Hàng';
require_once("./layouts/header.php");
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            if (!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
                $itemArray = array($productByCode[0]["code"] => array('name' => $productByCode[0]["name"], 
                                'code' => $productByCode[0]["code"], 
                                'quantity' => $_POST["quantity"], 
                                'price' => $productByCode[0]["price"], 'image' => $productByCode[0]["image"]));

                if (!empty($_SESSION["cart_item"])) {
                    if (in_array($productByCode[0]["code"], array_keys($_SESSION["cart_item"]))) {
                        foreach ($_SESSION["cart_item"] as $k => $v) {
                            if ($productByCode[0]["code"] == $k) {
                                if (empty($_SESSION["cart_item"][$k]["quantity"])) {
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
            break;
        case "remove":
            if (!empty($_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $k => $v) {
                    if ($_GET["code"] == $k)
                        unset($_SESSION["cart_item"][$k]);
                    if (empty($_SESSION["cart_item"]))
                        unset($_SESSION["cart_item"]);
                }
            }
            break;
        case "empty":
            unset($_SESSION["cart_item"]);
            break;
    }
}
?>
<div id="shopping-cart">
    <?php
    if (isset($_SESSION["cart_item"])) {
        $total_quantity = 0;
        $total_price = 0;
    ?>
        <a href="cart.php?action=empty" type="button" class="btn btn-primary btn-sm btn-block">
									<span class="glyphicon glyphicon-share-alt"></span> Xoá giỏ hàng
    </a>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th class="text-center">Đơn giá</th>
                    <th class="text-center">Thanh toán</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($_SESSION["cart_item"] as $item) {
                    $item_price = $item["quantity"] * $item["price"];
                ?>
                    <tr>
                        <td class="col-sm-8 col-md-6">
                            <div class="media">
                                <a class="thumbnail pull-left" href="#"> <img class="media-object" src="<?php echo $item["image"]; ?>" style="width: 72px; height: 72px;"> </a>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo $item["name"]; ?></h4>
                                </div>
                            </div>
                        </td>
                        <td class="col-sm-1 col-md-1" style="text-align: center">
                            <input type="email" class="form-control" id="exampleInputEmail1" value="<?php echo $item["quantity"]; ?>">
                        </td>
                        <td class="col-sm-1 col-md-1 text-center"><strong><?php echo number_format($item["price"]) . " VNĐ"; ?></strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong><?php echo number_format($item_price) . " VNĐ"; ?></strong></td>
                        <td class="col-sm-1 col-md-1">
                            <a type="button" href="cart.php?action=remove&code=<?php echo $item["code"]; ?>" class="btn btn-danger">
                                Xoá </a>
                        </td>
                    </tr>
                <?php
                    $total_quantity += $item["quantity"];
                    $total_price += ($item["price"] * $item["quantity"]);
                }
                ?>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>
                        <h5>Thanh toán</h5>
                    </td>
                    <td class="text-right">
                        <h5><strong><?php echo number_format($total_price) . " VNĐ"; ?></strong></h5>
                    </td>
                    <td>   </td>

                </tr>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td> </td>
                    <td>   </td>

                    <td>
                        <a type="button" href="payment.php" class="btn btn-success">
                            Thanh toán <span class="glyphicon glyphicon-play"></span>
                        </a>
                    </td>

                </tr>
            </tbody>
        </table>
</div>
<?php
    } else {
?>
    <div class="no-records">Giỏ hàng rỗng</div>
<?php
    }
?>
<?php
require_once("./layouts/footer.php");
?>