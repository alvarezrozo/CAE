<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png" />
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link rel="stylesheet" href="../css/tickets.css">
    <title>Tickets</title>
</head>

<body>
    <?php session_start() ?>
    <?php
    if (isset($_GET['accion'])){
        session_destroy();
        echo '<script type="text/javascript">location.href ="../index.php";</script>';
    }
        if(isset($_SESSION['rol'])){
            $rol=$_SESSION['rol'];
            $user=$_SESSION['nombreUser'];
            if($rol!=="Tecnico"){
                echo '<script type="text/javascript">alert("No tiene los permisos requeridos");</script>';
                echo '<script type="text/javascript">location.href ="../index.php";</script>';
            }
            echo "<div class='tecnicocontainer'><p>Técnico: $user </p></div>";
        }else{
            echo '<script type="text/javascript">location.href ="../index.php";</script>';
        }
    ?>
    <div class="buttons_container">
        <a href="support.php">
            <div class="backbutton button_menu">
                <i class="fa fa-arrow-left iconito" aria-hidden="true"></i>
            </div>
        </a>

        <a href="<?php echo $_SERVER['PHP_SELF'].'?accion=logout;'?>">
            <div class="logout button_menu">
                <i class="fa fa-power-off iconito" aria-hidden="true"></i>
            </div>
        </a>

        <a href="newticket.php">
            <div class="addticket button_menu">
                    <i class="fa fa-plus iconito" aria-hidden="true"></i>
            </div>
        </a>

    </div>
    <div class="accordion_container">
        <p class="title">Tickets</p>
        <button class="accordion">Abiertos </button>

        <div class="panel">
            <table>
                <tr>
                    <th>Status</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Points</th>
                    <th>Points</th>
                    <th>Points</th>
                    <th>Points</th>
                    <th>Edit</th>
                </tr>
                <tr>
                    <td>
                        <div class="container_status">
                            <div class="status_ticket_open"></div> Abierto</div>
                    </td>
                    <td>Jill</td>
                    <td>Smith</td>
                    <td>50</td>
                    <td>50</td>
                    <td>50</td>
                    <td>50</td>
                    <td>
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="container_status">
                            <div class="status_ticket_open"></div> Abierto</div>
                    </td>
                    <td>Eve</td>
                    <td>Jackson</td>
                    <td>94</td>
                    <td>94</td>
                    <td>94</td>
                    <td>94</td>
                    <td>
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="container_status">
                            <div class="status_ticket_open"></div> Abierto</div>
                    </td>
                    <td>Adam</td>
                    <td>Johnson</td>
                    <td>67</td>
                    <td>67</td>
                    <td>67</td>
                    <td>67</td>
                    <td>
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </td>
                </tr>
            </table>
        </div>
        <button class="accordion">Cerrados</button>
        <div class="panel">
            <table>
                <tr>
                    <th>Status</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Points</th>
                    <th>Points</th>
                    <th>Points</th>
                    <th>Points</th>
                </tr>
                <tr>

                    <td>
                        <div class="container_status">
                            <div class="status_ticket_closed"></div> Cerrado</div>
                    </td>
                    <td>Jill</td>
                    <td>Smith</td>
                    <td>50</td>
                    <td>50</td>
                    <td>50</td>
                    <td>50</td>
                </tr>
                <tr>
                    <td>
                        <div class="container_status">
                            <div class="status_ticket_closed"></div> Cerrado</div>
                    </td>
                    <td>Eve</td>
                    <td>Jackson</td>
                    <td>94</td>
                    <td>94</td>
                    <td>94</td>
                    <td>94</td>
                </tr>
                <tr>
                    <td>
                        <div class="container_status">
                            <div class="status_ticket_closed"></div> Cerrado</div>
                    </td>
                    <td>Adam</td>
                    <td>Johnson</td>
                    <td>67</td>
                    <td>67</td>
                    <td>67</td>
                    <td>67</td>
                </tr>
            </table>
        </div>
        <button class="accordion">En espera</button>
        <div class="panel">
                <table>
                    <tr>
                        <th>Status</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Points</th>
                        <th>Points</th>
                        <th>Points</th>
                        <th>Points</th>
                    </tr>
                    <tr>
                        <td>
                            <div class="container_status">
                                <div class="status_ticket_wait"></div> En espera</div>

                        </td>
                        <td>Jill</td>
                        <td>Smith</td>
                        <td>50</td>
                        <td>50</td>
                        <td>50</td>
                        <td>50</td>

                    </tr>
                    <tr>
                        <td>
                            <div class="container_status">
                                <div class="status_ticket_wait"></div> En espera</div>
                        </td>
                        <td>Eve</td>
                        <td>Jackson</td>
                        <td>94</td>
                        <td>94</td>
                        <td>94</td>
                        <td>94</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="container_status">
                                <div class="status_ticket_wait"></div> En espera</div>
                        </td>
                        <td>Adam</td>
                        <td>Johnson</td>
                        <td>67</td>
                        <td>67</td>
                        <td>67</td>
                        <td>67</td>
                    </tr>
                </table>
            </div>
        </div>

        
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/tickets.js"></script>

</body>

</html>