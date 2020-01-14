var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	//Cargamos los items al select proveedor
	$.post("../ajax/guia.php?op=selectCliente", function(r){
	            $("#idcliente").html(r);
	            $('#idcliente').selectpicker('refresh');
	});	
}

//Función limpiar
function limpiar()
{
	$("#idcliente").val("");
	$("#cliente").val("");
	$("#num_guia").val("");
	$("#doc_pago").val("");
	$("#num_doc_pago").val("");
	$("#domi_partida").val("");
	$("#domi_llegada").val("");
	$("#marca_placa").val("");
	$("#certi_inscripcion").val("");
    $("#lic_conducir").val();
    $("#rason_transportista").val("");
    $("#ruc_transportista").val();
    $("#motivo_traslado").val();	
	$(".filas").remove();
	$("#peso_total").html("0.00");



	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_emision').val(today);
    $("#Fecha_traslado").val(today);

    //Marcamos el primer tipo_documento
    $("#tipo_comprobante").val("Factura");
	$("#tipo_comprobante").selectpicker('refresh');
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		listarArticulos();

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").show();
		detalles=0;
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
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
					url: '../ajax/guia.php?op=listar',
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


//Función ListarArticulos
function listarArticulos()
{
	tabla=$('#tblarticulos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		        ],
		"ajax":
				{
					url: '../ajax/guia.php?op=listarArticulos',
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
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/guia.php?op=guardaryeditar",
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

function mostrar(idguia)
{
	$.post("../ajax/guia.php?op=mostrar",{idguia : idguia}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#idcliente").val(data.idcliente);
		$("#idcliente").selectpicker('refresh');
		$("#num_guia").val(data.num_guia);
		$("#doc_pago").val(data.doc_pago);
		$("#doc_pago").selectpicker('refresh');
		$("#num_doc_pago").val(data.num_doc_pago);
		$("#domi_partida").val(data.partida);
		$("#domi_llegada").val(data.llegada);
		$("#fecha_emision").val(data.emision);
        $("#fecha_traslado").val(data.traslado);
		$("#marca_placa").val(data.marca_placa);
		$("#certi_inscripcion").val(data.certi_inscripcion);
		$("#lic_conducir").val(data.lic_conducir);
		$("#rason_transportista").val(data.rason_transportista);
		$("#ruc_transportista").val(data.ruc_transportista);
		$("#motivo_traslado").val(data.motivo_traslado);
		$("#motivo_traslado").selectpicker('refresh');
		

		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
 	});

 	$.post("../ajax/guia.php?op=listarDetalle&id="+idguia,function(r){
	        $("#detalles").html(r);
	});	
}

//Función para anular registros
function anular(idguia)
{
	bootbox.confirm("¿Está Seguro de anular la Guia?", function(result){
		if(result)
        {
        	$.post("../ajax/guia.php?op=anular", {idguia : idguia}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}
//Declaración de variables necesarias para trabajar con las compras y
//sus detalles

var cont=0;
var detalles=0;
$("#guardar").hide();
//$("#btnGuardar").hide();

function agregarDetalle(idarticulo,articulo)
  {
  	var cantidad="0";
    var peso_bulto="0";
    if (idarticulo!="")
    {
    	var peso_total=cantidad*peso_bulto;
    	var fila='<tr class="filas" id="fila'+cont+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'<td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td>'+
    	'<td><input type="number" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
    	'<td><input type="decimal" name="peso_bulto[]" id="peso_bulto[]" value="'+peso_bulto+'"></td>'+
    	'<td><span name="peso_total" id="peso_total'+cont+'">'+peso_total+'</span></td>'+
        '<td><button type="button" onclick="modificarPesototal()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>';
    	'</tr>'

    	cont++;
    	detalles=detalles+1;
    	$('#detalles').append(fila);
    	modificarPesototal();
    }
    else
    {
    	alert("Error al ingresar el detalle, revisar los datos del artículo");
    }
  }

  function modificarPesototal()
  {
  	var cant = document.getElementsByName("cantidad[]");
    var pbul = document.getElementsByName("peso_bulto[]");
    var pto = document.getElementsByName("peso_total");

    for (var i = 0; i <cant.length; i++) {
    	var inpC=cant[i];
    	var inpP=pbul[i]
    	var inpPT=pto[i];
    	
    	inpPT.value=inpC.value * inpP.value;
    	document.getElementsByName("peso_total")[i].innerHTML = inpPT.value;
    }
    calcularTotalespeso

  }
  function calcularTotalespeso(){
  	var pto = document.getElementsByName("peso_total");
  	var totalp = 0.0;

  	for (var i = 0; i <sub.length; i++) {
		totalp += document.getElementsByName("peso_total")[i].value;
	}
	/*$("#total").html("US$. " + total);
    $("#total_venta").val(total);
    evaluar();*/
  }

  function evaluar(){
  	if (detalles>0)
    {
      $("#btnGuardar").show();
    }
    else
    {
      $("#btnGuardar").hide(); 
      cont=0;
    }
  }

  function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar()
  }

init();