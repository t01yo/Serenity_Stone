<?php
    include_once 'config/init.php';


if ($auth->isLoggedIn()){

    header("Location: index.php");

}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login | Serenity Shop</title>
    <link rel="apple-touch-icon" sizes="180x180" href="assets/icons/apple-touch-icon.jpg">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/icons/apple-touch-icon.jpg">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/icons/apple-touch-icon.jpg">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/icons/apple-touch-icon.jpg">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/icons/apple-touch-icon.jpg">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">    <link rel="stylesheet" href="assets/css/my-style.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/css/splide.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
</head>
<body>


<?php
    include_once 'templates/navbar.php';
?>

<div class="container ">
    <div class="row justify-content-sm-center my-5 py-5">
        <div class="col-md-6">
            <div class="text-center">
                <img src="serenity_logo.png" alt="logo" width="200">
            </div>
            <div class="text-center">
                <h1>Welcome to Serenity Stone Shop</h1>
                <p>“Jewelry is like the perfect spice -- it complements what's already there.” “Beauty is who you are. Jewelry is simply the icing on the cake.”</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <h1 class="fs-4 card-title fw-bold mb-4">Login</h1>
                    <form method="POST" id="loginForm">
                        <div class="mb-3">
                            <label class="mb-2 text-muted" for="username">Username</label>
                            <input id="username" type="text" class="form-control form-control-sm" name="username" value="" required autofocus>
                        </div>

                        <div class="mb-3">
                            <div class="mb-2 w-100">
                                <label class="text-muted" for="password">Password</label>
                            </div>
                            <input id="password" type="password" class="form-control form-control-sm" name="password" required>
                        </div>

                        <div class="d-flex align-items-center">
                            <button type="submit" id="login_btn" name="submit" class="btn btn-outline-success ms-auto">
                               &nbsp; <i class="fal fa-sign-in-alt"></i> Log In
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer py-3 border-0">
                    <div class="text-center">
                        Don't have an account? <a href="register.php">Create One</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="text-center mt-5 mb-1">Copyright &copy; 2023 &mdash; Serenity .</div>

</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/js/splide.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="assets/js/jquery.spinner.min.js"></script>
<script src="assets/js/sha256.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="assets/js/notyf.settings.js"></script>
<script src="assets/js/login.js"></script>
</body>
</html>

