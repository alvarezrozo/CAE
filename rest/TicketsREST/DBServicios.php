<?php
/** 
 * @web http://www.jc-mouse.net/
 * @author jc mouse
 */
class ServiciosDB {
    
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
    public function getServicio($id=0){
        $stmt = $this->mysqli->prepare("SELECT IdServicio, Titulo, Orden, NombreCliente, Fecha, HoraInicio, HoraFin, Nombre FROM servicios INNER JOIN clientes ON servicios.IdCliente=clientes.IdCliente INNER JOIN tiposervicios ON servicios.IdTipo=tiposervicios.IdTipo WHERE IdStatus=? ; ");
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
    public function getServicios(){        
        $result = $this->mysqli->query('SELECT NombreCliente FROM clientes');          
        $peoples = $result->fetch_all(MYSQLI_ASSOC);          
        $result->close();
        return $peoples; 
    }
    
    /**
     * añade un nuevo registro en la tabla persona
     * @param String $name nombre completo de persona
     * @return bool TRUE|FALSE 
     */
    public function insert($idTipo=0,$inicio='',$fin='',$fecha='',$idUser=0, $description='', $titulo='', $nombreCliente='', $status=0, $orden=0, $categoria=''){
        $stmt = $this->mysqli->prepare("INSERT INTO servicios(IdTipo, HoraInicio, HoraFin, Fecha, IdUsuario, Descripcion, Titulo, IdCliente, IdStatus, Orden, Categoria) VALUES(?, TIME_FORMAT(?, '%H:%i:%s'), TIME_FORMAT(?, '%H:%i:%s'), STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, ?, (SELECT IdCliente FROM clientes WHERE NombreCliente=?), ?, ?, (SELECT IdTipo FROM tipocontratos WHERE Nombre=?));");
        $stmt->bind_param('sssssssssss', $idTipo,$inicio,$fin,$fecha,$idUser, $description, $titulo, $nombreCliente, $status, $orden, $categoria);
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