$(document).ready(function(){  
    $("input:text:visible:first").focus();

    $("#texto").keyup(function() {
        var texto = $("#texto").val().toLowerCase();
        var patron = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s,.]+$/;
        if(texto != "" && !patron.test(texto)){
            $("#error_texto").addClass("mostrar");
        }else{
            $("#error_texto").removeClass("mostrar")
        }
        });
});
