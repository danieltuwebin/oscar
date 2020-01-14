var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
}
//Función limpiar
function limpiar()
{
	$("#nombre").val("");
	$("#idpermiso").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	//limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").hide();
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
					url: '../ajax/permiso.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/permiso.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}
//Funcion mostrar
function mostrar(idpermiso)
{
	$.post("../ajax/permiso.php?op=mostrar",{idpermiso : idpermiso}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#nombre").val(data.nombre);
 		$("#idpermiso").val(data.idpermiso);

 	})
}
//Función para eliminar registros
function eliminar(idpermiso)
{
    bootbox.confirm("¿Está Seguro de eliminar el permiso?", function(result){
        if(result)
        {
            $.post("../ajax/permiso.php?op=eliminar", {idpermiso : idpermiso}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })
}


init();