var tabla;

//Función que se ejecuta al inicio
function init(){
	listar();
	//Cargamos los items al select cliente
	$.post("../ajax/venta.php?op=selectArticulo", function(r){
	            $("#idarticulo").html(r);
	            $('#idarticulo').selectpicker('refresh');
	});
}


//Función Listar
function listar()
{
	var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();
	var idarticulo = $("#idarticulo").val();

	tabla=$('#tbllistado').dataTable(
	{
		"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            //convirtiendo a interger para encontrar total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            //Columna de computación Total del resultado completo
            var cantTotal = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            //Actualizar pie de página mostrando el total con la referencia del índice de columna
			$( api.column( 4 ).footer() ).html('Total del Período:');
            $( api.column( 5 ).footer() ).html(cantTotal);
        }, 

		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            { extend: 'copyHtml5', footer: true },
            		{ extend: 'excelHtml5', footer: true },
            		{ extend: 'csvHtml5', footer: true },
            		{ extend: 'pdfHtml5',orientation: 'landscape',pageSize: 'A4', footer: true }
		        ],
		"ajax":
				{
					url: '../ajax/consultas.php?op=ventasfechaarticulo',
					data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin, idarticulo: idarticulo},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	});//.DataTable();
	//calcularTotales();
}

//Función Listar todos
function listartodo()
{
	var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();
	//var idarticulo = $("#idarticulo").val();

	tabla=$('#tbllistado').dataTable(
	{
		"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            //convirtiendo a interger para encontrar total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            //Columna de computación Total del resultado completo
            var cantTotal = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            //Actualizar pie de página mostrando el total con la referencia del índice de columna
			$( api.column( 4 ).footer() ).html('Total del Período:');
            $( api.column( 5 ).footer() ).html(cantTotal);
        }, 

		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            { extend: 'copyHtml5', footer: true },
            		{ extend: 'excelHtml5', footer: true },
            		{ extend: 'csvHtml5', footer: true },
            		{ extend: 'pdfHtml5',orientation: 'landscape',pageSize: 'A4', footer: true }
		        ],
		"ajax":
				{
					url: '../ajax/consultas.php?op=ventasfechaarticulotodos',
					data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	});//.DataTable();
	//calcularTotales();
}


  function calcularTotales(){
  	var sub = document.getElementsByName("cantidad");
  	var total = 0;

  	for (var i = 0; i <sub.length; i++) {
		total += document.getElementsByName("cantidad")[i].value;
	}
	$("#total").html(total).val(total);
    $("#total_venta").val(total);
    evaluar();
  }


init();