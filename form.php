<?php
 include('config/dbconnection.php');

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm = $_POST['confirm'];
  $token = md5(rand());

  if ((isset($name) && empty($name)) || (isset($email) && empty($email)) || (isset($password) && empty($password)) || (isset($confirm) && empty($confirm))) {

    if (empty($name)) {
      $name_err = "name is required";
    }
    if (empty($email)) {
      $email_err = "email is required";
    }
    if (empty($password)) {
      $password_err = "password is required";
    }
    if (empty($confirm)) {
      $confirm_err = "confirm is required";
    }

  } elseif (!empty($name) && !empty($email) && !empty($password) && !empty($confirm)) {

    // $split=explode('.',$email);
    // $length=);
    if (strlen($password) < 8) {
      $length_err = "password is more than 8 characters";
    } elseif ($password != $confirm) {
      $match_err = "password does not match";
    } else {
      $select = mysqli_query($con, "SELECT * FROM user WHERE `email`='$email'");
      $fetch = mysqli_num_rows($select);
      if ($fetch > 0) {
        $email_err = "user exist";
      } else {
        $insert = "INSERT INTO user(`name`,`email`,`password`,`token`)VALUES('$name','$email','$password','$token')";
        $insert_exe = mysqli_query($con, $insert);

        if ($insert_exe) {
          $success = "data insert successfully";
          header('location:table.php');
        } else {
          $error = "something went wrong";
        }

      }
    }

  }
}
if (isset($_GET['update_id'])) {
  $update_id = base64_decode($_GET['update_id']);
  $select = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM user WHERE `id`='$update_id'"));
}
if (isset($_POST['update'])) {

  echo $uid = base64_decode($_GET['update_id']);
  $name = $_POST['name'] ? $_POST['name'] : $select['name'];

  $update = "UPDATE user SET `name`='$name' WHERE `id`='$uid'";
  $update_exe = mysqli_query($con, $update);

  if ($update_exe) {
    header('location:table.php');
  } else {
    $error = "something went wronge";
  }
} else {
  echo " update is not exe";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
  
  
  <style>
  
  </style>
</head>
</head>

<body>
  <h1 class="d-flex justify-content-center"> Register.php</h1>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div>
          <?php if (isset($success)) { ?>
            <div class="alert alert-success">
              <?php echo $success; ?>
            </div>
          <?php } ?>
        </div>
        <div>
          <?php if (isset($error)) { ?>
            <div class="alert alert-danger">
              <?php echo $error; ?>
            </div>
          <?php } ?>
        </div>

        <form method="post">
          <div class="mb-3">
            <label for="name" class="form-label">name</label>
            <input type="text" class="form-control" name="name" value="<?php if (isset($_POST['name'])) {
              echo $_POST['name'];
            } elseif (isset($select['name'])) {
              echo $select['name'];
            } ?>" id="name" placeholder="enter your name">
          </div>
          <div class="text-danger">
            <?php if (isset($name_err)) { ?>
              <?php echo $name_err;
            } ?>
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" value="<?php if (isset($email)) {
              echo $email;
            } elseif (isset($select['email'])) {
              echo $select['email'];
            } ?>" id="exampleInputEmail1" aria-describedby="emailHelp">
          </div>
          <div class="text-danger">
            <?php if (isset($email_err)) { ?>
              <?php echo $email_err;
            } ?>
          </div>
          <?php if (!isset($_GET['update_id'])) { ?>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" id="exampleInputPassword1">
            </div>
            <div class="text-danger">
              <?php if (isset($password_err)) { ?>
                <?php echo $password_err;
              } ?>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">confirm_Password</label>
              <input type="password" class="form-control" name="confirm" id="exampleInputPassword1">
            </div>
            <div class="text-danger">
              <?php if (isset($confirm_err)) { ?>
                <?php echo $confirm_err;
              } ?>
            </div>
          <?php } ?>
          <?php if (isset($_GET['update_id'])) { ?>
            <button type="submit" name="update" class="btn btn-primary">update</button>
          <?php } else { ?>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
          <?php } ?>
        </form>
      </div>
    </div>
  </div>
  <script>    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }</script>
</body>

</html>