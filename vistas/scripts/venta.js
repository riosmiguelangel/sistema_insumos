var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	//Cargamos los items al select cliente
	$.post("../ajax/venta.php?op=selectCliente", function(r){
	            $("#idcliente").html(r);
	            $('#idcliente').selectpicker('refresh');
		});	
	//Cargamos los items al select agente
	$.post("../ajax/venta.php?op=selectAgente", function(r){
	            $("#idagente").html(r);
	            $('#idagente').selectpicker('refresh');
	});	

}

//Función limpiar
function limpiar()
{
	$("#idcliente").val("");
	$("#cliente").val("");
	$("#serie_comprobante").val("002");
	$("#num_comprobante").val("");
	$("#impuesto").val("0");

	$("#total_venta").val("");
	$(".filas").remove();
	$("#total").html("0");

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_hora').val(today);

    //Marcamos el primer tipo_documento
    $("#tipo_comprobante").val("Boleta");
	$("#tipo_comprobante").selectpicker('refresh');
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	//numRemito();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		//$("#btnGuardar").prop("disabled",false);
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
					url: '../ajax/venta.php?op=listar',
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
					url: '../ajax/venta.php?op=listarArticulosVenta',
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
	//verificarStock();
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	
	$.ajax({
		url: "../ajax/venta.php?op=guardaryeditar",
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

function mostrar(idventa)
{
	$.post("../ajax/venta.php?op=mostrar",{idventa : idventa}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(false);

		$("#idcliente").val(ucwords(data.idcliente));
		$("#idcliente").selectpicker('refresh');
		$("#tipo_comprobante").val(data.tipo_comprobante);
		$("#tipo_comprobante").selectpicker('refresh');
		$("#serie_comprobante").val(data.serie_comprobante);
		$("#num_comprobante").val(data.num_comprobante);
		$("#fecha_hora").val(data.fecha);
		$("#impuesto").val(data.impuesto);
		$("#idventa").val(data.idventa);
		console.log(data);
		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
 	});

 	$.post("../ajax/venta.php?op=listarDetalle&id="+idventa,function(r){
	        $("#detallesentrega").html(r);
	});	
	 	
}

//Función para anular registros
function anular(idventa)
{
	bootbox.confirm("¿Está Seguro de anular la venta?", function(result){
		if(result)
        {
        	$.post("../ajax/venta.php?op=anular", {idventa : idventa}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto=18;
var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto()
  {
  	var tipo_comprobante=$("#tipo_comprobante option:selected").text();
  	if (tipo_comprobante=='Factura')
    {
        $("#impuesto").val(impuesto); 
    }
    else
    {
        $("#impuesto").val("0"); 
    }
  }

function agregarDetalle(idarticulo,articulo,idcategoria,categoria,stock,precio_venta)
  {
  	var cantidad = 1;
    var descuento=0;

    if (idarticulo!="")
    {
    	var subtotal=cantidad;
    	var fila='<tr class="filas" id="fila'+idarticulo+'">'+
    	'<td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td>'+
    	'<td><input type="hidden" name="idcategoria[]" value="'+categoria+'">'+categoria+'</td>'+
    	'<td><input type="number" name="cantidad[]" id="cantidad" value="'+cantidad+'"></td>'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+idarticulo+')">X</button></td>'+
    	'<td><input type="hidden" readonly name="stock" id="stock[]" value="'+stock+'"></td>'+
    	'</tr>';
    	cont++;
    	detalles=detalles+1;
    	$('#detalles').append(fila);
    	//detalles=detalles+1;
    	//modificarSubototales();

    	verificarStock();
    	evaluar();
		//cierro la ventana modal
    	$(document).ready(function(){
    		$('#agregarDetalle'+idarticulo).attr("disabled", true);
	    
	    	$("#myModal").modal("hide");

	    });
    }
    else
    {
    	alert("Error al ingresar el detalle, revisar los datos del artículo");
    }
  }

  function modificarSubototales()
  {
  	var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_venta[]");
    var desc = document.getElementsByName("descuento[]");
    var sub = document.getElementsByName("subtotal");

    for (var i = 0; i <cant.length; i++) {
    	var inpC=cant[i];
    	var inpP=prec[i];
    	var inpD=desc[i];
    	var inpS=sub[i];

    	inpS.value=(inpC.value * inpP.value)-inpD.value;
    	document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
    }
    calcularTotales();

  }

  function calcularTotales(){
  	var sub = document.getElementsByName("cantidad");
  	var total = 0;

  	for (var i = 0; i <sub.length; i++) {
		total += document.getElementsByName("cantidad")[i].value;
	}
	$("#total").html(total);
    $("#total_venta").val(total);
    evaluar();
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

	$("#myModal").ready(function(){

	    $('#agregarDetalle'+indice).attr("disabled", false);

	});
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar();
  }

function verificarStock(){
$(document).ready(function(){
	$('input[id=cantidad]').change(function(){
		if (($('input[id=cantidad]').val())<=0) {
			alert("Ingrese un valor valido");
			$("#btnGuardar").hide();
		}
		else if(parseInt($('input[id=cantidad]').val())>(parseInt($('input[name=stock]').val()))) {	
				alert("No hay stock suficiente");
				$("#btnGuardar").hide();
			}else{
				$("#btnGuardar").show();
			}
		});
  });
}

 function alertaStock(){
	 window.open(ingreso.php); return false;
 	alert("No hay stock de este articulo!!!")
 }


function numRemito(){
    $.ajax({
    url:'../ajax/venta.php?op=numRemito',
    type:'get',
    dataType:'JSON',
    success:function(reg){
      $("#num_comprobante").val(reg);
      $("#num_comprobante1").html(reg);
    }
    
  });  
  }
 
init();