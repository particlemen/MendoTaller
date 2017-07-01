

<?php
 ob_start();
 session_start();
 if( isset($_SESSION['user'])!="" ){
  header("Location: home.php");
 }
 include_once 'dbconnect.php';

 $error = false;

 if ( isset($_POST['btn-signup']) ) {

  // clean user inputs to prevent sql injections
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);

  $rol = trim($_POST['rol']);
  $rol = strip_tags($rol);
  $rol = htmlspecialchars($rol);

  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);

  // basic name validation
  if (empty($name)) {
   $error = true;
   $nameError = "Ingresa tu nombre de usuario.";

  } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
   $error = true;
   $nameError = "Caracteres raros en tu nombre, revisalos";
  }
   else {
   $query = "SELECT id_estudiante FROM usuarios WHERE nombre_usuario ='$name'";
   $result = mysql_query($query);
   $count = 0;
   try {
   $count = mysql_num_rows($result);
  }catch (Exception $e) {
  }


   if($count!=0){
    $error = true;
    $rolError = "nombre de usuario dado ya esta en uso";
	 }
   }


   // check rol exist or not
   $query = "SELECT id_estudiante FROM usuarios WHERE id_estudiante ='$rol'";
   $result = mysql_query($query);
   $count = 0;
   try {
   $count = mysql_num_rows($result);
 } catch(Exception $e){}
   if($count!=0){
    $error = true;
    $rolError = "rol dado ya esta en uso";
	}

    if(strlen((string)$rol) != 9){
      $error = trunombreusuario;
      $rolError = "Rol dado esta fuera de formato";
    }


  // password validation
  if (empty($pass)){
   $error = true;
   $passError = "Por favor ingresa tu contraseña";
  } else if(strlen($pass) < 6) {
   $error = true;
   $passError = "Contraseña con al menos 6 caracteres";
  }

  // password encrypt using SHA256();
  $password = hash('sha256', $pass);




  // if there's no error, continue to signup
  if( !$error ) {

   $query = "INSERT INTO usuarios(nombre_usuario, id_usuario, id_estudiante,contrase�a, privilegio) VALUES('$name','$rol','$rol','$password', 0)";
   $res = mysql_query($query);

   if ($res) {
    $errTyp = "Exito!";
    $errMSG = "Usuario registrado, ya puedes logear!";
    unset($name);
    unset($rol);
    unset($pass);
   } else {
    $errTyp = "Peligro";
    $errMSG = "Intentalo mas tarde";
   }

  }


 }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registro de cuenta - Talleres libres USM </title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div class="container">

 <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

     <div class="col-md-12">

         <div class="form-group">
             <h2 class="">Ingreso </h2>
            </div>

         <div class="form-group">
             <hr />
            </div>

            <?php
   if ( isset($errMSG) ) {

    ?>
    <div class="form-group">
             <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>

            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
             <input type="text" name="name" class="form-control" placeholder="Nombre" maxlength="50" value="<?php echo $name ?>" />
                </div>
                <span class="text-danger"><?php echo $nameError; ?></span>
            </div>

            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="rol" name="rol" class="form-control" placeholder="rol xxxxxxxxx" maxlength="40" value="<?php echo $rol ?>" />
                </div>
                <span class="text-danger"><?php echo $rolError; ?></span>
            </div>

            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="Contraseña" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>

            <div class="form-group">
             <hr />
            </div>

            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Ingresar</button>
            </div>

            <div class="form-group">
             <hr />
            </div>

            <div class="form-group">
             <a href="index.php">Ingresa aqui!</a>
            </div>

        </div>

    </form>
    </div>

</div>

</body>
</html>
<?php ob_end_flush(); ?></html>
