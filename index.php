<?php
include('dbcon.php');
include('authentication.php');
include('includes/header.php');
?>

<div class="container">
  <div class="row">

  <div class="col-md-6 mb-3">
    <div class="card">
      <div class="card-body">
        <h4>Total No. of Record:
        <?php

          $ref_table = 'accounts';
          $total_count = $database->getReference($ref_table)->getSnapshot()->numChildren();
          echo $total_count;

        ?>
        </h4>
      </div>
    </div>
  </div>

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
          <h4>FCBPAY ADMIN
            <a href="add-user.php" class="btn btn-primary float-end">Add User</a>
          </h4>
        </div>
        <div class="card-body">

        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Account ID</th>
              <th>Balance</th>
              <th>User ID</th>
              <th>Wallet Balance</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $ref_table = 'accounts';
            $fetch_data = $database->getReference($ref_table)->getValue();

            if($fetch_data > 0) { 
              $i = 1;
              foreach($fetch_data as $key => $row ) {
                ?>
                  <tr>
                    <td><?=$i++?></td>
                    <td><?=$row['account']?></td>
                    <td><?=$row['balance']?></td>
                    <td><?=$row['user_id']?></td>
                    <td><?=$row['wallet_balance']?></td>
                    <td>
                      <div class="row p-2">
                        <a href="edit-user.php?id=<?=$key?>" class="btn btn-primary btn-sm mb-2">Edit</a>
                        <!-- <a href="delete-user.php?id=<?=$key?>" class="btn btn-danger btn-sm">Delete</a> -->
                        <form action="code.php" method="POST" class="p-0">
                          <button style="width:100%;" type="submit" name="delete_btn" value="<?=$key?>" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php
              }
            }else{
              ?>
                <tr>
                  <td colspan="6">No Record Found</td>
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