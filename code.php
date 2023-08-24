<?php
session_start();
include('dbcon.php');

if(isset($_POST['save_user'])) {

  $account = $_POST['account'];
  $balance = $_POST['balance'];
  $user_id = $_POST['user_id'];
  $wallet_balance = $_POST['wallet_balance'];

  $postData = [
    'account' => $account, 
    'balance' => $balance, 
    'user_id' => $user_id, 
    'wallet_balance' => $wallet_balance
  ];

  $ref_table = 'accounts/'.$account;
  $postRef = $database->getReference($ref_table)->set($postData);

  if($postRef) {
    $_SESSION['status'] = 'User Added Successfully!';
    header('Location: index.php');
  }else{
    $_SESSION['status'] = 'User  Not Added Successfully!';
    header('Location: index.php');
  }

}

if(isset($_POST['update_user'])) {

  $key = $_POST['key'];
  $account = $_POST['account'];
  $balance = $_POST['balance'];
  $user_id = $_POST['user_id'];
  $wallet_balance = $_POST['wallet_balance'];

  $updateData = [
    'account' => $account, 
    'balance' => $balance, 
    'user_id' => $user_id, 
    'wallet_balance' => $wallet_balance
  ];

  $ref_table = 'accounts/'.$key;
  $updatequery = $database->getReference($ref_table)->update($updateData);

  if($updatequery) {
    $_SESSION['status'] = 'User Updated Successfully!';
    header('Location: index.php');
  }else{
    $_SESSION['status'] = 'User  Not Updated Successfully!';
    header('Location: index.php');
  }

}

if(isset($_POST['delete_btn'])) {

  $del_btn = $_POST['delete_btn'];

  $ref_table = 'accounts/'.$del_btn;
  $deleteQuery = $database->getReference($ref_table)->remove();

  if($deleteQuery) {
    $_SESSION['status'] = 'User Deleted Successfully!';
    header('Location: index.php');
  }else{
    $_SESSION['status'] = 'User  Not Deleted Successfully!';
    header('Location: index.php');
  }

}

if(isset($_POST['register_btn'])) {

  $full_name = $_POST['full_name'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $userProperties = [
    'email' => $email,
    'emailVerified' => false,
    'phoneNumber' => '+63'.$phone,
    'password' => $password,
    'displayName' => $full_name,
    'disabled' => false,
];

$createdUser = $auth->createUser($userProperties);

if($createdUser) {
  $_SESSION['status'] = 'User Created/Registered Successfully!';
  header('Location: register.php');
  exit();
}else{
  $_SESSION['status'] = 'User  Not Created/Registered Successfully!';
  header('Location: register.php');
  exit();
}

}

if(isset($_POST['update_reg_btn'])) {

  $uid = $_POST['user_id'];
  $display_name = $_POST['display_name'];
  $phone = $_POST['phone'];

  $properties = [
      'displayName' => $display_name,
      'phoneNumber' => $phone
  ];

  $updatedUser = $auth->updateUser($uid, $properties);

  if($updatedUser) {
    $_SESSION['status'] = 'User Updated Successfully!';
    header('Location: user-registered.php');
    exit();
  }else{
    $_SESSION['status'] = 'User  Not Updated Successfully!';
    header('Location: user-registered.php');
    exit();
  }

}

if(isset($_POST['delete_reg_btn'])) {

  $uid = $_POST['delete_reg_btn'];

  try {
    $auth->deleteUser($uid);

    $_SESSION['status'] = 'Registered User Deleted Successfully!';
    header('Location: user-registered.php');
    exit();

  } catch (Exception $e) {
    $_SESSION['status'] = 'No ID Found!';
    header('Location: user-registered.php');
    exit();
  }

}

if(isset($_POST['enable_disable_user_ac'])) {

  $enable_disable = $_POST['select_enable_disable'];
  $uid = $_POST['user_id'];

  if ($enable_disable == "disable") {
    $updatedUser = $auth->disableUser($uid);
    $msg = 'Account Disabled';
  } else {
    $updatedUser = $auth->enableUser($uid);
    $msg = 'Account Enabled';
  }

  if($updatedUser) {
    $_SESSION['status'] = $msg;
    header('Location: user-registered.php');
    exit();
  }else{
    $_SESSION['status'] = 'Something Went Wrong!';
    header('Location: user-registered.php');
    exit();
  }
  

}

if(isset($_POST['change_password_btn'])) {

  $new_password = $_POST['new_password'];
  $retype_password = $_POST['retype_password'];
  $uid = $_POST['change_pwd_user_id'];

  if($new_password == $retype_password) {
    $updatedUser = $auth->changeUserPassword($uid, $new_password);

    if($updatedUser) {
      $_SESSION['status'] = "Password Successfully Changed!";
      header('Location: user-registered.php');
      exit();
    }else{
      $_SESSION['status'] = 'Password Not Updated!';
      header('Location: user-registered.php');
      exit();
    }

  }else{
    $_SESSION['status'] = 'Password Does Not Match!';
    header('Location: reg-user-edit.php?id='.$uid);
    exit();
  }

}

if(isset($_POST['user_claims_btn'])) {

  $uid = $_POST['claims_user_id'];
  $roles = $_POST['role_as'];

  if($roles == 'admin') {

    $auth->setCustomUserClaims($uid, ['admin' => true]);
    $msg = "User Role as ADMIN";

  }elseif($roles == 'super_admin') {

    $auth->setCustomUserClaims($uid, ['super_admin' => true]);
    $msg = "User Role as SUPER ADMIN";

  }elseif($roles == 'norole'){

    $auth->setCustomUserClaims($uid, null);
    $msg = "User Role Removed";

  }

  if($msg) {
    $_SESSION['status'] = "$msg";
    header('Location: reg-user-edit.php?id='.$uid);
    exit();
  }else{
    $_SESSION['status'] = 'Password Not Updated!';
    header('Location: reg-user-edit.php?id='.$uid);
    exit();
  }

}

if(isset($_POST['update_user_profile'])) {

  $display_name = $_POST['display_name'];
  $phone = $_POST['phone'];
  $profile = $_FILES['profile']['name'];

  $random_no = rand(1111,9999);
  $uid = $_SESSION['verified_user_id'];
  $user = $auth->getUser($uid);

  $new_image = $random_no.$profile;
  $old_image = $user->photoUrl;

  if ($profile != null) {
    $filename = 'uploads/'.$new_image;
  } else {
    $filename = $old_image;
  }

  $properties = [
      'displayName' => $display_name,
      'phoneNumber' => $phone,
      'photoUrl' => $filename,
  ];

  $updatedUser = $auth->updateUser($uid, $properties);

    if($updatedUser) {

      if ($profile != null) {
        move_uploaded_file($_FILES['profile']['tmp_name'], 'uploads/'.$new_image);
        if($old_image != NULL) {
          unlink($old_image);
        }
      } 

      $_SESSION['status'] = 'Updated Successfully';
      header('Location: my-profile.php');
      exit(0);
    }else{
      $_SESSION['status'] = 'Update Error!';
      header('Location: my-profile.php');
      exit(0);
    }

}

?>