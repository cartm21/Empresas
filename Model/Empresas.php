<?php 
/**
* Modelo de empresas12
*/
class Empresas 
{
    private $gem_id;
	private $gem_nombre;

    function __construct($gem_id,$gem_nombre)
    {
        $this->setGem_Id($gem_id);
		$this->setGem_Nombre($gem_nombre);
    }
   

    
    public function getGem_Id(){
		return $this->gem_id;
	}
	public function setGem_Id($gem_id){
		$this->gem_id=$gem_id;
	}
    
    
    public function getGem_Nombre(){
		return $this->gem_nombre;
	}
	public function setGem_Nombre($gem_nombre){
		$this->gem_nombre=$gem_nombre;
	}

     
    public static function save($grupo_emp){
		$db=Db::getConnect();
		//var_dump($alumno);
		//die();
		/*$insert=$db->prepare('INSERT INTO grupo_empresas VALUES (NULL, :nombre); SELECT LAST_INSERT_ID() as gem_id;');
		$insert->bindValue('nombre',$grupo_emp->getGem_Nombre());
		$insert->execute();
        var_dump($insert['gem_id']);
        $id = $insert['gem_id'];
        return $id;
        */
        
        $nombre =$grupo_emp->getGem_Nombre();
        $insert = $db->prepare("CALL sp_grupo_empresas_INSERT(:gem_id,@ultimoID)");
        $insert->bindParam(':gem_id', $nombre, PDO::PARAM_STR| PDO::PARAM_INPUT_OUTPUT, 45);
       		$insert->execute();
            $insert = $db->query("select @ultimoID as id;")->fetchAll();
        return $insert[0]['id'];
        
	}
        public static function update($grupo_emp){
            $db=Db::getConnect();
             $nombre =$grupo_emp->getGem_Nombre();
             $id =$grupo_emp->getGem_Id();
        $update = $db->prepare("CALL sp_grupo_empresas_UPDATE(:gem_id,:gem_nombre)");
        $update->bindParam(':gem_id', $id, PDO::PARAM_INT, 10);
        $update->bindParam(':gem_nombre', $nombre, PDO::PARAM_STR, 45);
       		$update->execute();
           
		/*$db=Db::getConnect();
		=$db->prepare('UPDATE grupo_empresas SET gem_nombre=:nombre WHERE    gem_id=:id');
			$update->bindValue('id',$grupo_emp->getGem_Id());
			$update->bindValue('nombre',$grupo_emp->getGem_Nombre());
		$update->execute();*/
	}
    public static function delete($grupo_emp_id){
		$db=Db::getConnect();
        $delete = $db->prepare("CALL sp_grupo_empresas_DELETE(:gem_id)");
        $delete->bindParam(':gem_id', $grupo_emp_id, PDO::PARAM_INT, 10);
       	$delete->execute();	 
//		$delete=$db->prepare('DELETE  FROM grupo_empresas WHERE id=:id');
//		$delete->bindValue('id',$grupo_emp_id);
//		$delete->execute();		
	}
    	public static function all(){
		$db=Db::getConnect();
		$listaEmpresas=[];

		$select=$db->query('SELECT * FROM grupo_empresas');

		foreach($select->fetchAll() as $empresa){
			$listaEmpresas[]=new Empresas( 
                 $empresa['gem_id'], $empresa['gem_nombre']);
		}
		return ($listaEmpresas);
	}
    public static function allJSON(){
		$db=Db::getConnect();
		$listaEmpresas=[];
        $tmp = 0;
		$select=$db->query('SELECT * FROM grupo_empresas');
        foreach($select->fetchAll() as $empresa){
		      $listaEmpresas[$tmp++] = ['gem_id'=>$empresa['gem_id'],'gem_nombre'=> $empresa['gem_nombre']];
        }
      return  $listaEmpresas;
	}
    public static function LastInsert_Search($id){
		$db=Db::getConnect();
		$listaEmpresas=[];
        $tmp = 0;
		$select=$db->prepare('SELECT * FROM grupo_empresas WHERE gem_id= :gem_id');
        $select->bindValue(':gem_id',$id,PDO::PARAM_STR);
        $select->execute();

        foreach($select->fetchAll() as $empresa){
		      $listaEmpresas[0] = ['gem_id'=>$empresa['gem_id'],'gem_nombre'=> $empresa['gem_nombre']];
        }
      return  $listaEmpresas;
	}
    


}

?>