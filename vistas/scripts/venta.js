var tabla;

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    });
    //Cargamos los items al select proveedor
    $.post("../ajax/venta.php?op=selectCliente", function(r) {
        $("#idcliente").html(r);
        $('#idcliente').selectpicker('refresh');
    });
}

//Función limpiar
function limpiar() {
    $("#idcliente").val("");
    $("#cliente").val("");
    $("#serie_comprobante").val("");
    $("#num_comprobante").val("");
    $("#guia_remi").val("");
    $("#impuesto").val("0");
    $("#nroorden").val("");
    $("#obra").val("");
    $("#total_venta").val("");
    $(".filas").remove();
    $("#total").html("0");
    $("#tipo_cambio").val("");
    $("#total_soles").val("");


    //Obtenemos la fecha actual
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    $('#fecha_emision').val(today);

    //Marcamos el primer tipo_documento
    $("#tipo_comprobante").val("Boleta");
    $("#tipo_comprobante").selectpicker('refresh');
}


//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        //$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
        listarArticulos();

        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").show();
        detalles = 0;
    } else {
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
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/venta.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 5, //Paginación
        "order": [
                [0, "desc"]
            ] //Ordenar (columna,orden)
    }).DataTable();
}

//Función ListarArticulos
function listarArticulos() {
    tabla = $('#tblarticulos').dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        buttons: [

        ],
        "ajax": {
            url: '../ajax/venta.php?op=listarArticulosVenta',
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 5, //Paginación
        "order": [
                [0, "desc"]
            ] //Ordenar (columna,orden)
    }).DataTable();
}

//Función para guardar o editar
function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/venta.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            bootbox.alert(datos);
            enviarsunat();
        }

    });
}

function enviarsunat(serie, numero) {
    console.log('envia sunat');
    var serie = $("#serie_comprobante").val();
    var numero = $("#num_comprobante").val();
    console.log(serie + ' - ' + numero);
    $.ajax({
        url: "../modelos/venta-graba.php",
        type: "post",
        dataType: 'json',
        data: JSON.stringify({ "serie": serie, "numero": numero }),
        success: function(datos) {
            console.log(datos);
            bootbox.alert(datos.mensaje);
            mostrarform(false);
            listar();
        },
        error: function(data) {
            console.log(data);
            alert('Error Al conectar la Base Datos');
            //console.log(data);
        }
    });
    limpiar();
}


function mostrar(idventa) {
    $.post("../ajax/venta.php?op=mostrar", { idventa: idventa }, function(data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        cargarDetalle(idventa);
        $("#idcliente").val(data.idcliente);
        $("#idcliente").selectpicker('refresh');
        $("#condicionv").val(data.condicionv);
        $("#condicionv").selectpicker('refresh');
        $("#tipo_comprobante").val(data.tipo_comprobante);
        $("#tipo_comprobante").selectpicker('refresh');
        $("#moneda").val(data.moneda);
        $("#moneda").selectpicker('refresh');
        $("#serie_comprobante").val(data.serie_comprobante);
        $("#num_comprobante").val(data.num_comprobante);
        $("#guia_remi").val(data.guia_remi);
        $("#fecha_emision").val(data.emision);
        $("#fecha_vencimiento").val(data.vencimiento);
        $("#impuesto").val(data.impuesto);
        $("#nroorden").val(data.nroorden);
        $("#obra").val(data.obra);
        $("#idventa").val(data.idventa);
        $("#tipo_cambio").val(data.tipo_cambio);
        $("#total_soles").val(data.total_soles);

        //Ocultar y mostrar los botones
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").hide();
    });
}

function cargarDetalle(idventa) {
    $.post("../ajax/venta.php?op=listarDetalle&id=" + idventa, function(r) {
        $("#detalles").html(r);
    });
}

