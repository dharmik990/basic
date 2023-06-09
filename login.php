<?php
include('config/dbconnection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <style>
        .one {
            display: flex;
            justify-content: center;
        }

        ._contain {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row one">
            <div class="col-lg-6 _contain">
                <h2 class="p-1 text-center mt-2">login form</h2>
                <form method="post" class="p-3">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                        <a href="resetpassword.php" class="float-end">forgetpassword</a>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Login</button>
                    <span class="px-2">create new account</span><a href="form.php" class="px-1">Register</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>