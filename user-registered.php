<?php
include('dbcon.php');
include('admin_auth.php');
include('includes/header.php');
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">

    <?php 

      if(isset($_SESSION['status']))
      {
        echo "<h5 class='alert alert-success'>".$_SESSION['status']."</h5>";
        unset($_SESSION['status']);
      }
    
    ?>

      <div class="card">
        <div class="card-header">
          <h4>Registered User List</h4>
        </div>
        <div class="card-body">

        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Full Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Status</th>
              <th>Role</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
 
            <?php
              $i = 1;
              $users = $auth->listUsers();
              
              foreach ($users as $user) {
            ?>

                <tr>
                  <td><?=$i++?></td>
                  <td><?=$user->displayName?></td>
                  <td><?=$user->phoneNumber?></td>
                  <td><?=$user->email?></td>
                  <td>

                    <?php
                        
                        if ($user->disabled) {
                          echo "Disabled";
                        } else {
                          echo "Enabled";
                        }
                        
                    ?>

                  </td>
                  <td>
                  <span class="border bg-warning p-2">
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
                  </span>
                  </td>
                  <td>
                      <div class="row p-2">
                        <a href="reg-user-edit.php?id=<?=$user->uid?>" class="btn btn-primary btn-sm mb-2">Edit</a>
                        <form action="code.php" method="POST" class="p-0">
                          <button style="width:100%;" type="submit" name="delete_reg_btn" value="<?=$user->uid?>" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                      </div>
                    </td>
                </tr>

            <?php
              }

            ?>
            
          </tbody>
        </table>

        </div>
      </div>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>