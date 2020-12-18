var tabla;

//Función que se ejecuta al inicio
function init() {
    limpiar();
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function(e) // si se hace click en el boton guardar se llamara a la funcion guardaryeditar
        {
            guardaryeditar(e);
        })

    //Cargamos los items al select categoria
    $.post("../ajax/articulo.php?op=selectCategoria", function(r) {
        $("#idcategoria").html(r);
        $('#idcategoria').selectpicker('refresh');

    });
    $("#imagenmuestra").hide();
}

//Función limpiar
function limpiar() {
    $("#codigo").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
    $("#stock").val("");
    $("#medida").val("");
    $("#presentacion").val("");
    $("#tipotela").val("");
    $("#imagenmuestra").attr("src", "");
    $("#imagenactual").val("");
    $("#print").hide();
    $("#idarticulo").val("");
}

//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
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
            url: '../ajax/articulo.php?op=listar', //enviamos al archivo articulo.php  mediante el metodo get a la variable op el valor listar
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 7, //Paginación
        "order": [
                [0, "desc"]
            ] //Ordenar (columna,orden)
    }).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/articulo.php?op=guardaryeditar", //se indica a donde se va a enviar todos los valores de todo el formulario
        type: "POST", // del tipo post
        data: formData, // los datos que se estan obteniendo es desde la variable formdata que obtiene todos los datos del formulario
        contentType: false,
        processData: false,

        success: function(datos) {
            bootbox.alert(datos); // el botbox es para dar forma al mensaje de alerta          
            mostrarform(false);
            tabla.ajax.reload(); // se recarga los datos de la tabla
        }

    });
    limpiar();
}

function mostrar(idarticulo) {
    $.post("../ajax/articulo.php?op=mostrar", { idarticulo: idarticulo }, function(data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        $("#idcategoria").val(data.idcategoria);
        $('#idcategoria').selectpicker('refresh');
        $("#codigo").val(data.codigo);
        $("#nombre").val(data.nombre);
        $("#stock").val(data.stock);
        $("#medida").val(data.medida);
        $("#medida").selectpicker('refresh');
        $("#presentacion").val(data.presentacion);
        $("#descripcion").val(data.descripcion);
        $("#imagenmuestra").show();
        $("#imagenmuestra").attr("src", "../files/articulos/" + data.imagen);
        $("#imagenactual").val(data.imagen);
        $("#idarticulo").val(data.idarticulo);
        generarbarcode();

    })
}

//Función para desactivar registros
function desactivar(idarticulo) {
    bootbox.confirm("¿Está Seguro de desactivar el artículo?", function(result) {
        if (result) {
            $.post("../ajax/articulo.php?op=desactivar", { idarticulo: idarticulo }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

//Función para activar registros
function activar(idarticulo) {
    bootbox.confirm("¿Está Seguro de activar el Artículo?", function(result) {
        if (result) {
            $.post("../ajax/articulo.php?op=activar", { idarticulo: idarticulo }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

//función para generar el código de barras
function generarbarcode() {
    codigo = $("#codigo").val();
    JsBarcode("#barcode", codigo);
    $("#print").show();
}

//Función para imprimir el Código de barras
function imprimir() {
    $("#print").printArea();
}

init();