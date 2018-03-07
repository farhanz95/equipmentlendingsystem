<?php 

if (!empty($_POST)) {

require_once('opendb.php');

$password = $_POST['passwordLogin'];
$passwordhash = hash('md5', $password);

$sql= "SELECT * FROM user WHERE email = :email && password = :password "; 
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $_POST['email'] , PDO::PARAM_INT); 
$stmt->bindParam(':password', $passwordhash , PDO::PARAM_STR); 
$stmt->execute();

$row = $stmt->fetch();

  if($stmt->execute() == true)
  {
        if($stmt->rowCount() > 0)
        {     
              // If Admin
              if ($row['role'] == 1) {
                // If Account Not Active
                if (!$row['active']) {
                  echo "<script>
                alert('This Account Is Inactive');
                window.location.href='index.php';
                </script>";die;
                }

              }

              $_SESSION['id'] = $row['user_id'];
              $_SESSION['fullname'] = $row['fullname'];
              $_SESSION['loggedin'] = true;
              $_SESSION['role'] = $row['role'];

              if ($row['role'] == 1) {
                $_SESSION['isAdmin'] = true;
              }

              // UPDATE user last logged in date

              $current_datetime = date('Y-m-d H:i:s');

              $sql = "UPDATE user SET last_logged_in = :last_logged_in
                      WHERE user_id = :user_id";
              $stmt = $conn->prepare($sql);                             
              $stmt->bindParam(':user_id', $row['user_id'], PDO::PARAM_STR); 
              $stmt->bindParam(':last_logged_in', $current_datetime , PDO::PARAM_STR);
              $stmt->execute(); 
                                               
              if($stmt->execute() == true){
              }else{ 
                echo $stmt->errorCode(); 
              }

              // END UPDATE user last logged in date


              echo "<script>
              window.location.href='index.php';
              </script>";
        }
        else
        {
              echo "<script>
              alert('Incorrect username or password');
              </script>";
        }
  }

  else
  {
        echo $stmt->errorCode();
  }

}else{


}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="" method="post" id="loginForm">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" name="email" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="passwordLogin" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <a href="#">I forgot my password</a><br>
    <a href="register.php" class="text-center">Register a new membership</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script src="js/jquery-3.3.1.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.17.0/jquery.validate.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.17.0/additional-methods.min.js"></script>

<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="validation.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>

<!-- jQuery 3 -->
<!-- <script src="bower_components/jquery/dist/jquery.min.js"></script> -->
<!-- Bootstrap 3.3.7 -->
<!-- <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
