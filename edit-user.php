<?php
session_start();
include('includes/header.php');
?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h4>Edit & Update User
            <a href="index.php" class="btn btn-danger float-end">Back</a>
          </h4>
        </div>
        <div class="card-body">
        <?php
          include('dbcon.php');

          if(isset($_GET['id'])){
            $key_child = $_GET['id'];
            $ref_table = 'accounts';
            $getdata = $database->getReference($ref_table)->getChild($key_child)->getValue();

            if($getdata > 0) {

        ?>

              <form action="code.php" method="POST">
                <input type="hidden" name="key" value="<?=$key_child?>">
                <div class="form-group mb-3">
                  <label for="account">Account</label>
                  <input type="number" id="account" name="account" value="<?=$getdata['account']?>" class="form-control">
                </div>
                <div class="form-group mb-3">
                  <label for="balance">Balance</label>
                  <input type="number" id="balance" name="balance" value="<?=$getdata['balance']?>" class="form-control">
                </div>
                <div class="form-group mb-3">
                  <label for="user_id">User ID</label>
                  <input type="text" id="user_id" name="user_id" value="<?=$getdata['user_id']?>" class="form-control">
                </div>
                <div class="form-group mb-3">
                  <label for="wallet_balance">Wallet Balance</label>
                  <input type="number" id="wallet_balance" name="wallet_balance" value="<?=$getdata['wallet_balance']?>" class="form-control">
                </div>
                <div class="form-group mb-3">
                <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
                </div>
              </form>

        <?php

          }else{
            $_SESSION['status'] = "Invalid ID!";
            header('Location: index.php');
            exit();
          }
          }else{
          $_SESSION['status'] = "Data Not Found!";
          header('Location: index.php');
          exit();
          }
        ?>

        </div>
      </div>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>