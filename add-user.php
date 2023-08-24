<?php
include('includes/header.php');
?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h4>Add User
            <a href="index.php" class="btn btn-danger float-end">Back</a>
          </h4>
        </div>
        <div class="card-body">
        <form action="code.php" method="POST">

          <div class="form-group mb-3">
            <label for="account">Account</label>
            <input type="number" id="account" name="account" class="form-control">
          </div>
          <div class="form-group mb-3">
            <label for="balance">Balance</label>
            <input type="number" id="balance" name="balance" class="form-control">
          </div>
          <div class="form-group mb-3">
            <label for="user_id">User ID</label>
            <input type="text" id="user_id" name="user_id" class="form-control">
          </div>
          <div class="form-group mb-3">
            <label for="wallet_balance">Wallet Balance</label>
            <input type="number" id="wallet_balance" name="wallet_balance" class="form-control">
          </div>
          <div class="form-group mb-3">
           <button type="submit" name="save_user" class="btn btn-primary">Save User</button>
          </div>

        </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>