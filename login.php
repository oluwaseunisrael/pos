<?php 
session_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <h1 class="text-center fs-2">Point Of Sale System</h1>
 

</div>
    <div class="row justify-content-md-center align-middle" style="display: flex; justify-content: center; align-items: center; margin: 0 6%;">
      <div class="col-md-6">
        <img src="img/login.jpg" style="width:100%">
      </div>
      <div class="col-md-6" >
<?php
  if (isset($_SESSION['status'])) {
?>
 <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <?= $_SESSION['status']?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
  }

  unset($_SESSION['status']);
?>

        <form class="form" action="login-codes.php" method="POST">
          <label class="form-label">Email</label>
          <div class="mb-3">
            <input type="email" name="email" class="form-control">
            
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="psw"name="password" class="form-control">
          </div>
           <div class="mb-3">
            <input type="submit" name="submit" class="btn btn-primary btn-sm">
          </div>
         
        </form>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>