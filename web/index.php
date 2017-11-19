<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <title>CAE</title>
</head>

<body>
    
    <?php session_start() ?>
    <?php
    if(isset($_SESSION['rol'])){
        if($_SESSION['rol']=="Tecnico"){
            echo '<script type="text/javascript">location.href ="sites/support.php";</script>';
        }
    }
    if(isset($_POST['user'])){
        $user = $_POST["user"];
        $pass = $_POST["pass"];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => "http://localhost/ServicioRest/usuarios/$user/$pass"
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        if($resp=="0"){
            echo '<script type="text/javascript">alert("Nombre de usuario o contraseña incorrectos");</script>';
        }else{
            $data=json_decode($resp);
            $nombre=$data[0]->NombreUsuario;
            $rol=$data[0]->NombreRol;
            $idUsuario=$data[0]->IdUsuario;
            $_SESSION['nombreUser']=$nombre;
            $_SESSION['rol']=$rol;
            $_SESSION['idUsuario']=$idUsuario;
            //echo $rol;
            if($rol=="Tecnico"){
                echo '<script type="text/javascript">location.href ="sites/support.php";</script>';
            }
        }
        
    }    
    ?>

    <img src="img/logocenter.png" class="centerico">
    <p class="titulo">Contract Administrator e-systems s.a.s</p>
    <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">
    <div class="form_container">
        <input class="input" type="text" placeholder="usuario" name="user">
        <br>
        <input class="input" type="password" placeholder="contraseña" name="pass">
        <a><input class="button_intro" type="submit" value="ENTRAR"></a>
    </div>
    </form>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


</body>

</html>