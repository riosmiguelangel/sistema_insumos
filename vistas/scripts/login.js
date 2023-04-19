$("#frmAcceso").on('submit',function(e)
{
	e.preventDefault();
    logina=$("#logina").val();
    clavea=$("#clavea").val();

    $.post("../ajax/usuario.php?op=verificar",
        {"logina":logina,"clavea":clavea},
        function(data)
        {
            if (data!="null")
            {
                if (clavea=="abc123") {
                    alert("Debe cambiar la clave");
                    //llamo a la funcion para pasar los parametros
                    pasarlogin();

                    //$(location).attr("href","rlogin.php");
                }else{

                $(location).attr("href","venta.php");   
                }
             }
            else
            {
                bootbox.alert("Usuario y/o Password incorrectos");
            }
    });

        function pasarlogin(){
          logina=$("#logina").val();
          //Creo un formulario para pasar el dato a traves de POST a tu pagina 2
          $('<form action="rlogin.php" method="post"><input type="hidden" name="logina" value="'+logina+'" /></form>')
           .appendTo('body').submit();
        };

        function obteneremail(){
            //Cargamos los datos del administrador
            $.post("../ajax/usuario.php?op=mostraradmin", function(r){
                $("#email").html(r);
                //alert(email);
            }); 
        }

})