//Función para anular registros
function anular(idventa) {
    bootbox.confirm("¿Está Seguro de anular la venta?", function(result) {
        if (result) {
            $.post("../ajax/venta.php?op=anular", { idventa: idventa }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}


var tipo_cambio = 3;


//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto = 18;
var cont = 0;
var detalles = 0;
//$("#guardar").hide();
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto() {
    var tipo_comprobante = $("#tipo_comprobante option:selected").text();
    if (tipo_comprobante == 'Factura') {
        $("#impuesto").val(impuesto);
    } else {
        $("#impuesto").val("0");
    }
    selectMaxId(tipo_comprobante);
}

function agregarDetalle(idarticulo, articulo, precio_venta, stock) {
    var cantidad = 1;
    var descuento = 0;


    if (articulo != "") {

        var subtotal = cantidad * precio_venta;

        var fila = '<tr class="filas" id="fila' + cont + '">' +
            '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ')">X</button></td>' +
            '<td><input type="hidden" name="idarticulo[]" value="' + idarticulo + '">' + articulo + '</td>' +
            '<td><input type="decimal number" name="cantidad[]" id="cantidad[]" value="' + cantidad + '"></td>' +
            '<td><input type="decimal number" name="precio_venta[]" id="precio_venta[]" value="' + precio_venta + '"></td>' +
            '<td><input type="decimal number" name="descuento[]" value="' + descuento + '"></td>' +
            '<td><input type="decimal number" readonly="readonly" name="stock[]" value="' + stock + '"></td>' +
            '<td><span name="subtotal" id="subtotal' + cont + '">' + subtotal + '</span></td>' +
            '<td><button type="button" onclick="modificarSubototales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>';
        '</tr>'

        cont++;
        detalles = detalles + 1;
        $('#detalles').append(fila);
        modificarSubototales();

    } else {

        alert("Revisar estado de producto");
    }
}

function nostock() {
    alert("Sin stock ");
}

function modificarSubototales(e) {
    var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_venta[]");
    var desc = document.getElementsByName("descuento[]");
    var sub = document.getElementsByName("subtotal");
    var stoc = document.getElementsByName("stock[]");

    for (var i = 0; i < cant.length; i++) {
        var inpC = cant[i];
        var inpP = prec[i];
        var inpD = desc[i];
        var inpS = sub[i];
        var inpSt = stoc[i];


        var subtl = inpS.value = (inpC.value * inpP.value) - inpD.value;
        var subfinal = subtl.toFixed(2);

        if (inpC.value > inpSt.value) {

            alert("NO CUENTA CON STOCK SUFICIENTE, REALIZAR COMPRAS O INGRESO DE PRODUCTOS");
            inpC.style.backgroundColor = "#00CC00";
            inpSt.style.backgroundColor = "#CC0000";
            $("#btnGuardar").hide();
            e.preventDefault();

        } else {

            inpC.style.backgroundColor = "#FFFFFF";
            inpSt.style.backgroundColor = "#FFFFFF";

            document.getElementsByName("subtotal")[i].innerHTML = subfinal;
        }

    }
    calcularTotales();
    calcularSoles();
}


function calcularTotales() {
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
    } else {
        $("#total").html("S/:" + total);
    }


    $("#total_venta").val(total);
    evaluar();

}



function evaluar() {
    if (detalles > 0) {
        $("#btnGuardar").show();
    } else {
        $("#btnGuardar").hide();
        cont = 0;
    }
}

function eliminarDetalle(indice) {
    $("#fila" + indice).remove();
    calcularTotales();
    detalles = detalles - 1;
    evaluar()
}

function selectMaxId(tipo_comprobante) {
    //Cargamos correlativo maximo
    $.post("../ajax/venta.php?op=selectMaxId", { tipo_comprobante: tipo_comprobante }, function(data, status) {
        data = JSON.parse(data);
        $("#num_comprobante").val(data.num_comprobante);
        $('#num_comprobante').selectpicker('refresh');
    });
}
init();