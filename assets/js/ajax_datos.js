$(document).ready(function () {
  //  var isEditingClient = false;
    var GemId = 0;
    var GemNobre = "";
    var EmpId = 0;
    var EmpNombre = "";
    var isEditingGroupCompany = false;
    var isEditingClientCompany = false;
     var action_group = "";
    var action_client = "";
    //Activacion y desactivacion de botones en grupos
    BotonesGrupos(false);
    //Activacion y desactivacion de botones en clientes
    BotonesClientes(false);

    function BotonesClientes(on_off) {
        $('#btnAgregaClient').prop("disabled", on_off);
        $('#btnEditaClient').prop("disabled", !on_off);
        $('#btnBorraClient').prop("disabled", !on_off);
    }

    function BotonesGrupos(on_off) {
        $('#btnAddCompany').prop("disabled", on_off);
        $('#btnEditCompany').prop("disabled", !on_off);
        $('#btnDeleteCompany').prop("disabled", !on_off);
    }
    
    //Ambos casos distinguen la seleccion individual sin afectarse entre si o de manera colateral
    ///Seleccion de renglon con click
    $(document).on("click", "#groupCompany tr:has(td)", function (e) {

       unCLICK(this);

    });
    ///Quitar seleccion de renglon con doble click
    $(document).on("dblclick", "#groupCompany tr:has(td)", function (e) {
        DobleCLICK(this);
             
    });

    function DobleCLICK(objeto) {
       
        $(objeto).addClass("noselect");
        var tipo_tabla = $(objeto).attr('data-tabla');
        if (isEditingGroupCompany==true & $(objeto).hasClass("clrSeleccion")) {
            
            if (tipo_tabla == "Grupo") {
                $(objeto).removeClass("clrSeleccion");
                GemId = 0;
                GemNobre = "";
            isEditingGroupCompany = false;
                BotonesGrupos(false);
                        

            }
        }
        
        if (isEditingClientCompany==true & $(objeto).hasClass("clrSeleccion")) {
            $(objeto).removeClass("clrSeleccion");
            if (tipo_tabla == "Clientes") {
                EmpId = 0;
                EmpNombre = "";
                isEditingClientCompany = false;
                BotonesClientes(false);
                                      
            }
        }
    }

    function unCLICK(objeto) {
  
        $(objeto).addClass("noselect");
        var tipo_tabla = $(objeto).attr('data-tabla');
        if (isEditingGroupCompany ==false & !$(objeto).hasClass("clrSeleccion")) {
           
            if (tipo_tabla == "Grupo") {
                $(objeto).addClass("clrSeleccion");
                GemId = $(objeto).attr('data-value');
                GemNobre = $(objeto).attr('data-gnombre');
                isEditingGroupCompany = true;
                BotonesGrupos(true);
            }
        }
        
        if (isEditingClientCompany==false & !$(objeto).hasClass("clrSeleccion")) {
            if (tipo_tabla == "Clientes") {
                $(objeto).addClass("clrSeleccion");
               
                EmpId = $(objeto).attr('data-cvalue');
                
                EmpNombre = $(objeto).attr('data-cnombre');
                isEditingClientCompany = true;
                BotonesClientes(true);
                 
            }
        }
    }
    //Muestra los datos para actualizar y reestablece los valores de la parte de grupo
    $('#GrupoEmpModal').on('show.bs.modal', function (event) {
       
        var button = $(event.relatedTarget)
        var title = button.data('title')
        var type_action = button.data('type')
        $('.vacia_aviso').html('');
        action_group = type_action;
        switch (type_action) {
        case "add":
            $('#company_id').attr('disabled', 'disabled');
            $("#frmGrupos").trigger("reset");
            $('#company_group').focus();

                break;
        case "update":
            $.ajax({
                type: "GET"
                , url: '?controller=EmpresasClientes&&action=updateGroupshow&&idGroupCompany=' + GemId
                , dataType: 'json'
                , success: function (data) {
                   
                    $.each(data, function (index, ObjDatos) {
                        $('#company_id').val(ObjDatos.gem_id);
                        $('#company_group').val(ObjDatos.gem_nombre);
                    });
                    $('#company_id').attr('disabled', 'disabled');
                }
                , error: function (data) {
                    console.log('Error:', data);
                }
            });
            break;
        }
        var modal = $(this);
        modal.find('.modal-title').text(title);
    });

    
    ///Muestra el aviso del registro que eliminar, describiendo los datos que borrara para evitar confusiones 
    //funciona para grupos y empresas
    $('#GrupoElimina').on('show.bs.modal', function (event) {
       
        var button = $(event.relatedTarget)
     
        var tabla = button.data('tabla')
        var modal = $(this);
        modal.find('.modal-title').text('¿Deseas eliminar este registro?');
        switch (tabla) {
        case "Grp":
            $('#btn-elimina').attr('data-tabla', "grupo");
            $('.elimina_dato').replaceWith('<div class="elimina_dato"><h4>' + GemId + ' - ' + GemNobre + '</h4></div>');
            
            break;
        case "Emp":
            $('#btn-elimina').attr('data-tabla', "cliente");
            $('.elimina_dato').replaceWith('<div class="elimina_dato"><h4>' + EmpId + ' - ' + EmpNombre + '</h4></div>');
              

            break;
        }
         $("#btn-cancela-borrar").attr('data-frmactual',tabla);

    });
   
    $("#btn-guarda-grupo").click(function (e) {
        var id_grup = $('#company_id').val();
        var nom_grup = $('#company_group').val();
        $('.valid_msg').empty();
        if (nom_grup.trim() == '') {
            $('.val_company_group').append(aviso_valida('Ingresa el nombre del grupo','danger'));
            $("#company_group").focus();
           
            return;
        }
        
        var formData = {
            company_id: GemId
            , company_group: nom_grup
        , }
        var url_act = "?controller=EmpresasClientes&&action=";
        if (action_group == "update") {
            url_act += "updateGroup";
        }
        else {
            url_act += "saveGroup";
        }
        var grupos_emp = '';
        $.ajax({
            type: "POST"
            , url: url_act
            , data: formData
            , dataType: 'json'
            , success: function (data) {
                $.each(data, function (index, ObjDatos) {
                    grupos_emp += '<tr id="grupo' + ObjDatos.gem_id + '" data-tabla="Grupo" data-value="' + ObjDatos.gem_id + '" data-gnombre="' + ObjDatos.gem_nombre + '" class="noselect" >';
                    grupos_emp += '<td>' + ObjDatos.gem_id + '</td>';
                    grupos_emp += '<td>' + ObjDatos.gem_nombre + '</td>';
                    grupos_emp += '</tr>';
                });
                if (action_group == "add") { 
                    $('#groupCompany').append(grupos_emp);
                    $('#aviso_grupo').append(
                          aviso_valida('Se añadio el grupo ' + nom_grup ,'success')
                        );
                    $('#GrupoEmpModal').modal('hide');
                    isEditingGroupCompany=false;
                   
                }
                else {
                    $("#grupo" + GemId).replaceWith(grupos_emp);
                    
                       $('#aviso_grupo').append(  aviso_valida('El registro ' + GemId + ' fue actualizado a ' + nom_grup ,'success'));
                   
                    isEditingGroupCompany = false;
                    BotonesGrupos(false);
                    $('#GrupoEmpModal').modal('hide');
                 
                }
            }
            , error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
    //Quita la seleccion de grupo al presionar el boton del modal de edicion y grupo
    $("#btn-cancela-grupo").click(function (e) {
        $("#groupCompany tr:has(td)").dblclick();
    });
    //Quita la seleccion de empresas al presionar el boton del modal de edicion y registro
    $("#btn-cancela-empresa").click(function (e) {
        $("#Clients tr:has(td)").dblclick();
    });
    //Quita la seleccion de ambas partes al presionar cancelar del modal borrar
    //distinguiendo si es grupo y empresas
    $("#btn-cancela-borrar").click(function (e) {
        
        if($(this).attr('data-frmactual')=="Grp"){
        $("#groupCompany tr:has(td)").dblclick();
        }
         if($(this).attr('data-frmactual')=="Emp"){
                    $("#Clients tr:has(td)").dblclick();

        }
    });
    //Boton para eliminar en ambas tablas
    $("#btn-elimina").click(function (event) {
        var button = $(event.relatedTarget);
        var id = $(this).attr('data-id');
        
        var tipo = $(this).attr('data-tabla');
        var formData_edu = {
          
            id_dato: tipo == "grupo" ? GemId : EmpId
        , }
        var url_act = "?controller=EmpresasClientes&&action=";
        switch (tipo) {
        case "grupo":
            var nombre = $(this).attr('data-gnombre')
            url_act += "deleteGroup";
            break;
        case "cliente":
            var nombre = $(this).attr('data-cnombre')
            url_act += "deleteClient";
            break;
        }
        $.ajax({
            type: "POST"
            , url: url_act 
                
            , data: formData_edu
            , success: function (data) {
                var id = tipo == "grupo" ? GemId : EmpId;
                $("#" + tipo + id).remove();
                $('#GrupoElimina').modal('hide');
                
                if (tipo == "grupo") {
               $('#aviso_grupo').append(aviso_valida('El grupo ' + GemNobre  + ' fue eliminado','success'));
                     isEditingGroupCompany=false; 
                    BotonesGrupos(false);
                }
                if (tipo == "cliente") {
                    $('#aviso_cliente').append(
                        aviso_valida('El cliente ' + EmpNombre  + ' fue eliminado','success'));
                                         isEditingClientCompany=false; 

                    BotonesClientes(false);
                }
                                  

       }
            , error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    //CLIENTES
    $(document).on("click", "#Clients tr:has(td)", function (e) {
      unCLICK(this);
    });
    $(document).on("dblclick", "#Clients tr:has(td)", function (e) {
       DobleCLICK(this) ;
    });
    
    ///Limpiar advertencias al escribir
    $('.limpia_aviso').each(function () {
        $(this).on('keypress', function (ev) {
            var input_cli = $(this).attr('id');
       
            //                if($("#"+input_cli).val().trim()==''){
            //                   var campo= $("#"+input_cli).attr('data-campo');
            //                    $('.val_'+input_cli).empty();
            //                   $('.val_'+input_cli).append(aviso_valida('Ingresa '+campo));
            //            }
            //                else{
            $('.val_' + input_cli).empty();
            //        }
        });
    });

    function aviso_valida(texto,tipo_alerta) {
        var Aviso = '<div class="alert alert-'+tipo_alerta+'" role="alert">  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>  <span class="sr-only">Error:</span> ' + texto + '</div>';
        return Aviso;
    }
    $("#btn-guarda-empresa").click(function (e) {
      
                $('.vacia_aviso').html('');

        var nombre = $('#client_nombre').val();
        var direccion = $('#client_direccion').val();
        var colonia = $('#client_colonia').val();
        var ciudad = $('#client_ciudad').val();
        var cp = $('#client_cp').val();
        var telefono = $('#client_telefono').val();
        var estado = $('#client_estado').val();
        var pais = $('#client_pais').val();
        var rfc = $('#client_rfc').val();
        var grupo_id = $('#client_grupo').val();
        if (nombre.trim() == '') {
            $('.val_client_nombre').append(aviso_valida('Ingresa el nombre de la empresa','danger'));
            $("#client_nombre").focus();
            return;
        }
        if (direccion.trim() == '') {
            $('.val_client_direccion').append(aviso_valida('Ingresa la Dirección','danger'));
            $("#client_direccion").focus();
            return;
        }
        if (colonia.trim() == '') {
            $('.val_client_colonia').append(aviso_valida('Ingresa el nombre de la colonia','danger'));
            $("#client_colonia").focus();
            return;
        }
        if (ciudad.trim() == '') {
            $('.val_client_ciudad').append(aviso_valida('Ingresa el nombre de la ciudad','danger'));
            $("#client_ciudad").focus();
            return;
        }
        if (cp.trim() == '') {
            $('.val_client_cp').append(aviso_valida('Ingresa el Codigo Postal','danger'));
            $("#client_cp").focus();
            return;
        }
        if (telefono.trim() == '') {
            $('.val_client_telefono').append(aviso_valida('Ingresa el Telefono 012-3456789','danger'));
            $("#client_telefono").focus();
            return;
        }
        if (estado.trim() == '') {
            $('.val_client_estado').append(aviso_valida('Ingresa el Estado','danger'));
            $("#client_estado").focus();
            return;
        }
        if (pais.trim() == '') {
            $('.val_client_pais').append(aviso_valida('Ingresa el Pais','danger'));
            $("#client_pais").focus();
            return;
        }
        if (rfc.trim() == '') {
            $('.val_client_rfc').append(aviso_valida('Ingresa el RFC','danger'));
            $("#client_rfc").focus();
            return;
        }
        if (ValidaCP(cp.trim()) == '') {
            $('.val_client_cp').append(aviso_valida('Ingresa un Código Postal válido','danger'));
            $("#client_cp").focus();
            return;
        }
        
        ///La validacion de formato es inestable
//        if(!ValidaRFC(rfc.trim())){
//            $('.val_client_rfc').append(aviso_valida('Formato de RFC Invalido Eje: VECJ880326XXX','danger'));
//            $("#client_rfc").focus();
//            return;
//        }
      
     
        var formData = {
            client_id: EmpId
            , client_nombre: nombre
            , client_direccion: direccion
            , client_colonia: colonia
            , client_ciudad: ciudad
            , client_cp: cp
            , client_telefono: telefono
            , client_estado: estado
            , client_pais: pais
            , client_rfc: rfc
            , client_grupo: grupo_id
        , }
        var url_act = "?controller=EmpresasClientes&&action=";
        if (action_client == "update") {
            url_act += "updateClient";
        }
        else {
            url_act += "saveClient";
        }
        
        var grupos_emp = '';
        $.ajax({
            type: "POST"
            , url: url_act
            , data: formData
            , dataType: 'json'
            , success: function (data) {
                
                $.each(data, function (index, ObjDatos) {
                    grupos_emp += '<tr id="cliente' + ObjDatos.cli_id + '" data-tabla="Clientes" data-cvalue="' + ObjDatos.cli_id + '" data-cnombre="' + ObjDatos.cli_nombre + '" class="noselect" >';
                    grupos_emp += '<td>' + ObjDatos.cli_id + '</td>';
                    grupos_emp += '<td>' + ObjDatos.cli_nombre + '</td>';
                    grupos_emp += '<td>' + ObjDatos.cli_direccion + '</td>';
                    grupos_emp += '<td>' + ObjDatos.cli_colonia + '</td>';
                    grupos_emp += '<td>' + ObjDatos.cli_ciudad + '</td>';
                    grupos_emp += '<td>' + ObjDatos.cli_cp + '</td>';
                    grupos_emp += '<td>' + ObjDatos.cli_telefono + '</td>';
                    grupos_emp += '<td>' + ObjDatos.cli_estado + '</td>';
                    grupos_emp += '<td>' + ObjDatos.cli_pais + '</td>';
                    grupos_emp += '<td>' + ObjDatos.cli_rfc + '</td>';
                    grupos_emp += '<td>' + ObjDatos.cli_nombre_grupo + '</td>';
                    grupos_emp += '</tr>';
                });
                if (action_client == "add") { //if user added a new record
                    $('#Clients').append(grupos_emp);
                   
                     $('#aviso_cliente').append( aviso_valida('El cliente ' + EmpNombre  + ' fue agregado exitosamente','success'));
       $('#ClienteEmpModal').modal('hide');
                                        isEditingClientCompany = false;

                }
                else { 
                    $("#cliente" + EmpId).replaceWith(grupos_emp);
                  
                    $('#aviso_cliente').append(aviso_valida('El registro ' + EmpId + ' fue actualizado a ' + EmpNombre  ,'success'));
                    BotonesClientes(false);
                             isEditingClientCompany = false;

                    $('#ClienteEmpModal').modal('hide');
                 
                }
            }
            , error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
    _rfc_pattern_pm = "^(([A-ZÑ&]{3})([0-9]{2})([0][13578]|[1][02])(([0][1-9]|[12][\\d])|[3][01])([A-Z0-9]{3}))|" +
                  "(([A-ZÑ&]{3})([0-9]{2})([0][13456789]|[1][012])(([0][1-9]|[12][\\d])|[3][0])([A-Z0-9]{3}))|" +
                  "(([A-ZÑ&]{3})([02468][048]|[13579][26])[0][2]([0][1-9]|[12][\\d])([A-Z0-9]{3}))|" +
                  "(([A-ZÑ&]{3})([0-9]{2})[0][2]([0][1-9]|[1][0-9]|[2][0-8])([A-Z0-9]{3}))$";
 // patron del RFC, persona fisica
 _rfc_pattern_pf = "^(([A-ZÑ&]{4})([0-9]{2})([0][13578]|[1][02])(([0][1-9]|[12][\\d])|[3][01])([A-Z0-9]{3}))|" +
                       "(([A-ZÑ&]{4})([0-9]{2})([0][13456789]|[1][012])(([0][1-9]|[12][\\d])|[3][0])([A-Z0-9]{3}))|" +
                       "(([A-ZÑ&]{4})([02468][048]|[13579][26])[0][2]([0][1-9]|[12][\\d])([A-Z0-9]{3}))|" +
                       "(([A-ZÑ&]{4})([0-9]{2})[0][2]([0][1-9]|[1][0-9]|[2][0-8])([A-Z0-9]{3}))$";

function ValidaRFC(campo_RFC){
    var rfc = campo_RFC;
    if (rfc.match(_rfc_pattern_pm) || rfc.match(_rfc_pattern_pf)){
            return true;
        }else {
            return false;
        }
}
    
    function ValidaCP(str)
{
 regexp = /^[0-9]{5}$/;
  
        if (regexp.test(str))
          {
            return true;
          }
        else
          {
            return false;
          }
}

    $('#ClienteEmpModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var title = button.data('title')
        var type_action = button.data('type')
        
        $('.vacia_aviso').html('');
        action_client = type_action;
        $('#client_grupo').empty();
        
        $.ajax({
            type: "GET"
            , url: "?controller=EmpresasClientes&&action=ListGroup"
            , dataType: 'json'
            , success: function (data) {
             
                $.each(data, function (index, ObjDatos) {
                    clients += '   <option value="' + ObjDatos.gem_id + '" >' + ObjDatos.gem_nombre + '</option>';
                });
                $('#client_grupo').append(clients);
            }
            , error: function (data) {
                console.log('Error:', data);
            }
        });
        switch (type_action) {
        case "add":
            $('#client_id').attr('disabled', 'disabled');
            $('#client_id').val('0');
            $('#client_nombre').focus();
            $("#frmClientes").trigger("reset");
            break;
        case "update":
                            $("#frmClientes").trigger("reset");

                
            var clients;
            $.ajax({
                type: "GET"
                , url: '?controller=EmpresasClientes&&action=updateClientshow&&idClient=' + EmpId
                , dataType: 'json'
                , success: function (data) {
                    $.each(data, function (index, ObjDatos) {

                        $('#client_id').val(ObjDatos.cli_id);
                        $('#client_nombre').val(ObjDatos.cli_nombre);
                        $('#client_direccion').val(ObjDatos.cli_direccion);
                        $('#client_colonia').val(ObjDatos.cli_colonia);
                        $('#client_ciudad').val(ObjDatos.cli_ciudad);
                        $('#client_cp').val(ObjDatos.cli_cp);
                        $('#client_telefono').val(ObjDatos.cli_telefono);
                        $('#client_estado').val(ObjDatos.cli_estado);
                        $('#client_pais').val(ObjDatos.cli_pais);
                        $('#client_rfc').val(ObjDatos.cli_rfc);
                        $('#client_grupo').val(ObjDatos.cli_grupo_cliente);
                        
                    });
                    $('#client_id').attr('disabled', 'disabled');
                }
                , error: function (data) {
                    console.log('Error:', data);
                }
            });
            break;
        }
        var modal = $(this);
        modal.find('.modal-title').text(title);
    });
    $(document).ajaxSuccess(function () {
        setTimeout(function () {
            $('#aviso_grupo').empty();
            $('#aviso_cliente').empty();
        }, 2000);
    });
});