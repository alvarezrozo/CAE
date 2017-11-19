<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png" />
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/support.css">
    <title>Support</title>
</head>

<body>
    
    <?php session_start() ?>
    <?php
        if(isset($_SESSION['rol'])){
            $rol=$_SESSION['rol'];
            if($rol!=="Tecnico"){
                echo '<script type="text/javascript">alert("No tiene los permisos requeridos");</script>';
                echo '<script type="text/javascript">location.href ="../index.php";</script>';
            }
        }else{
            echo '<script type="text/javascript">location.href ="../index.php";</script>';
        }
    ?>


    <a href="tickets.php">
        <div class="vermas menu">
            <i class="fa fa-book icono_menu" aria-hidden="true"></i>
        </div>
    </a>
    <a href="newticket.php">
        <div class="agregar menu">
            <i class="fa fa-plus icono_menu" aria-hidden="true"></i>
        </div>
    </a>
</body>

</html>