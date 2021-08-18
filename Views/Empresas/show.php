
    <div class="container" style="padding-top: 20px;">
        <!--Bootstrap Basic Table using .table class-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary clearfix">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title pull-left panel-header-button" >Grupo de Empresas</h4>
                        <div class=" pull-right">
                            <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#GrupoEmpModal" id="btnAddCompany" data-title="Agregar Nuevo Grupo" data-type="add"  data-backdrop="static" data-keyboard="false"> <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Agregar</button>
                            <button type="button" class="btn btn-warning " data-toggle="modal" data-target="#GrupoEmpModal" id="btnEditCompany" data-title="Editar Nombre del Grupo" data-type="update" data-backdrop="static" data-keyboard="false" disabled> <span class=" glyphicon glyphicon-pencil "  aria-hidden="true"></span> Modificar</button>
                            <button type="button" class="btn btn-danger " data-toggle="modal" data-target="#GrupoElimina" data-group="" data-type="delete" id="btnDeleteCompany" data-backdrop="static" data-keyboard="false" data-idgroup="" data-tabla="Grp" data-type="del" data-nombre="" data-backdrop="static" data-keyboard="false" disabled> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Eliminar</button>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div id="aviso_grupo"> </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre del Grupo</th>
                                    </tr>
                                </thead>
                                <tbody id="groupCompany">
                                    <?php foreach ($listaEmpresas as $empresas) {?>
                                        <tr data-value="<?php echo ''.$empresas->getGem_Id(); ?>" data-gnombre="<?php echo ''.$empresas->getGem_Nombre(); ?>" data-tabla="Grupo" id="grupo<?php echo $empresas->getGem_Id(); ?>" class="noselect">
                                            <td>
                                                <?php echo $empresas->getGem_Id(); ?>
                                            </td>
                                            <td>
                                                <?php echo $empresas->getGem_Nombre(); ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title pull-left panel-header-button">Empresas</h4>
                        <div class=" pull-right">
                            <button type="button" class="btn btn-primary " id="btnAgregaClient" data-toggle="modal" data-target="#ClienteEmpModal" id="btnAddCompany" data-title="Agregar Nueva Empresa" data-type="add" data-backdrop="static" data-keyboard="false"> <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Agregar</button>
                            <button type="button" class="btn btn-warning " id="btnEditaClient" data-toggle="modal" data-target="#ClienteEmpModal" data-title="Editar Datos de Empresa" data-type="update" data-backdrop="static" data-keyboard="false" disabled> <span class=" glyphicon glyphicon-pencil " aria-hidden="true"></span> Modificar</button>
                            <button type="button" class="btn btn-danger " id="btnBorraClient" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#GrupoElimina" data-group="" data-type="del" data-tabla="Emp" disabled> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Eliminar</button>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div id="aviso_cliente"> </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre de la Empresa</th>
                                            <th>Dirección</th>
                                            <th>Colonia</th>
                                            <th>Ciudad</th>
                                            <th>C.P.</th>
                                            <th>Telefono</th>
                                            <th>Estado</th>
                                            <th>País</th>
                                            <th>RFC</th>
                                            <th>Grupo Empresa</th>
                                        </tr>
                                    </thead>
                                    <tbody id="Clients">
                                        <?php foreach ($listaClientes as $clientes) {?>
                                            <tr data-tabla="Clientes" data-cvalue="<?php echo $clientes->getId(); ?>" data-cnombre="<?php echo $clientes->getNombre(); ?>" id="cliente<?php echo $clientes->getId(); ?>" class="noselect">
                                                <td>
                                                    <?php echo $clientes->getId(); ?>
                                                </td>
                                                <td>
                                                    <?php echo $clientes->getNombre(); ?>
                                                </td>
                                                <td>
                                                    <?php echo $clientes->getDireccion(); ?>
                                                </td>
                                                <td>
                                                    <?php echo $clientes->getColonia(); ?>
                                                </td>
                                                <td>
                                                    <?php echo $clientes->getCiudad(); ?>
                                                </td>
                                                <td>
                                                    <?php echo $clientes->getCp(); ?>
                                                </td>
                                                <td>
                                                    <?php echo $clientes->getTelefono(); ?>
                                                </td>
                                                <td>
                                                    <?php echo $clientes->getEstado(); ?>
                                                </td>
                                                <td>
                                                    <?php echo $clientes->getPais(); ?>
                                                </td>
                                                <td>
                                                    <?php echo $clientes->getRFC(); ?>
                                                </td>
                                                <td>
                                                    <?php echo $clientes->getNombreGrupoEmp(); ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="GrupoEmpModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  
                    <h4 class="modal-title" id="ModalLabel"></h4> </div>
                <form id="frmGrupos">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="company_id" class="control-label">Id:</label>
                            <input type="text" class="form-control" id="company_id" name="company_id" value="0"> </div>
                        <div class="form-group has-feedback">
                            <label for="company_group" class="control-label">Nombre del Grupo:</label>
                            <input type="text" class="form-control limpia_aviso" id="company_group" name="company_group"  placeholder="Escribe el nombre del Grupo" required>
                            <div class="val_company_group vacia_aviso"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-guarda-grupo" value="add" data-id_company="0"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Guardar</button>
                        <button type="button" id="btn-cancela-grupo" class="btn btn-danger" data-dismiss="modal"> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ClienteEmpModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  
                    <h4 class="modal-title" id="ModalLabel"></h4> </div>
                <form id="frmClientes">
                    <div class="modal-body">
                        <div class="valid_msg_cli"></div>
                        <div class="form-group has-feedback">
                            <label for="client_id" class="control-label">Id:</label>
                            <input type="text" class="form-control" id="client_id" name="client_id" value="0"> </div>
                        <div class="form-group has-feedback">
                            <label for="client_nombre" class="control-label">Nombre de la Empresa:</label>
                            <input type="text" class="form-control limpia_aviso" id="client_nombre" name="client_nombre" placeholder="Escribe el nombre de la Empresa">
                            <div class="val_client_nombre vacia_aviso"></div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="client_direccion" class="control-label">Dirección:</label>
                            <input type="text" class="form-control limpia_aviso" id="client_direccion" name="client_direccion" placeholder="Escribe la Dirección">
                            <div class="val_client_direccion vacia_aviso"></div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="client_colonia" class="control-label">Colonia:</label>
                            <input type="text" class="form-control limpia_aviso" id="client_colonia" name="client_colonia" placeholder="Escibe la Colonia">
                            <div class="val_client_colonia vacia_aviso"></div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="client_ciudad" class="control-label">Ciudad:</label>
                            <input type="text" class="form-control limpia_aviso" id="client_ciudad" name="client_ciudad" placeholder="Escribe la Ciudad">
                            <div class="val_client_ciudad vacia_aviso"></div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="client_cp" class="control-label">Código Postal:</label>
                            <input type="text" class="form-control limpia_aviso" id="client_cp" name="client_cp" placeholder="Escribe el Código Postal" maxlength="5">
                            <div class="val_client_cp vacia_aviso"></div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="client_telefono" class="control-label">Teléfono:</label>
                            <input type="text" class="form-control limpia_aviso" id="client_telefono" name="client_telefono" placeholder="Escibe el Teléfono" maxlength="12">
                            <div class="val_client_telefono vacia_aviso" ></div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="client_estado" class="control-label">Estado:</label>
                            <input type="text" class="form-control limpia_aviso" id="client_estado" name="client_estado" placeholder="Escribe el Estado">
                            <div class="val_client_estado vacia_aviso"></div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="client_pais" class="control-label">País:</label>
                            <input type="text" class="form-control limpia_aviso" id="client_pais" name="client_pais" placeholder="Escribe el País">
                            <div class="val_client_pais vacia_aviso"></div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="client_rfc" class="control-label">RFC:</label>
                            <input type="text" class="form-control limpia_aviso" id="client_rfc" name="client_rfc" placeholder="Escribe el RFC" maxlength="13">
                            <div class="val_client_rfc vacia_aviso"></div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="client_grupo" class="control-label">Grupo:</label>
                            <select id="client_grupo" name="client_grupo" class="form-control"> </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary " id="btn-guarda-empresa"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Guardar</button>
                        <button type="button"  id ="btn-cancela-empresa" class="btn btn-danger" data-dismiss="modal"> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="GrupoElimina" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                
                    <h4 class="modal-title">Eliminar</h4> </div>
                <div class="modal-body">
                    <h5 class="elimina_dato">
                
                </h5> </div>
                <div class="modal-footer">
                    <button type="button" id="btn-cancela-borrar" class="btn btn-default " data-dismiss="modal" data-frmactual="">Cancelar</button>
                    <button type="button" id="btn-elimina" class="btn btn-danger" data-id="0" data-tabla="" >Ok </button>
                </div>
            </div>
        </div>
    </div>
    <div id="MsgAviso" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="aviso"> </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/ajax_datos.js"></script>
