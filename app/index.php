<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Contextus</title>
</head>
<body>
<div class="container">
    <div class="row">
        <?php if(isset($_SESSION['data']['error'])) { ?>
        <div class="col-md-12 text-center alert alert-danger mt-3" role="alert">
            <?php echo $_SESSION['data']['error'];?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php
        }
        if(isset($_SESSION['data']['message'])) { ?>
            <div class="col-md-12 text-center alert alert-success mt-3" role="alert">
                <?php echo $_SESSION['data']['message'];?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php }?>
        <div class="col-md-12 text-center my-3">
            <h1 class="tex">Shop</h1>
        </div>
        <div class=" col-md-12 mb-3">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Coordinates</h2>
                </div>
                <form action="routes.php?method=getBranches" method="POST">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="quantity" class="col-md-2 col-form-label">Quantity</label>
                            <div class="col-md-2">
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                            </div>
                            <label for="latitude" class="col-md-2 col-form-label">Latitude</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="latitude" name="lat" required>
                            </div>
                            <label for="longitude" class="col-md-2 col-form-label">Longitude</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="longitude" name="lon" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-center">
                            <button class="btn btn-info" type="submit">Calculate</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Checkout</h2>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-shopping-cart">
                        <thead class="text-muted">
                        <tr>
                            <th>Product</th>
                            <th>Branch</th>
                            <th>Distance</th>
                            <th>Stock</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(isset($_SESSION['data']['products'])) {
                                $products = $_SESSION['data']['products'];
                                $i=0;
                                foreach($products as $product) { ?>
                            <form action="routes.php?method=buy" method="POST">
                                <tr class="<?php echo !$i ?  'bg-info text-white' : ''; ?>">
                                    <input type="hidden" name="product" value='<?php echo json_encode(array_merge($product, $_SESSION['data']['request'])); ?>'>
                                    <td>
                                        <label class="form-label"><?php echo $product['product_name']; ?></label>
                                    </td>
                                    <td>
                                        <label class="form-label"><?php echo $product['branch_name']; ?></label>
                                    </td>
                                    <td>
                                        <label class="form-label"><?php echo $product['distance']; ?> km</label>
                                    </td>
                                    <td>
                                        <label class="form-label"><?php echo $product['stock']; ?></label>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-success">Buy</button>
                                    </td>
                                </tr>
                            </form>
                            <?php
                                    $i++;
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<?php unset($_SESSION['data']); ?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>