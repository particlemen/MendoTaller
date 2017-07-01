<?php

 // this will avoid mysql_connect() deprecation error.
 error_reporting( ~E_DEPRECATED & ~E_NOTICE );
 // but I strongly suggest you to use PDO or MySQLi.

 define('DBHOST', 'localhost');
 define('DBUSER', 'root');
 define('DBPASS', 'localhost');
 define('DBNAME', 'dbtest');

 $conn = mysql_connect(DBHOST,DBUSER,DBPASS);
 $dbcon = mysql_select_db(DBNAME);

 if ( !$conn ) {
  die("Connection failed : " . mysql_error());
 }

 if ( !$dbcon ) {
  die("Database Connection failed : " . mysql_error());
 }



 // Create connection
 $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
 // Check connection
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

 // sql to create table
  $sql = "CREATE TABLE IF NOT EXISTS USUARIO
  (	ID_USUARIO NUMBER NOT NULL ENABLE,
  NAME VARCHAR2(45) NOT NULL ENABLE,
  CONTRASEÑA VARCHAR2(45) NOT NULL ENABLE,
  PRIVILEGIO NUMBER NOT NULL ENABLE,
  ID_ESTUDIANTE NUMBER NOT NULL ENABLE,
   CONSTRAINT USUARIO_PK PRIMARY KEY (ID_USUARIO, ID_ESTUDIANTE)
   USING INDEX  ENABLE
   )"

 ?>
