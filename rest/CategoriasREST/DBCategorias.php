<?php

class CategoriasDB {
    
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
    

    public function getCategorias($id=''){
        $stmt = $this->mysqli->prepare("SELECT Nombre FROM tipocontratos INNER JOIN contratos ON tipocontratos.IdTipo=contratos.IdTipo INNER JOIN clientes ON contratos.IdCliente=clientes.IdCliente WHERE NombreCliente=?;");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();        
        $peoples = $result->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();
        return $peoples;              
    }
    

    
}