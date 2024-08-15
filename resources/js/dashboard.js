$(function(){
    $("#reenviarContingencia").on("click", function(){
        $("#reenviarContingencia").addClass("disabled")
        $("#loadingOverlay").removeClass("d-none")
        $.ajax({
            url: "/send-contingency",
            method: "POST",
            success: function(response){
                let message = ""
                let status = "success"
                if(response.message){
                    message = response.message
                    status = response.status
                }else{
                    message += "<p><b>DTEs Enviados:</b></p>";
                    message += "<table>"
                    response.forEach((element) => {
                        message +=`
                            <tr>
                                <td>${element.codGeneracion}</td>
                                <td>${element.estado}</td>
                            </tr>
                        `
                    })
                    message += "</table>"
                }
                Swal.fire({
                    icon: status,
                    html: message,
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    window.location.reload()
                })
            }
        })
    })

    $("#reconciliarDBF").on("click", function(){
        Swal.fire({
            title: "Reconciliar DBF",
            html:  `
                ¿Está seguro que desea reconciliar los DTEs?<br>
                Actualizará los DTEs en el DBF, y si faltara uno, lo agregará<br>
                <strong>LOS DTE AGREGADOS NO LLEVAN SERIE, DEBERÁ AGREGAR LA SERIE MANUALMENTE</strong><br><br>
                Ingrese contraseña de Reconcialiación:
            `,
            icon: "warning",
            input: "password",
            showCancelButton: true,
            confirmButtonText: "Reconciliar",
            cancelButtonText: "Cancelar",
            preConfirm: async (password) => {
                if(password == ""){
                    Swal.showValidationMessage("Debe ingresar una contraseña")
                }
                if(password != "Recon$2024") {
                    Swal.showValidationMessage("Contraseña incorrecta")
                } else {
                    const response = await fetch("http://localhost:8000/contingencia/reconciliar")
                    return response.json()
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if(result.value){
                Swal.fire({
                    icon: result.value.status,
                    text: result.value.message,
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    window.location.reload()
                })
            }
        })
    })
})