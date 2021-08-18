<?php 
/**
* 
*/
class Clientes
{
	private $cli_id;
	private $cli_nombre;
	private $cli_direccion;
	private $cli_colonia;
	private $cli_ciudad;
	private $cli_cp;
	private $cli_telefono;
	private $cli_estado;
	private $cli_pais;
	private $cli_rfc;
	private $cli_grupo_cliente;
	private $nombre_grupo;

	
	function __construct($cli_id,$cli_nombre,$cli_direccion,$cli_colonia,$cli_ciudad,$cli_cp,$cli_telefono,$cli_estado,$cli_pais,$cli_rfc,$cli_grupo_cliente,
                         $nombre_grupo)
	{
		$this->setId($cli_id);
		$this->setNombre($cli_nombre);
		$this->setDireccion($cli_direccion);
		$this->setColonia($cli_colonia);
		$this->setCiudad($cli_ciudad);
		$this->setCp($cli_cp);
		$this->setTelefono($cli_telefono);
		$this->setEstado($cli_estado);
		$this->setPais($cli_pais);		
		$this->setRFC($cli_rfc);		
		$this->setCliGrupoEmp($cli_grupo_cliente);		
		$this->setNombreGrupoEmp($nombre_grupo);		
	}

	public function getId(){
		return $this->cli_id;
	}
	public function setId($id){
		$this->cli_id=$id;
	}
	public function getNombre(){
		return $this->cli_nombre;
	}
	public function setNombre($nombre){
		 $this->cli_nombre=$nombre;
	}
	public function getDireccion(){
		return $this->cli_direccion;
	}
	public function setDireccion($direccion){
		$this->cli_direccion=$direccion;
	}
	public function getColonia(){
		return $this->cli_colonia;
    }
	public function setColonia($colonia){
		$this->cli_colonia=$colonia;
	}
	public function getCiudad(){
		return $this->cli_ciudad;
    }
	public function setCiudad($ciudad){
		$this->cli_ciudad=$ciudad;
	}
	public function getCp(){
		return $this->cli_cp;
    }
	public function setCp($cp){
		 $this->cli_cp=$cp;
	}
    public function getTelefono(){
		return $this->cli_telefono;
	}
	 public function setTelefono($telefono){
		 $this->cli_telefono=$telefono;
	}
	public function getEstado(){
		return $this->cli_estado;
	}
public function setEstado($estado){
		$this->cli_estado=$estado;
	}

	public function getPais(){
		return $this-> cli_pais;
	}
public function setPais($pais){
		$this->cli_pais=$pais;
	}

	public function getRFC(){
		return $this->cli_rfc;
	}
public function setRFC($rfc){
		$this->cli_rfc=$rfc;
	}

	public function getCliGrupoEmp(){
		return $this->cli_grupo_cliente;
	}
public function setCliGrupoEmp($grupo_cliente){
		$this->cli_grupo_cliente =$grupo_cliente;
	}
    	public function getNombreGrupoEmp(){
		return $this->nombre_grupo;
	}
public function setNombreGrupoEmp($nombre_grupo){
		$this->nombre_grupo =$nombre_grupo;
	}


