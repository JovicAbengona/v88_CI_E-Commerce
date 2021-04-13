
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url() ?>static/checkout.css">
    <title>PHP | E-Commerce</title>
</head>
<body>
    <header>
        <h1>Checkout</h1>
        <a href="<?= base_url() ?>cart">Back</a>
    </header>
    <section>
        <table>
            <thead>
                <tr>
                    <th>Quantity</th>
                    <th>Description</th>
                    <th rowspan=2>Price</th>
                </tr>
            </thead>
            <tbody>
<?php   if(count($result) > 0){
            $total = 0;
            foreach($result AS $product){
                $total += ($product["price"] * $product["quantity"]);
?>
                <tr>
                    <td><?= $product["quantity"] ?></td>
                    <td>Php <?= $product["name"] ?></td>
                    <td>Php <?= $product["price"] ?></td>
                </tr>
<?php       }
?>
                <tr>
                    <td colspan=2>Total</td>
                    <td>Php <?= $total ?></td>
                </tr>
<?php   }
        else{
?>
                <tr>
                    <td colspan="3">No Data Found</td>
                </tr>
<?php   }
        $this->session->set_userdata("checkout_cart_id", $product["cart_id"]);
        $this->session->set_userdata("checkout_total", $total);
?>
            </tbody>
        </table>
        <h3>Billing Info</h3>
        <form action="processCheckout/<?php $cart_data ?>" method="POST">
            <label>Name: <input type="text" name="name"></label>
<?php if($this->session->userdata("checkout_error_name") != NULL){ echo $this->session->userdata("checkout_error_name"); $this->session->unset_userdata("checkout_error_name");}?>
            <label>Address: <input type="text" name="address"></label>
<?php if($this->session->userdata("checkout_error_address") != NULL){ echo $this->session->userdata("checkout_error_address"); $this->session->unset_userdata("checkout_error_address");}?>
            <label>Credit Card: <input type="text" name="card" placeholder="xxxx-xxxx-xxxx-xxxx"></label>
<?php if($this->session->userdata("checkout_error_card") != NULL){ echo $this->session->userdata("checkout_error_card"); $this->session->unset_userdata("checkout_error_card");}?>
            <label>Valid Through: <input type="month" name="valid_through"></label>
<?php if($this->session->userdata("checkout_error_valid_through") != NULL){ echo $this->session->userdata("checkout_error_valid_through"); $this->session->unset_userdata("checkout_error_valid_through");}?>
            <label>CVC/CVV: <input type="text" name="cvc"></label>
<?php if($this->session->userdata("checkout_error_cvc") != NULL){ echo $this->session->userdata("checkout_error_cvc"); $this->session->unset_userdata("checkout_error_cvc");}?>
            <button type="submit">Order</button>
        </form>
</section>
</body>
</html>