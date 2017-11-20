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
                    <th>Id Ticket</th>
                    <th>Titulo</th>
                    <th>Orden</th>
                    <th>Empresa</th>
                    <th>Fecha</th>
                    <th>Servicios Consumidos</th>
                    <th>Edit</th>
                </tr>
                    <?php
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => "http://localhost/TicketsREST/servicios/2"
                    ));
                    $resp = curl_exec($curl);
                    curl_close($curl);
                    $data=json_decode($resp);
                    //echo $resp;
                    foreach($data as $valor){
                        $idTicket=$valor->IdServicio;
                        $titulo=$valor->Titulo;
                        $orden=$valor->Orden;
                        $nombreCliente=$valor->NombreCliente;
                        $fecha=$valor->Fecha;
                        $inicio=$valor->HoraInicio;
                        $fin=$valor->HoraFin;
                        $tipo=$valor->Nombre;
                        if($tipo=="Descontable"){
                            $time1=strtotime($inicio);
                            $time2=strtotime($fin);
                            $difference = round(abs($time2 - $time1) / 3600,2);
                        }else{
                            $difference=0;
                        }
                        echo "<tr>";
                        echo "<td>";
                        echo "<div class='container_status'>";
                        echo "<div class='status_ticket_open'></div> Abierto</div>";
                        echo "</td>";
                        echo "<td>$idTicket</td>";
                        echo "<input type='hidden' value='$idTicket' id='valor'>";
                        echo "<td>$titulo</td>";
                        echo "<td>$orden</td>";
                        echo "<td>$nombreCliente</td>";
                        echo "<td>$fecha</td>";
                        echo "<td>$difference</td>";
                        echo "<td name='$idTicket' id='editar'><a href='http://localhost/Pagina/sites/tickets.php'></a>
                                <i class='fa fa-pencil-square-o' aria-hidden='true'></i>
                            </td>";
                        echo "</tr>";
                        echo "</form>";
                    }
                    ?>
                
            </table>
        </div>
        <button class="accordion">Cerrados</button>
        <div class="panel">
            <table>
                <tr>
                    <th >Status</th>
                    <th>Id Ticket</th>
                    <th>Titulo</th>
                    <th>Orden</th>
                    <th>Empresa</th>
                    <th>Fecha</th>
                    <th>Servicios Consumidos</th>
                </tr>
                <?php
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => "http://localhost/TicketsREST/servicios/3"
                    ));
                    $resp = curl_exec($curl);
                    curl_close($curl);
                    $data=json_decode($resp);
                    //echo $resp;
                    foreach($data as $valor){
                        $idTicket=$valor->IdServicio;
                        $titulo=$valor->Titulo;
                        $orden=$valor->Orden;
                        $nombreCliente=$valor->NombreCliente;
                        $fecha=$valor->Fecha;
                        $inicio=$valor->HoraInicio;
                        $fin=$valor->HoraFin;
                        $tipo=$valor->Nombre;
                        if($tipo=="Descontable"){
                            $time1=strtotime($inicio);
                            $time2=strtotime($fin);
                            $difference = round(abs($time2 - $time1) / 3600,2);
                        }else{
                            $difference=0;
                        }
                        echo "<tr>";
                        echo "<td>";
                        echo "<div class='container_status'>";
                        echo "<div class='status_ticket_closed'></div> Cerrado</div>";
                        echo "</td>";
                        echo "<td>$idTicket</td>";
                        echo "<td>$titulo</td>";
                        echo "<td>$orden</td>";
                        echo "<td>$nombreCliente</td>";
                        echo "<td>$fecha</td>";
                        echo "<td>$difference</td>";
                        echo "</tr>";
                    }
                    ?>
            </table>
        </div>
        <button class="accordion">En espera</button>
        <div class="panel">
                <table>
                    <tr>
                        <th>Status</th>
                        <th>Id Ticket</th>
                        <th>Titulo</th>
                        <th>Orden</th>
                        <th>Empresa</th>
                        <th>Fecha</th>
                        <th>Servicios Consumidos</th>
                    </tr>
                    <?php
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => "http://localhost/TicketsREST/servicios/1"
                    ));
                    $resp = curl_exec($curl);
                    curl_close($curl);
                    $data=json_decode($resp);
                    //echo $resp;
                    foreach($data as $valor){
                        $idTicket=$valor->IdServicio;
                        $titulo=$valor->Titulo;
                        $orden=$valor->Orden;
                        $nombreCliente=$valor->NombreCliente;
                        $fecha=$valor->Fecha;
                        $inicio=$valor->HoraInicio;
                        $fin=$valor->HoraFin;
                        $tipo=$valor->Nombre;
                        if($tipo=="Descontable"){
                            $time1=strtotime($inicio);
                            $time2=strtotime($fin);
                            $difference = round(abs($time2 - $time1) / 3600,2);
                        }else{
                            $difference=0;
                        }
                        echo "<tr>";
                        echo "<td>";
                        echo "<div class='container_status'>";
                        echo "<div class='status_ticket_wait'></div> En espera</div>";
                        echo "</td>";
                        echo "<td>$idTicket</td>";
                        echo "<td>$titulo</td>";
                        echo "<td>$orden</td>";
                        echo "<td>$nombreCliente</td>";
                        echo "<td>$fecha</td>";
                        echo "<td>$difference</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/tickets.js"></script>
    
    <script>
    $(document).ready(function(){

        $("td").click(function(){
            if($(this).attr('id')=="editar"){
                var ticket=$(this).attr('name');
                location.href ="newticket.php?service="+ticket;
            }
        });

    });
    </script>
    
    
    
    

</body>

</html>
