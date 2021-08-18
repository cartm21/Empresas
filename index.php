<?php 
	require_once('connection.php');

	if (isset($_GET['controller'])&&isset($_GET['action'])) {
		
		$controller=$_GET['controller'];
		$action=$_GET['action'];
	}else{
		$controller='EmpresasClientes';
		$action='show';
	}
if($action == 'ListGroup' | $action == 'saveGroup'| $action == 'updateGroupshow' | $action=="updateGroup"| $action=="deleteGroup" |$action == 'saveClient' |$action == 'updateClientshow'|$action == 'updateClient' |$action == 'deleteClient' )
{

    require_once('Views/Empresas/MultiJSON.php');
}
else
{	require_once('Views/Layouts/layout.php');	
}
 ?>