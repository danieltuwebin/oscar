var tabla;

//Función que se ejecuta al inicio
function init() {
	limpiar();
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});

	//Cargamos los items al select proveedor
	$.post("../ajax/conversion.php?op=selectArticulo", function (r) {
		$("#idarticuloC").html(r);
		$('#idarticuloC').selectpicker('refresh');
	});

}

//Función limpiar
function limpiar() {
	$("#idproduccion").val("");
	$("#condicionp").val("");
	$("#moneda").val("");
	$("#nomb_produccion").val("");
	$("#num_prod").val("");
	$("#ipu_produccion").val("");
	$("#total_produccion").val("");

	$(".filas").remove();


	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear() + "-" + (month) + "-" + (day);
	$('#fecha_produccion').val(today);


}

//Función mostrar formulario
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide(); //se creara un div en el html x eso creamos listadoregistros
		$("#formularioregistros").show();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		listarArticulosConversion();

		$("#btnGuardar").hide();

		$("#btnCancelar").show();
		detalles = 0;
		$("#btnAgregarArt").show();

	}
	else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform() {
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar() {
	tabla = $('#tbllistado').dataTable(
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
				url: '../ajax/conversion.php?op=listar',
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 5,//Paginación
			"order": [[0, "desc"]]//Ordenar (columna,orden)
		}).DataTable();
}


//Función ListarArticulos
function listarArticulosConversion() {
	tabla = $('#tblarticulos').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [

			],
			"ajax":
			{
				url: '../ajax/conversion.php?op=listarArticulosConversion',
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 5,//Paginación
			"order": [[0, "desc"]]//Ordenar (columna,orden)
		}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/conversion.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			bootbox.alert(datos);
			mostrarform(false);
			listar();
		}

	});
	limpiar();
}

function mostrar(idproduccion) {
	$.post("../ajax/produccion.php?op=mostrar", { idproduccion: idproduccion }, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);

		$("#condicionp").val(data.condicionp);
		$("#moneda").val(data.moneda);
		$("#nomb_produccion").val(data.nomb_produccion);
		$("#num_prod").val(data.num_prod);
		$("#fecha_produccion").val(data.fecha);
		$("#ipu_produccion").val(data.ipu_produccion);
		$("#total_produccion").val(data.total_produccion);

		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
	});

	$.post("../ajax/produccion.php?op=listarDetalle&id=" + idproduccion, function (r) {
		$("#detalles").html(r);
	});
}

//Función para anular registros
function anular(idproduccion) {
	bootbox.confirm("¿Está Seguro de anular la produccion?", function (result) {
		if (result) {
			$.post("../ajax/produccion.php?op=anular", { idproduccion: idproduccion }, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

//Declaración de variables necesarias para trabajar con las compras y
//sus detalles

var cont = 0;
var detalles = 0;
//$("#guardar").hide();
$("#btnGuardar").hide();

function agregarDetalle(idarticulo, articulo, medida, precio_venta) {
	console.log(idarticulo, articulo, medida, precio_venta);
	console.log("test");
	var cantidad = 1;

	if (articulo != "") {

		var subtotal = cantidad * precio_venta;
		var fila = '<tr class="filas" id="fila' + cont + '">' +
			'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ')">X</button></td>' +
			'<td><input type="hidden" name="idarticulo[]" value="' + idarticulo + '">' + articulo + '</td>' +
			'<td><input type="hidden" name="medida[]" value="' + medida + '">' + medida + '</td>' +
			'<td><input type="decimal number" name="cantidad[]" id="cantidad[]" value="' + cantidad + '"></td>';
		'</tr>'

		cont++;
		detalles = detalles + 1;
		$("#btnGuardar").show();
		$('#detalles').append(fila);
		//modificarSubototales();


	}
	else {

		alert("Revisar estado de producto");
	}
}



function modificarSubototales() {
	var cant = document.getElementsByName("cantidad[]");
	var prec = document.getElementsByName("precio_venta[]");
	var sub = document.getElementsByName("subtotal");

	for (var i = 0; i < cant.length; i++) {
		var inpC = cant[i];
		var inpP = prec[i];
		var inpS = sub[i];

		inpS.value = inpC.value * inpP.value;
		document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
	}
	calcularTotal();

}

function calcularTotal() {
	var sub = document.getElementsByName("subtotal");
	var total1 = 0.0;

	for (var i = 0; i < sub.length; i++) {
		total1 += document.getElementsByName("subtotal")[i].value;
		console.log(total1);
	}
	var total = total1.toFixed(2);

	var moneda = $("#moneda option:selected").text();
	if (moneda == 'Dolares') {
		$("#total").html("US$: " + total);
	}
	else {
		$("#total").html("S/: " + total);
	}


	$("#total_venta").val(total);
	$("#total_produccion").val(total);
	evaluar();

}

function evaluar() {
	if (detalles > 0) {
		$("#btnGuardar").show();
	}
	else {
		$("#btnGuardar").hide();
		cont = 0;
	}
}

function eliminarDetalle(indice) {
	$("#fila" + indice).remove();
	calcularTotal();
	detalles = detalles - 1;
	evaluar()
}

init();