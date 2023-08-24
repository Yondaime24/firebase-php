<?php
session_start();

if(array_key_exists('verified_user_id',$_SESSION) && !empty($_SESSION['verified_user_id'])) {
  $_SESSION['status'] = 'You are already Logged in!';
  header('Location: home.php');
  exit();
} 

include('includes/header.php');
?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">

    <?php 

      if(isset($_SESSION['status']))
      {
        echo "<h5 class='alert alert-success'>".$_SESSION['status']."</h5>";
        unset($_SESSION['status']);
      }

    ?>

      <div class="card">
        <div class="card-header">
          <h4>Register
          </h4>
        </div>
        <div class="card-body">
        <form action="code.php" method="POST">

          <div class="form-group mb-3">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" class="form-control">
          </div>
          <div class="form-group mb-3">
            <label for="phone">Phone Number</label>
            <input type="number" id="phone" name="phone" class="form-control">
          </div>
          <div class="form-group mb-3">
            <label for="email">Email Adress</label>
            <input type="email" id="email" name="email" class="form-control">
          </div>
          <div class="form-group mb-3">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control">
          </div>
          <div class="form-group mb-3">
           <button type="submit" name="register_btn" class="btn btn-primary">Register</button>
          </div>

        </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>