	public static function save($cliente){
		$db=Db::getConnect();
		//var_dump($alumno);
		//die();
	$Nombre=$cliente->getNombre();
$Direccion=$cliente->getDireccion();
$Colonia=$cliente->getColonia();
$Ciudad=$cliente->getCiudad();
$Cp=$cliente->getCp();
 $Telefono=$cliente->getTelefono();
$Estado=$cliente->getEstado();
$Pais=$cliente->getPais();
$RFC=$cliente->getRFC();
$CliGrupoEmp=$cliente->getCliGrupoEmp();
    
		$insert=$db->prepare('CALL sp_clientes_INSERT(:nombre, :direccion, :colonia, :ciudad, :cp, :telefono, :estado, :pais, :rfc, :grupo_cliente,@ultimoID)');
        $insert->bindParam(':nombre', $Nombre, PDO::PARAM_STR, 45);
        $insert->bindParam(':direccion', $Direccion, PDO::PARAM_STR, 45);
        $insert->bindParam(':colonia', $Colonia, PDO::PARAM_STR, 45);
        $insert->bindParam(':ciudad', $Ciudad, PDO::PARAM_STR, 45);
        $insert->bindParam(':cp', $Cp, PDO::PARAM_STR, 45);
        $insert->bindParam(':telefono', $Telefono, PDO::PARAM_STR, 45);
        $insert->bindParam(':estado', $Estado, PDO::PARAM_STR, 45);
        $insert->bindParam(':pais', $Pais, PDO::PARAM_STR, 45);
        $insert->bindParam(':rfc', $RFC, PDO::PARAM_STR, 45);
        $insert->bindParam(':grupo_cliente', $CliGrupoEmp, PDO::PARAM_INT, 10);
       
		$insert->execute();
         $insert = $db->query("select @ultimoID as id;")->fetchAll();
        return $insert[0]['id'];
	}

