var tabla;
var ArrayIdTelas = [];

//Función que se ejecuta al inicio
function init() {
    limpiar();
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    });

    //Cargamos los items al select producto
    $.post("../ajax/produccion.php?op=selectArticulo", function(r) {
        $("#idarticuloC").html(r);
        console.log(r);
        $('#idarticuloC').selectpicker('refresh');
    });

    //listarArticulosInsumosTelas();

}

//Función limpiar
function limpiar() {
    $("#idproduccion").val("");
    $("#condicionp").val("");
    $("#moneda").val("");
    $("#nomb_produccion").val("");
    $("#medida_ancho").val("");
    $("#medida_alto").val("");
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

//Función mostrar formulario - Boton Agregar
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide(); //se creara un div en el html x eso creamos listadoregistros - oculta el div contenedr de la tabla
        $("#formularioregistros").show();
        //$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
        //listarArticulosProduccion();

        $("#btnGuardar").hide();

        $("#btnCancelar").show();
        detalles = 0;
        $("#btnAgregarArt").show();

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
            url: '../ajax/produccion.php?op=listar',
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
function listarArticulosProduccion_x_idconvertidos() {
    var formData = new FormData($("#formulario")[0]);
    //console.log(formData);

    $.ajax({
        url: "../ajax/produccion.php?op=listarArticulosProduccion_x_idconvertidos",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            //console.log(datos);
            if (datos != "") {
                $("#detalles").html(datos);
                detalles = 1;
                console.log(detalles);
            }
            modificarSubototales()
        }
    });
}


//Función para guardar o editar

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);
    console.log(formData);

    $.ajax({
        url: "../ajax/produccion.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            console.log(datos);
            bootbox.alert(datos);
            mostrarform(false);
            listar();
        }

    });
    limpiar();
}

function mostrar(idproduccion) {
    $.post("../ajax/produccion.php?op=mostrar", { idproduccion: idproduccion }, function(data, status) {
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

    $.post("../ajax/produccion.php?op=listarDetalle&id=" + idproduccion, function(r) {
        $("#detalles").html(r);
    });
}

//Función para anular registros
function anular(idproduccion) {
    bootbox.confirm("¿Está Seguro de anular la produccion?", function(result) {
        if (result) {
            $.post("../ajax/produccion.php?op=anular", { idproduccion: idproduccion }, function(e) {
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
$("#btnGuardar").hide();

function agregarDetalle(idarticulo, articulo, precio_venta) {
    var cantidad = 1;
    if (articulo != "") {
        var subtotal = cantidad * precio_venta;
        var fila = '<tr class="filas" id="fila' + cont + '">' +
            '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ')">X</button></td>' +
            '<td><input type="hidden" name="idarticulo[]" value="' + idarticulo + '">' + articulo + '</td>' +
            '<td><input type="decimal number" name="cantidad[]" id="cantidad[]" value="' + cantidad + '"></td>' +
            '<td><input type="decimal number" name="precio_venta[]" id="precio_venta[]" value="' + precio_venta + '"></td>' +
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

function modificarSubototales() {
    var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_venta[]");
    var sub = document.getElementsByName("subtotal");
    var id = document.getElementsByName("idarticulo[]");
    var ttela = document.getElementsByName("tdtipotela");
    for (var i = 0; i < cant.length; i++) {
        var inpC = cant[i];
        var inpP = prec[i];
        var inpS = sub[i];
        var inpi = id[i];
        console.log(inpi);
        inpS.value = inpC.value * inpP.value;
        document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
    }
    calcularTotal();
}

function modificarSubototales_ConCalculodeTela() {
    var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_venta[]");
    var sub = document.getElementsByName("subtotal");
    var id = document.getElementsByName("idarticulo[]");
    var ttela = document.getElementsByName("tdtipotela");

    for (var i = 0; i < cant.length; i++) {
        var inpC = cant[i];
        var inpP = prec[i];
        var inpS = sub[i];
        var inpi = id[i];
        console.log(inpi);

        if (ttela[i].innerText != '0') {
            var medidaancho = $("#medida_ancho").val();
            var medidaalto = $("#medida_alto").val();
            var tipotel = ttela[i].innerText;
            document.getElementsByName("cantidad[]")[i].value = CalcularInsumoTela(medidaancho, medidaalto, tipotel);
        }

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
    } else {
        $("#total").html("S/: " + total);
    }


    $("#total_venta").val(total);
    $("#total_produccion").val(total);
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
    calcularTotal();
    detalles = detalles - 1;
    evaluar()
}

$("#idarticuloC").change(function() {
    $("#idproduccion").val(this.value);
    //alert(this.value);
    $("#nomb_produccion").val($('select[name="idarticuloC"] option:selected').text());
    console.log('--- ' + $('select[name="idarticuloC"] option:selected').text());
    listarArticulosProduccion_x_idconvertidos();
});


$("#btnCalcular").click(function() {

    if ($("#medida_ancho").val() == "" || $("#medida_alto").val() == "") {
        alert('falta ingresar la medidad del ancho o el alto de la ventana');
        return false;
    }

    //function resultado(){
    var filas = $("#detalles").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste
    var resultado = "";
    for (i = 0; i < filas.length; i++) { //Recorre las filas 1 a 1
        var celdas = $(filas[i]).find("td"); //devolverá las celdas de una fila
        var codigo = $(celdas[0]).text();
        var tipotela = $(celdas[1]).text();
        var descripcion = $(celdas[2]).text();
        //costo_base = $($(celdas[2]).children("input")[0]).val();
        //margen_compra = $($(celdas[3]).children("input")[0]).val();
        //impuesto = $($(celdas[4]).children("input")[0]).val();

        resultado += codigo + " - " + tipotela + " - " + descripcion + "\n";
        //resultado += codigo + " - " + descripcion + " - " + costo_base + " - " + margen_compra + " - " + impuesto + "\n";
    }

    //alert(resultado)
    modificarSubototales_ConCalculodeTela();


});


// Calculo de Tela necesaria
function CalcularInsumoTela(ancho, alto, tipotela) {
    // tipo 1 --> 1.5 --- tipo 2 --> mayor a 1.5  
    var MedAnchoEntero = 0
    var MedDiferencia = 0
    var MedFinal = 0
    var Cantidadpanios = 0;
    // Establecer valores
    MedAnchoEntero = Math.floor(ancho);
    MedDiferencia = ancho - MedAnchoEntero;
    //Redondea Medida de ancho
    if (MedDiferencia > 0 && MedDiferencia <= 0.4) {
        MedFinal = MedAnchoEntero + 0.5;
    } else if (MedDiferencia > 0.5 && MedDiferencia <= 0.9) {
        MedFinal = MedAnchoEntero + 1;
    } else {
        MedFinal = ancho;
    }
    // Formula
    if (tipotela == 1) {
        Cantidadpanios = ((MedFinal / 0.5) * (parseFloat(alto) + 0.5));
    } else if (tipotela == 2) {
        Cantidadpanios = ((MedFinal / 0.5) * parseFloat(alto));
    }
    //Devuelve valor
    return Cantidadpanios;
}


function listarArticulosInsumosTelas() {

    $.ajax({
        url: "../ajax/produccion.php?op=listarArticulosInsumosTelas",
        type: "POST",
        dataType: "json",
        //data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            console.log(datos);
            var json = JSON.parse(datos);
            console.log(json);
            $.each(json.data, function(i, item) {
                //console.log(item);
                //console.log(item.value);
                console.log(item.idarticulo);
                ArrayIdTelas.push(item.idarticulo);
            });
            console.log(ArrayIdTelas);
        }

    });

}


init();