<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url() ?>static/index.css">
    <title>PHP | Products</title>
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
                        <form action="buy/<?= $product["id"] ?>" method="POST">
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
<?php if($this->session->userdata("error") != NULL){ echo $this->session->userdata("error"); $this->session->unset_userdata("error");}?>
    </section>
</body>
</html>