     public static function LastInsert_Search($id){
     
		$db=Db::getConnect();
		$listaEmpresas=[];
        $tmp = 0;

         $select=$db->prepare('SELECT 
        
    clientes.cli_id,clientes.cli_nombre,clientes.cli_direccion,clientes.cli_colonia,clientes.cli_ciudad,clientes.cli_cp,clientes.cli_telefono,    clientes.cli_estado,    clientes.cli_pais,    clientes.cli_rfc,clientes.cli_grupo_cliente,grupo_empresas.gem_nombre,    grupo_empresas.gem_id         
        FROM clientes LEFT JOIN grupo_empresas ON  grupo_empresas.gem_id = clientes.cli_grupo_cliente  WHERE cli_id= :cli_id');
        $select->bindValue(':cli_id',$id,PDO::PARAM_INT);
        $select->execute();

        foreach($select->fetchAll() as $cliente){
		      $listaEmpresas[0] = ['cli_id'=>$cliente['cli_id'],
                                   'cli_nombre'=> $cliente['cli_nombre'],
                                  'cli_direccion' =>$cliente['cli_direccion'],
                                  'cli_colonia' =>$cliente['cli_colonia'] ,
                                  'cli_ciudad' =>$cliente['cli_ciudad'] ,
                                  'cli_cp' =>$cliente['cli_cp'] ,
                                  'cli_telefono' =>$cliente['cli_telefono'] ,
                                  'cli_estado' =>$cliente['cli_estado'],
                                  'cli_pais' =>$cliente['cli_pais'],
                                  'cli_rfc' =>$cliente['cli_rfc'],
                                  'cli_grupo_cliente' =>$cliente['cli_grupo_cliente'],
                                  'cli_nombre_grupo' =>$cliente['gem_nombre'],
                                  ];
        }
      return  $listaEmpresas;
	}
	public static function all(){
		$db=Db::getConnect();
		$listaClientes=[];

		$select=$db->query('SELECT 
        
    clientes.cli_id,
    clientes.cli_nombre,
    clientes.cli_direccion,
    clientes.cli_colonia,
    clientes.cli_ciudad,
    clientes.cli_cp,
    clientes.cli_telefono,
    clientes.cli_estado,
    clientes.cli_pais,
    clientes.cli_rfc,

    grupo_empresas.gem_nombre,
    grupo_empresas.gem_id         
        FROM clientes LEFT JOIN grupo_empresas ON  grupo_empresas.gem_id = clientes.cli_grupo_cliente order by cli_id');

		foreach($select->fetchAll() as $cliente){
			$listaClientes[]=new Clientes(  
                $cliente['cli_id'],	
                $cliente['cli_nombre'],	
                $cliente['cli_direccion'],	
                $cliente['cli_colonia'],	
                $cliente['cli_ciudad'],	
                $cliente['cli_cp'],	
                $cliente['cli_telefono'],	
                $cliente['cli_estado'],	
                $cliente['cli_pais'],	
                $cliente['cli_rfc'],	
                $cliente['cli_rfc'],	
                $cliente['gem_nombre'] );
		}
		return ($listaClientes);
	}

	public static function searchById($id){
//		$db=Db::getConnect();
//		$select=$db->prepare('SELECT * FROM clientes WHERE id=:id');
//		$select->bindValue('id',$id);
//		$select->execute();
//
//		//die();
//		return $var;
	}

	public static function update($cliente){
        $db=Db::getConnect();
		//var_dump($alumno);
		//die();
        $id=$cliente->getId();
	$Nombre=$cliente->getNombre();
$Direccion=$cliente->getDireccion();
$Colonia=$cliente->getColonia();
$Ciudad=$cliente->getCiudad();
$Cp=$cliente->getCp();
 $Telefono=$cliente->getTelefono();
$Estado=$cliente->getEstado();
$Pais=$cliente->getPais();
$RFC=$cliente->getRFC();
$CliGrupoEmp=$cliente->getCliGrupoEmp();
    
		$insert=$db->prepare('CALL sp_clientes_UPDATE(:nombre, :direccion, :colonia, :ciudad, :cp, :telefono, :estado, :pais, :rfc, :grupo_cliente,:id)');
        $insert->bindParam(':id', $id, PDO::PARAM_STR, 10);
        $insert->bindParam(':nombre', $Nombre, PDO::PARAM_STR, 45);
        $insert->bindParam(':direccion', $Direccion, PDO::PARAM_STR, 45);
        $insert->bindParam(':colonia', $Colonia, PDO::PARAM_STR, 45);
        $insert->bindParam(':ciudad', $Ciudad, PDO::PARAM_STR, 45);
        $insert->bindParam(':cp', $Cp, PDO::PARAM_STR, 45);
        $insert->bindParam(':telefono', $Telefono, PDO::PARAM_STR, 45);
        $insert->bindParam(':estado', $Estado, PDO::PARAM_STR, 45);
        $insert->bindParam(':pais', $Pais, PDO::PARAM_STR, 45);
        $insert->bindParam(':rfc', $RFC, PDO::PARAM_STR, 45);
        $insert->bindParam(':grupo_cliente', $CliGrupoEmp, PDO::PARAM_INT, 10);
       
		$insert->execute();

//		$db=Db::getConnect();
//		$update=$db->prepare('UPDATE clientes SET 	cli_nombre=:nombre,direccion=:direccion,colonia=:colonia,ciudad=:ciudad,cp=:cp,telefono=:telefono,estado=:estado,pais=:cli_pais,rfc=:rfc,grupo_cliente=:grupo_cliente WHERE cli_id=:id');
//		$update->bindValue('id',$cliente->getId());
//		$update->bindValue('nombre',$cliente->getNombre());
//		$update->bindValue('direccion',$cliente->getDireccion());
//		$update->bindValue('colonia',$cliente->getColonia());
//		$update->bindValue('ciudad',$cliente->getCiudad());
//		$update->bindValue('cp',$cliente->getCp());
//		$update->bindValue('telefono',$cliente->getTelefono());
//		$update->bindValue('estado',$cliente->getEstado());
//		$update->bindValue('pais',$cliente->getPais());
//		$update->bindValue('rfc',$cliente->getRFC());
//		$update->bindValue('grupo_cliente',$cliente->getCliGrupoEmp());
//                var_dump($cliente);
//
//		$update->execute();
	}

	public static function delete($cliente_id){
        
         
             
             $db=Db::getConnect();
        $delete = $db->prepare("CALL sp_clientes_DELETE(:cli_id)");
        $delete->bindParam(':cli_id', $cliente_id, PDO::PARAM_INT, 10);
        $delete->execute();	      
//		$db=Db::getConnect();
//		$delete=$db->prepare('DELETE  FROM clientes WHERE id=:id');
//		$delete->bindValue('id',$cliente_id);

//		$delete->execute();		
	}
}

?>