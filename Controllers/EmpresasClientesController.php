<?php 
/**
* 
*/
class EmpresasClientesController
{
	
	function __construct()
	{
		
	}

	function index(){
        
		require_once('/index.php');
	}

	function saveClient(){
		$grupo= new  Clientes(NULL, $_POST['client_nombre'], $_POST['client_direccion'], $_POST['client_colonia'], $_POST['client_ciudad'], $_POST['client_cp'], $_POST['client_telefono'], $_POST['client_estado'], $_POST['client_pais'], $_POST['client_rfc'],$_POST['client_grupo'],NULL);
		$lastID = Clientes::save($grupo);
		$registro_insert = Clientes::LastInsert_Search($lastID);
        echo json_encode($registro_insert);
	}
    function updateClient(){
        $id=$_POST['client_id'];
		$grupo= new  Clientes($id, $_POST['client_nombre'], $_POST['client_direccion'], $_POST['client_colonia'], $_POST['client_ciudad'], $_POST['client_cp'], $_POST['client_telefono'], $_POST['client_estado'], $_POST['client_pais'], $_POST['client_rfc'],$_POST['client_grupo'],'vacio');
		 Clientes::update($grupo);
		$registro_insert = Clientes::LastInsert_Search($id);
        echo json_encode($registro_insert);
	}
    function updateClientshow(){
		$id=$_GET['idClient'];
		$registro_insert = Clientes::LastInsert_Search($id);
        echo json_encode($registro_insert);
	}
    function deleteClient(){
        var_dump($_POST['id_dato']);
		$id=$_POST['id_dato'];
		Clientes::delete($id);
                echo json_encode('aviso');

	}
    
    

	function saveGroup(){
		$grupo= new Empresas(null, $_POST['company_group']);
		$lastID = Empresas::save($grupo);
		$registro_insert = Empresas::LastInsert_Search($lastID);
        echo json_encode($registro_insert);
	}
    function ListGroup(){
		$DataJSON=Empresas::allJSON();
      
       echo json_encode($DataJSON);

	}

	function show(){
		$listaClientes=Clientes::all();
		$listaEmpresas=Empresas::all();

		require_once('Views/Empresas/show.php');
	}

	function updateGroupshow(){
		$id=$_GET['idGroupCompany'];
		$registro_insert = Empresas::LastInsert_Search($id);
        echo json_encode($registro_insert);
	}

	function updateGroup(){
       $id =$_POST['company_id'];
		$grupo = new Empresas($id,$_POST['company_group']);
		Empresas::update($grupo);
		$registro_insert = Empresas::LastInsert_Search($id);
        echo json_encode($registro_insert);

	}
	function deleteGroup(){
		$id=$_POST['id_dato'];
		Empresas::delete($id);
                echo json_encode('aviso');

	}
    

	function search(){
		if (!empty($_POST['id'])) {
			$id=$_POST['id'];
			$alumno=Alumno::searchById($id);
			$listaAlumnos[]=$alumno;
			//var_dump($id);
			//die();
			require_once('Views/Alumno/show.php');
		} else {
			$listaAlumnos=Alumno::all();

			require_once('Views/Alumno/show.php');
		}
		
		
	}

	function error(){
		require_once('Views/Empresas/error.php');
	}

}

?>