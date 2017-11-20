<?php
require_once "DBServicios.php"; 
class ServicioAPI {    
    public function API(){
        header('Content-Type: application/JSON');                
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
        case 'GET'://consulta
            $this->getServicios();
            break;     
        case 'POST'://inserta
            $this->saveServicio();
            break;                
        case 'PUT'://actualiza
            $this->updateServicio();
            break;      
        case 'DELETE'://elimina
            $this->deleteServicio();
            break;
        default://metodo NO soportado
            echo 'METODO NO SOPORTADO';
            break;
        }
    }
    
    function response($code=200, $status="", $message="") {
        http_response_code($code);
        if( !empty($status) && !empty($message) ){
            $response = array("status" => $status ,"message"=>$message);  
            echo json_encode($response,JSON_PRETTY_PRINT);    
        }            
    }
    
    function deleteServicio(){
        if( isset($_GET['action']) && isset($_GET['id']) ){
            if($_GET['action']=='servicios'){                   
                $db = new ServiciosDB();
                $db->delete($_GET['id']);
                $this->response(204);                   
                exit;
            }
        }
        $this->response(400);
    }
    
    
    function getServicios(){
        if( isset($_GET['action']) && isset($_GET['id']) ){
            if($_GET['action']=='servicios'){         
                $db = new ServiciosDB();
                $response = $db->getServicio($_GET['id']);              
                echo json_encode($response,JSON_PRETTY_PRINT);
            }else{
                $this->response(400);
            }       
        }
    }
    
    function updatePeople() {
        if( isset($_GET['action']) && isset($_GET['id']) ){
            if($_GET['action']=='servicios'){
                $obj = json_decode( file_get_contents('php://input') );   
                $objArr = (array)$obj;
                if (empty($objArr)){                        
                    $this->response(422,"error","Nothing to add. Check json");                        
                }else if(isset($obj->password)){
                    $db = new PeopleDB();
                    $db->update($_GET['id'], $obj->password);
                    $this->response(200,"success","Record updated");                             
                }else{
                    $this->response(422,"error","The property is not defined");                        
                }     
                exit;
            }
        }
        $this->response(400);
    }
    
    function saveServicio(){
      if($_GET['action']=='servicios'){   
          //Decodifica un string de JSON
          $obj = json_decode( file_get_contents('php://input') );   
          $objArr = (array)$obj;
          if (empty($objArr)){
             $this->response(422,"error","Nothing to add. Check json");                           
         }else if(isset($obj->idTipo)){
             $servicio = new ServiciosDB();     
             $servicio->insert( $obj->idTipo, $obj->inicio, $obj->fin, $obj->fecha, $obj->usuario, $obj->description, $obj->titulo, $obj->nombreCliente, $obj->status, $obj->orden, $obj->categoria);
             $this->response(200,"success","new record added");                             
         }else{
             $this->response(422,"error","The property is not defined");
         }
     } else{               
         $this->response(400);
     }  
 }
    
}//end class

?>