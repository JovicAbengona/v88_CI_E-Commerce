<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url() ?>static/cart.css">
    <title>PHP | Students</title>
</head>
<body>
    <header>
        <h1>Your Cart</h1>
        <a href="<?= base_url() ?>">Back</a>
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
                    <td>
                        <form action="delete/<?= $product["id"] ?>" method="POST">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
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
?>
            </tbody>
        </table>
        
    </section>
</body>
</html>