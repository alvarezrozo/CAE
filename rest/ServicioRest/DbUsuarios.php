<?php
/** 
 * @web http://www.jc-mouse.net/
 * @author jc mouse
 */
class PeopleDB {
    
    protected $mysqli;
    const LOCALHOST = 'mysql4.gear.host:3306';
    const USER = 'finalplataformas';
    const PASSWORD = 'nslssnsuc.1';
    const DATABASE = 'finalplataformas';
    
    /**
     * Constructor de clase
     */
    public function __construct() {           
        try{
            //conexión a base de datos
            $this->mysqli = new mysqli(self::LOCALHOST, self::USER, self::PASSWORD, self::DATABASE);
        }catch (mysqli_sql_exception $e){
            //Si no se puede realizar la conexión
            http_response_code(500);
            exit;
        }     
    } 
    
    /**
     * obtiene un solo registro dado su ID
     * @param int $id identificador unico de registro
     * @return Array array con los registros obtenidos de la base de datos
     */
    public function getPeople($id=''){
        $stmt = $this->mysqli->prepare("SELECT NombreUsuario, NombreRol FROM usuarios INNER JOIN roles ON usuarios.Rol=roles.IdRol WHERE Username=? ; ");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();        
        $peoples = $result->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();
        return $peoples;              
    }
    
    /**
     * obtiene todos los registros de la tabla "people"
     * @return Array array con los registros obtenidos de la base de datos
     */
    public function getPeoples(){        
        $result = $this->mysqli->query('SELECT * FROM usuarios');          
        $peoples = $result->fetch_all(MYSQLI_ASSOC);          
        $result->close();
        return $peoples; 
    }
    
    /**
     * añade un nuevo registro en la tabla persona
     * @param String $name nombre completo de persona
     * @return bool TRUE|FALSE 
     */
    public function insert($name='',$username='',$email='',$rol='',$password=''){
        $stmt = $this->mysqli->prepare("INSERT INTO usuarios(NombreUsuario, Username, Email, Rol, Password) VALUES (?,?,?,?,?); ");
        $stmt->bind_param('sssss', $name,$username,$email,$rol,$password);
        $r = $stmt->execute(); 
        $stmt->close();
        return $r;        
    }
    
    /**
     * elimina un registro dado el ID
     * @param int $id Identificador unico de registro
     * @return Bool TRUE|FALSE
     */
    public function delete($id='') {
        $stmt = $this->mysqli->prepare("DELETE FROM usuarios WHERE Username= ? ; ");
        $stmt->bind_param('s', $id);
        $r = $stmt->execute(); 
        $stmt->close();
        return $r;
    }
    
    /**
     * Actualiza registro dado su ID
     * @param int $id Description
     */
    public function update($id, $newPass) {
            $stmt = $this->mysqli->prepare("UPDATE usuarios SET Password=? WHERE Username= ? ; ");
            $stmt->bind_param('ss', $newPass,$id);
            $r = $stmt->execute(); 
            $stmt->close();
            return $r;    
    }
    
    /**
     * verifica si un ID existe
     * @param int $id Identificador unico de registro
     * @return Bool TRUE|FALSE
     */
    public function checkID($username, $password){
        $stmt = $this->mysqli->prepare("SELECT * FROM usuarios WHERE Username=? AND Password=?");
        $stmt->bind_param("ss", $username, $password);
        if($stmt->execute()){
            $stmt->store_result();    
            if ($stmt->num_rows == 1){                
                return true;
            }
        }        
        return false;
    }
    
}