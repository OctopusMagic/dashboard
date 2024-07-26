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
})