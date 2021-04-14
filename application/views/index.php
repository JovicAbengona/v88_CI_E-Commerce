<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url() ?>static/index.css">
    <title>PHP | E-Commerce</title>
</head>
<body>
    <header>
        <h1>Products</h1>
        <a href="cart">Your Cart (<?= $cart["cartQuantity"] ?>)</a>
    </header>
    <section>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
<?php   if(count($products["result"]) > 0){
            foreach($products["result"] AS $product){
?>
                <tr>
                    <td><?= $product["name"] ?></td>
                    <td>Php <?= $product["price"] ?></td>
                    <td>
<?php   $attributes = array("role" => "form");
        echo form_open("buy/".$product["id"], $attributes);
?>
                        <!-- <form action="buy/" method="POST"> -->
                            <input type="number" name="quantity" min="1" value="1">
                            <button type="submit">Buy</button>
                        </form>
                    </td>
                </tr>
<?php       }
        }
        else{
?>
                <tr>
                    <td colspan="3">No Data Found</td>
                </tr>
<?php   }
?>
            </tbody>
        </table>
<?php if($this->session->userdata("error") != NULL){ echo "<p class='error'>".$this->session->userdata("error")."</p"; $this->session->unset_userdata("error");}?>
<?php if($this->session->userdata("buy_success") != NULL){ echo "<p class='success'>".$this->session->userdata("buy_success")."</p"; $this->session->unset_userdata("buy_success");}?>
<?php if($this->session->userdata("checkout_success") != NULL){ echo "<p class='success'>".$this->session->userdata("checkout_success")."</p"; $this->session->unset_userdata("checkout_success");}?>
    </section>
</body>
</html>