<?php
require_once "DbUsuarios.php"; 
class UsuarioAPI {    
    public function API(){
        header('Content-Type: application/JSON');                
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
        case 'GET'://consulta
            $this->getPeoples();
            break;     
        case 'POST'://inserta
            $this->savePeople();
            break;                
        case 'PUT'://actualiza
            $this->updatePeople();
            break;      
        case 'DELETE'://elimina
            $this->deletePeople();
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
    
    function deletePeople(){
        if( isset($_GET['action']) && isset($_GET['id']) ){
            if($_GET['action']=='usuarios'){                   
                $db = new PeopleDB();
                $db->delete($_GET['id']);
                $this->response(204);                   
                exit;
            }
        }
        $this->response(400);
    }
    
    
    function getPeoples(){
      if($_GET['action']=='usuarios'){         
          $db = new PeopleDB();
         if(isset($_GET['id'])){//muestra 1 solo registro si es que existiera ID                 
             $response = $db->checkID($_GET['id'],$_GET['username']);
             if($response==1){
                 $user= $db->getPeople($_GET['id']);
                 echo json_encode($user,JSON_PRETTY_PRINT);
             }else{
                echo 0; 
             }
         }//else{ //muestra todos los registros                   
            // $response = $db->getPeoples();              
             //echo json_encode($response,JSON_PRETTY_PRINT);
         //}
     }else{
            $this->response(400);
     }       
    }
    
    function updatePeople() {
        if( isset($_GET['action']) && isset($_GET['id']) ){
            if($_GET['action']=='usuarios'){
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
    
    function savePeople(){
      if($_GET['action']=='usuarios'){   
          //Decodifica un string de JSON
          $obj = json_decode( file_get_contents('php://input') );   
          $objArr = (array)$obj;
          if (empty($objArr)){
             $this->response(422,"error","Nothing to add. Check json");                           
         }else if(isset($obj->nombreusuario)){
             $people = new PeopleDB();     
             $people->insert( $obj->nombreusuario, $obj->username, $obj->email, $obj->rol, $obj->password );
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