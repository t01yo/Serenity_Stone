<?php
include_once 'config/init.php';
if (!$auth->isLoggedIn()){

    header("Location: index.php");

}

if (isset($_POST['continue_checkout'])){

    $db = Database::getInstance();

    $user = $_POST['user'];
    $product = $_POST['checkout_products'];

    $product = explode(',', $product);

    foreach ($product as $p){
        $sql = "INSERT INTO checkout (`user_id`, `cart_id`, `message`) VALUES (:uid, :cart_id, 'Your package has been confirmed!')";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":uid", $user);
        $stmt->bindParam(":cart_id", $p);
        if ($stmt->execute()){

            $sql = "UPDATE cart SET status = '1' WHERE cart_id = :cart_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":cart_id", $p);
            if ($stmt->execute()) {
            }
        }
    }

    header("Location: delivery.php");
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Home | Serenity Stone</title>
    <link rel="apple-touch-icon" sizes="180x180" href="assets/icons/apple-touch-icon.jpg">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/icons/apple-touch-icon.jpg">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/icons/apple-touch-icon.jpg">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/my-style.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

</head>
<body>


<?php
include_once 'templates/navbar.php';
?>

<div class="container py-5">


    <div class="row">


        <div class="col-12 col-lg-12">
            <div class="container px-4 px-lg-5 mt-5">

                <div class="row">
                    <div class="col-md-4 order-md-2 mb-4">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Your cart</span>
                            <span class="badge badge-secondary badge-pill">3</span>
                        </h4>
                        <ul class="list-group mb-3">

                            <?php
                            if (isset($_POST['checkout'])) {

                                $cart =  implode(',', $_POST['product']);

                                $cart_obj = new Cart();
                                $cart = $cart_obj->checkout($cart);


                                $total_price1 = 0;
                                foreach ($cart as $res) {
                                    $total_price1 += $res['product_price'] * $res['quantity'];

                                    ?>
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0"><?php echo $res['product_name'] ?> (<?php echo $res['quantity'] ?>)</h6>
                                            <small class="text-muted"><?php echo $res['category_name'] ?></small>
                                        </div>
                                        <span class="text-muted">₱<?php echo number_format($res['product_price']) ?></span>
                                    </li>
                                    <?php

                                }
                            }?>

                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total (PHP)</span>
                                <strong>₱<?php echo number_format($total_price1) ?></strong>
                            </li>
                        </ul>

                        <div class="bg-dark p-4 p-md-5 text-white">
                            <h3 class="fs-3 fw-bold m-0 text-center">Order Summary</h3>
                            <div class="py-3 border-bottom-white-opacity">
                                <div class="d-flex justify-content-between align-items-center mb-2 flex-column flex-sm-row">
                                    <p class="m-0 fw-bolder fs-6">Subtotal</p>
                                    <p class="m-0 fs-6 fw-bolder">₱ <?php echo number_format($total_price1); ?></p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center flex-column flex-sm-row mt-3 m-sm-0">
                                    <p class="m-0 fw-bolder fs-6">Shipping</p>
                                    <span class="text-white opacity-75 small">Will be set at checkout</span>
                                </div>
                            </div>
                            <div class="py-3 border-bottom-white-opacity">
                                <div class="d-flex justify-content-between align-items-center flex-column flex-sm-row">
                                    <div>
                                        <p class="m-0 fs-5 fw-bold">Grand Total</p>
                                    </div>
                                    <p class="mt-3 m-sm-0 fs-5 fw-bold">₱ <?php echo number_format($total_price1); ?></p>
                                </div>
                            </div>

                            <!-- Coupon Code-->
                            <button class="btn btn-link p-0 mt-2 text-white fw-bolder text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Have a coupon code?
                            </button>
                            <div class="collapse" id="collapseExample">
                                <div class="card card-body bg-transparent p-0">
                                    <div class="input-group mb-0 mt-2">
                                        <input type="text" class="form-control border-0" placeholder="Enter coupon code">
                                        <button class="btn btn-white text-dark px-3 btn-sm border-0 d-flex justify-content-center align-items-center"><i class="ri-checkbox-circle-line ri-lg"></i></button>
                                    </div>
                                </div>
                            </div>
                            <!-- / Coupon Code-->

                            <form method="post" action="checkout.php">
                                <?php

                                if (isset($_POST['checkout'])) {
                                    ?>
                                    <input type="hidden" name="checkout_products" value="<?php echo implode(',', $_POST['product']);?>">
                                    <input type="hidden" name="user" value="<?php echo $user['id'] ?>">
                                    <button class="btn btn-outline-light w-100 text-center mt-3" name="continue_checkout" type="submit">Proceed to checkout</button>
                                    <?php
                                }
                                ?>
                            </form>

                        </div>
                    </div>
                    <div class="col-md-8 order-md-1">
                        <h4 class="mb-3">Billing address</h4>
                        <form class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName">First name</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="" value="<?php echo $user['firstname'] ?>" required>
                                    <div class="invalid-feedback">
                                        Valid first name is required.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName">Last name</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="" value="<?php echo $user['lastname'] ?>" required>
                                    <div class="invalid-feedback">
                                        Valid last name is required.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="username">Username</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@</span>
                                    </div>
                                    <input type="text" class="form-control" id="username" value="<?php echo $user['username'] ?>" placeholder="Username" required>
                                    <div class="invalid-feedback" style="width: 100%;">
                                        Your username is required.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email">Email <span class="text-muted">(Optional)</span></label>
                                <input type="email" class="form-control" id="email" placeholder="you@example.com">
                                <div class="invalid-feedback">
                                    Please enter a valid email address for shipping updates.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" placeholder="" value="<?php echo $user['address'] ?>" required>
                                <div class="invalid-feedback">
                                    Please enter your shipping address.
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label for="country">Country</label>
                                    <select class="custom-select d-block w-100" id="country" required>
                                        <option value="">Choose...</option>
                                        <option>Philippines</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a valid country.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="state">State</label>
                                    <select class="custom-select d-block w-100" id="state" required>
                                        <option value="">Choose...</option>
                                        <option>Tagudin</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please provide a valid state.
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="zip">Zip</label>
                                    <input type="text" class="form-control" id="zip" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Zip code required.
                                    </div>
                                </div>
                            </div>


                            <hr class="mb-4">

                            <h4 class="mb-3">Payment</h4>

                            <div class="d-block my-3">
                                <div class="custom-control custom-radio">
                                    <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked required>
                                    <label class="custom-control-label" for="card">Debit/Credit card</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required>
                                    <label class="custom-control-label" for="cod">Cash On Delivery</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cc-name">Name on card</label>
                                    <input type="text" class="form-control" id="cc-name" placeholder="" required>
                                    <small class="text-muted">Full name as displayed on card</small>
                                    <div class="invalid-feedback">
                                        Name on card is required
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cc-number">Credit card number</label>
                                    <input type="text" class="form-control" id="cc-number" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Credit card number is required
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="cc-expiration">Expiration</label>
                                    <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Expiration date required
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="cc-cvv">CVV</label>
                                    <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Security code required
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>


            </div>
        </div>



    </div>

</div>






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="assets/js/jquery.spinner.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="assets/js/notyf.settings.js"></script>
<script src="assets/js/cart.js"></script>
<script>
    function selectAll(source) {
        checkboxes = document.getElementsByName('product[]');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }
    }

    selectAll(this)

    $(function (){
        $(".update_cart_button").on('click', function(){
            let product_id = $(this).data("product_id");
            let quantity = $("#qnt_"+product_id).val();


            $.ajax({
                type: "POST",
                url: "config/Ajax.php",
                data: {
                    action: 'updateCart',
                    product_id: product_id,
                    quantity: quantity
                },
                success: function (data) {
                    if (data === "true"){
                        notyf.success("Cart updated successfully");
                        $("#quantity_"+ product_id).text(quantity);
                    } else {
                        notyf.error(data);
                    }
                }
            })

        });
    })


</script>
</body>
</html>

