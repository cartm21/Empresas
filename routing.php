
<?php 
 
$controllers=array(
	'EmpresasClientes'=>['index','register','saveClient','updateClient','deleteClient','updateClientshow','saveGroup','ListGroup','show','updateGroupshow','updateGroup','deleteGroup','search','error']
    
);
 
if (array_key_exists($controller,  $controllers)) {
	if (in_array($action, $controllers[$controller])) {
		call($controller, $action);
	}
	else{
		call('EmpresasClientes','error');
	}		
}else{
	call('EmpresasClientes','error');
}
 
function call($controller, $action){
	require_once('Controllers/'.$controller.'Controller.php');
 
	switch ($controller) {
		case 'EmpresasClientes':
	require_once('Model/Clientes.php');
	require_once('Model/Empresas.php');
		$controller= new EmpresasClientesController();
		break;			
		default:
				# code...
		break;
	}
	$controller->{$action}();
}
 
?>