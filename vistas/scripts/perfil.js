var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)	{
		guardaryeditar(e);	
	});

}



//Función limpiar
function limpiar()
{
	$("#txtID_CLIENTE").val("");
	$("#cliente").val("");
	$("#txtID_TIPO_DOCUMENTO").val("");
	$("#txtSERIE").val("");
	$("#txtNUMERO").val("")
	$("#txtTIPO_DOCUMENTO_CLIENTE").val("");
	$("#txtOBSERVACION").val("");
	$("#txtSUB_TOTALL").val("");
	$("#txtIGV").val("");
	$("#txtTOTAL").val("");
	$("#txtID_MONEDA").val("");
	$("#txtID_TIPO_DOCUMENTO_MODIFICA").val("");
	$("#txtNRO_DOC_MODIFICA").val("");
	$("#txtID_MOTIVO").val("");
	$(".filas").remove();
	$("#total").html("0");

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#txtFECHA_DOCUMENTO').val(today);

    //Marcamos el primer tipo_documento
    $("#txtID_TIPO_DOCUMENTO").val("Boleta");
	$("#txtID_TIPO_DOCUMENTO").selectpicker('refresh');
}

//Función mostrar formulario
function mostrarform(flag){
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").show();
		$("#btnCancelar").show();
		$("#btnGuardar").prop("disabled",false);
		detalles=0;
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnGuardar").hide();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/perfil.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}



function mostrar(id){

$.post("../ajax/perfil.php?op=mostrar",{id: id}, function(data, status)	{
	console.log(data);
data = JSON.parse(data);		
		mostrarform(true);
	$("#id").val(data.id);
		$("#rsocial").val(data.razon_social);
		$("#ncomercial").val(data.nombre_comercial);
		$("#ruc").val(data.ruc);
	$("#dir").val(data.direccion);
	$("#departamento").val(data.departamento);
 	$("#provincia").val(data.provincia);
	$("#distrito").val(data.distrito);
	$("#codpais").val(data.codpais);
	$("#ubigeo").val(data.ubigeo);
	$("#fono").val(data.telefono);
	$("#usuario").val(data.usuario);
	$("#clave").val(data.clave);
	$("#firma").val(data.firma);
	$("#correo").val(data.correo);
	
 	});

}

function activar(id){

$.ajax({
		url: "../ajax/perfil.php?op=activar",
	    type: "POST",
	    data: {id: id},
	    success: function(datos){                    
console.log(datos);	alert(datos.mensaje); listar();
	    }

	});

	
}


function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/perfil.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,
	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          listar();
	    }

	});
	limpiar();
}



init();