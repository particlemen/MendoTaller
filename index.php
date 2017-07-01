<?php
mysql_query("mysql -u ".DBUSER." -p ".DBPASS." ")
 // this will avoid mysql_connect() deprecation error.
 error_reporting( ~E_DEPRECATED & ~E_NOTICE );
 // but I strongly suggest you to use PDO or MySQLi.

 define('DBHOST', 'localhost');
 define('DBUSER', 'root');
 define('DBPASS', 'localhost');

 $conn = mysql_connect(DBHOST,DBUSER,DBPASS);
 $dbcon = mysql_select_db('dbtest');

 if ( !$conn ) {
  die("Connection failed : " . mysql_error());
 }

 if ( !$dbcon ) {
  die("Database Connection failed : " . mysql_error());
 }

?>



<?php
 ob_start();
 session_start();


 // it will never let you open index(login) page if session is set
 // Mendoza es el mejor profe de la usm desde Marti C:C:C: Auxilio me tiene un cuchillo puesto en la garganta.
 if ( isset($_SESSION['user'])!="" ) {
  header("Location: home.php");
  exit;
 }

 $error = false;

 if( isset($_POST['btn-login']) ) {

  // prevent sql injections/ clear user invalid inputs
  $rol = trim($_POST['rol']);
  $rol = strip_tags($rol);
  $rol = htmlspecialchars($rol);

  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  // prevent sql injections / clear user invalid inputs

  if(empty($rol)){
   $error = true;
   $rolError = "Por favor ingresa tu rol";
  }
  if(empty($pass)){
   $error = true;
   $passError = "Ingresa una contraseña valida";
  }

  // if there's no error, continue to login
  if (!$error) {

   $password = hash('sha256', $pass); // password hashing using SHA256

   $res=mysql_query("SELECT id_usuario, nombre_usuario, contraseña FROM usuarios WHERE id_usuario='$rol'");
   $row=mysql_fetch_array($res);
   $count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row

   if( $count == 1 && $row['contraseña']==$password ) {
    $_SESSION['user'] = $row['id_usuario'];
    header("Location: home.php");
   } else {
    $errMSG = "Valores erroneos, intentalo de nuevo";
   }

  }

 }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portal Talleres USM</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div class="container">

 <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

     <div class="col-md-12">

         <div class="form-group">
             <h2 class="">Ingresa aqui!</h2>
            </div>

         <div class="form-group">
             <hr />
            </div>

            <?php
   if ( isset($errMSG) ) {

    ?>
    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>

   <div class="form-group">
    <div class="input-group">
       <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
    <input type="text" name="rol" class="form-control" placeholder="xxxxxxxx" value="<?php echo $rol; ?>" maxlength="40" />
       </div>
       <span class="text-danger"><?php echo $rolError; ?></span>
   </div>

            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="contraseña" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>

            <div class="form-group">
             <hr />
            </div>

            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-login">Ingresar</button>
            </div>

            <div class="form-group">
             <hr />
            </div>

            <div class="form-group">
             <a href="register.php">No eres usuario? registrate aqui!</a>
            </div>

        </div>

    </form>
    </div>

</div>

</body>
</html>
<?php ob_end_flush(); ?>
