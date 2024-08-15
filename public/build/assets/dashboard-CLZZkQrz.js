$(function(){$("#reenviarContingencia").on("click",function(){$("#reenviarContingencia").addClass("disabled"),$("#loadingOverlay").removeClass("d-none"),$.ajax({url:"/send-contingency",method:"POST",success:function(e){let a="",t="success";e.message?(a=e.message,t=e.status):(a+="<p><b>DTEs Enviados:</b></p>",a+="<table>",e.forEach(n=>{a+=`
                            <tr>
                                <td>${n.codGeneracion}</td>
                                <td>${n.estado}</td>
                            </tr>
                        `}),a+="</table>"),Swal.fire({icon:t,html:a,confirmButtonText:"Aceptar"}).then(n=>{window.location.reload()})}})}),$("#reconciliarDBF").on("click",function(){Swal.fire({title:"Reconciliar DBF",html:`
                ¿Está seguro que desea reconciliar los DTEs?<br>
                Actualizará los DTEs en el DBF, y si faltara uno, lo agregará<br>
                <strong>LOS DTE AGREGADOS NO LLEVAN SERIE, DEBERÁ AGREGAR LA SERIE MANUALMENTE</strong><br><br>
                Ingrese contraseña de Reconcialiación:
            `,icon:"warning",input:"password",showCancelButton:!0,confirmButtonText:"Reconciliar",cancelButtonText:"Cancelar",preConfirm:async e=>{if(e==""&&Swal.showValidationMessage("Debe ingresar una contraseña"),e!="Recon$2024")Swal.showValidationMessage("Contraseña incorrecta");else return(await fetch("http://localhost:8000/contingencia/reconciliar")).json()},allowOutsideClick:()=>!Swal.isLoading()}).then(e=>{e.value&&Swal.fire({icon:e.value.status,text:e.value.message,confirmButtonText:"Aceptar"}).then(a=>{window.location.reload()})})})});
