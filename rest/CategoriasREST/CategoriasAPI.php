<?php
require_once "DBCategorias.php"; 
class CategoriaAPI {    
    public function API(){
        header('Content-Type: application/JSON');                
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
        case 'GET'://consulta
            $this->getCategorias();
            break;     
        case 'POST'://inserta

            break;                
        case 'PUT'://actualiza

            break;      
        case 'DELETE'://elimina

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
    
    
    function getCategorias(){
      if($_GET['action']=='categorias'){         
          $db = new CategoriasDB();
          $response = $db->getCategorias($_GET['id']);              
          echo json_encode($response,JSON_PRETTY_PRINT);
     }else{
            $this->response(400);
     }       
    }
    
    
    
}//end class

?>