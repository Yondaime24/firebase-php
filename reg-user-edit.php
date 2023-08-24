<?php
include('dbcon.php');
include('admin_auth.php');
include('includes/header.php');
?>

<div class="container">

<?php 

if(isset($_SESSION['status']))
{
  echo "<h5 class='alert alert-success'>".$_SESSION['status']."</h5>";
  unset($_SESSION['status']);
}

?>

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h4>Edit Registered User Data
            <a href="user-registered.php" class="btn btn-danger btn-sm float-end">Back</a>
          </h4>
        </div>
        <div class="card-body">
        <form action="code.php" method="POST">

        <?php

        if(isset($_GET['id'])) {
          try {
            $uid = $_GET['id'];
            $user = $auth->getUser($uid);
            ?>

            <input type="hidden" name="user_id" value="<?=$uid?>">
            <div class="form-group mb-3">
              <label for="display_name">Display Name</label>
              <input type="text" id="display_name" name="display_name" value="<?=$user->displayName?>" class="form-control">
            </div>
            <div class="form-group mb-3">
              <label for="phone">Phone Number</label>
              <input type="text" id="phone" name="phone" value="<?=$user->phoneNumber?>" class="form-control">
            </div>
            <div class="form-group mb-3">
            <button type="submit" name="update_reg_btn" class="btn btn-primary">Update</button>
            </div>

            <?php
          } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
              echo $e->getMessage();
          }
        }

        ?>

        </form>
        </div>
      </div>
    </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h4>Enable or Disable User Account</h4>
            </div>
            <div class="card-body">
              <form action="code.php" method="POST">
              <?php
              if(isset($_GET['id'])){
                $uid = $_GET['id'];

                try {
                  $user = $auth->getUser($uid);
                ?>

              <input type="hidden" name="user_id" value="<?=$uid?>">
              <div class="input-group mb-3">
                <select name="select_enable_disable" class="form-control" required>
                  <option value="">Select</option>
                  <option value="disable">Disable</option>
                  <option value="enable">Enable</option>
                </select>
                <button type="submit" name="enable_disable_user_ac" class="input-group-text btn btn-primary">Submit</button>
              </div>

              <?php
                  } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
                      echo $e->getMessage();
                  }

                  }else{
                    echo "No User ID Found";
                  }
                ?>

              </form>
            </div>
          </div>
        </div>


        <div class="col-md-12">
          <hr>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h4>Change Password</h4>
            </div>
            <div class="card-body">
              <form action="code.php" method="POST">
              <?php
                
                if(isset($_GET['id'])){
                  $uid = $_GET['id'];

                  try {
                    $user = $auth->getUser($uid);

              ?>

                    <input type="hidden" name="change_pwd_user_id" value="<?=$uid?>">
                    <div class="form-group mb-3">
                      <label for="">New Password</label>
                      <input type="text" name="new_password" required class="form-control">
                    </div>
                    <div class="form-group mb-3">
                      <label for="">Retype Password</label>
                      <input type="text" name="retype_password" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                      <button type="submit" name="change_password_btn" required class="btn btn-primary">Submit</button>
                    </div>

                <?php

                  } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
                      echo $e->getMessage();
                  }

                }else{
                  echo "No ID Found";
                }
                
                ?>
              </form>
            </div>
          </div>
        </div>


        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h4>Custom User Claims</h4>
            </div>
            <div class="card-body">
              <form action="code.php" method="POST">

              <?php
                
                if(isset($_GET['id'])){
                  $uid = $_GET['id'];

                  try {
                    $user = $auth->getUser($uid);

              ?>

                <input type="hidden" name="claims_user_id" value="<?=$uid?>">
                <div class="form-group mb-3">
                  <select name="role_as" class="form-control" required>
                    <option value="">Select Roles</option>
                    <option value="admin">Admin</option>
                    <option value="super_admin">Super Admin</option>
                    <option value="norole">Remove Role</option>
                  </select>
                </div>

                    <label for="">Currently: user role is </label>
                    <h4 class="border bg-warning p-2">
                    <?php
                    
                    $claims = $auth->getUser($user->uid)->customClaims;
                    if(isset($claims['admin']) == true) {
                      echo "ADMIN";
                    }elseif(isset($claims['super_admin']) == true) {
                      echo "SUPER ADMIN";
                    }elseif($claims == null) {
                      echo "NO ROLE";
                    }

                    ?>
                    </h4>


                <div class="form-group mb-3">
                  <button type="submit" name="user_claims_btn" class="btn btn-primary">Submit</button>
                </div>

              <?php

                } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
                    echo $e->getMessage();
                }

                }else{
                echo "No ID Found";
                }
              
              ?>
              </form>
            </div>
          </div>
        </div>

  </div>
</div>

<?php include('includes/footer.php'); ?>