<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png" />
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
        crossorigin="anonymous">
    <link rel="stylesheet" href="../css/newticket.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <title>Nuevo Ticket</title>
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
    }if(isset($_GET['service'])){
        
    }
    if(isset($_POST['cliente']) && isset($_POST['status'])){
        $nombreCliente=$_POST['cliente'];
        $status=$_POST['status'];
        if($status=="espera"){
            $idStatus=1;
        }
        if($status=="abierto"){
            $idStatus=2;
        }
        $stgTipo=$_POST['tipo'];
        if($stgTipo=="Descontable"){
            $tipo=2;
        }
        if($stgTipo=="Facturable"){
            $tipo=1;
        }
        if($stgTipo=="Garantia"){
            $tipo=3;
        }
        $inicio=$_POST['inicio'];
        $fin=$_POST['fin'];
        $date=$_POST['dia'];
        $fecha=date('d/m/Y', strtotime($date));
        $user=$_SESSION['idUsuario'];
        $description=$_POST['description'];
        $titulo=$_POST['titulo'];
        $orden=$_POST['orden'];
        $categoria=$_POST['categoria'];
        $data = array("idTipo" => $tipo, "inicio" => $inicio, "fin" => $fin, "fecha" => $fecha, "usuario" => $user, "description" => $description, "titulo" => $titulo, "nombreCliente" => $nombreCliente, "status" => $idStatus, "orden" => $orden, "categoria" => $categoria);                                                                    
        $data_string = json_encode($data);
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt($curl, CURLOPT_URL,"http://localhost/TicketsREST/servicios");
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
        );

        // in real life you should use something like:
        // curl_setopt($ch, CURLOPT_POSTFIELDS, 
        //          http_build_query(array('postvar1' => 'value1')));

        // receive server response ...
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        $operacion=json_decode($resp);
        if($operacion->status=="success"){
            echo "<script>alert('Nuevo ticket ingresado')</script>";
        }else{
            echo "<script>alert('Error')</script>";
        }
        
    }
    
    
    ?>
<form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post" name="formTickets">
    <div class="buttons_container">
        <a href="tickets.php">
            <div class="backbutton button_menu">
                <i class="fa fa-arrow-left iconito" aria-hidden="true"></i>
            </div>
        </a>
    </div>

    <div class="form_inputs">
        <p class="title_form">Creación de nuevo ticket</p>

        <div class="row">
            <form class="col s12 entradas">
                <p class="guia">Elija la empresa a la cual corresponde el servicio</p>
                <div class="row">
                    <div class="input-field col s12">
                        <?php
                        if(isset($_GET['empresa'])){
                            $parametro=$_GET['empresa'];
                            echo "<input type='text' id='default' list='empresas' placeholder='e.g. Metalmuebles' name='cliente' value='$parametro'>";
                        }else{
                            echo "<input type='text' id='default' list='empresas' placeholder='e.g. Metalmuebles' name='cliente'>";
                        }
                        ?>
                    </div>
                </div>
                <datalist id="empresas">
                    <?php
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => "http://localhost/ClientesREST/clientes"
                    ));
                    $resp = curl_exec($curl);
                    curl_close($curl);
                    $data=json_decode($resp);
                    foreach($data as $valor){
                        $empresa=$valor->NombreCliente;
                        echo "<option value='$empresa'>";
                    }
                    ?>
                </datalist>
                <p class="guia">Indique tiempo y fecha del servicio</p>
                <div class="row separator"></div>
                <div class="row">
                </div>
                <div class="input-field col s6">

                    <input type="text" class="datepicker" name="dia">
                    <label for="fecha">Día del servicio
                        <i class="fa fa-calendar icono_fecha" aria-hidden="true"></i>
                    </label>
                    <!--captura fecha-->
                </div>
                <div class="input-field col s3">
                    <label for="hora_inicio" class="hora_inicio">Hora inicio
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                    </label>
                    <input placeholder="inicio" type="text" class="timepicker" name="inicio">
                </div>
                <div class="input-field col s3">
                    <label for="hora_fin" class="hora_fin">Hora fin
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                    </label>
                    <input placeholder="fin" type="text" class="timepicker" name="fin">
                </div>

                <p class="guia">Dé una descripción completa del servicio</p>
                <div class="row separator"></div>
                <div class="row">
                    <div class="input-field col s3">
                        <input id="orden" type="number" class="validate" name="orden">
                        <label for="orden">N° Orden de servicio
                            <i class="fa fa-file-text" aria-hidden="true"></i>
                        </label>
                    </div>
                    <div class="input-field col s2">
                        <input type="text" id="default" list="categorias" placeholder="Categoría" name="categoria">
                    </div>
                    <datalist id="categorias">
                        <?php
                        if(isset($_GET['empresa'])){
                            $curl = curl_init();
                            $parametro=$_GET['empresa'];
                            $cadena = str_replace(" ","%20",$parametro);
                            curl_setopt_array($curl, array(
                                CURLOPT_RETURNTRANSFER => 1,
                                CURLOPT_URL => "http://localhost/CategoriasREST/categorias/$cadena"
                            ));
                            $resp = curl_exec($curl);
                            curl_close($curl);
                            $data=json_decode($resp);
                            foreach($data as $valor){
                                $empresa=$valor->Nombre;
                                echo "<option value='$empresa'>";
                            }
                        }
                        ?>
                    
                    </datalist>
                    <div class="input-field col s2">
                        <input type="text" id="default" list="tipo" placeholder="Tipo de servicio" name="tipo">
                    </div>
                    <datalist id="tipo">
                        <option value="Descontable">
                            <option value="Facturable">
                                <option value="Garantia">
                    </datalist>
                    <div class="input-field col s5">
                        <input id="titulo_servicio" type="text" class="validate" name="titulo">
                        <label for="titulo_servicio">Titulo servicio </label>
                    </div>
                </div>
                <div class="row">
                    <form class="col s12">
                        <div class="row">
                            <div class="input-field col s12">
                                <textarea id="description" class="materialize-textarea" name="description"></textarea>
                                <label for="description">Descripción del servicio realizado</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="divstatus">
                </div>
            </form>
        </div>
        
    </div>
    
    

    <div class="buttons_container_footer">
        <a id="espera">
            <div class="backbutton button_menu submit_form">
                <i class="fa fa-check iconito" aria-hidden="true"></i>
            </div>
        </a>
        <a id="abierto">
            <div class="backbutton button_menu save_ticket">
                    <i class="fa fa-floppy-o iconito" aria-hidden="true"></i>
            </div>
        </a>
    </div>
</form>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <script src="../js/newticket.js"></script>
    <script>
        $("#default").on('input', function () {
            location.href ="newticket.php?empresa="+$(this).val();
        });
    </script>
    
    <script>
        $("#abierto").on('click', function () {
            $("#divstatus").append("<input type='hidden' name='status' value='abierto'>");
            document.formTickets.submit();
        });
    </script>

    <script>
        $("#espera").on('click', function () {
            $("#divstatus").append("<input type='hidden' name='status' value='espera'>");
            document.formTickets.submit();
        });
    </script>

    

</body>

</html>