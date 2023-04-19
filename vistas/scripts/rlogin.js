$("#frmCambioacceso").on('submit',function(e)

{
    e.preventDefault();
    logina=$("#logina").val();
    clavea=$("#clavea").val();
    claveanew=$("#claveanew").val();

    if (clavea != claveanew ){
        alert(" !!! Los password no coinciden");
    }else
            {
                if (clavea =="abc123") {
                    alert("El password no puede ser igual a la anterior");
                 }
                else
                    {
                         $.post("../ajax/usuario.php?op=cambiarclave",
                        {"logina":logina,"clavea":claveanew});
                        $(location).attr("href","login.html");
                     }
            }
})