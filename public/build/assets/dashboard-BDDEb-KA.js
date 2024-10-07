$(function(){$("#reenviarContingencia").on("click",function(){$("#reenviarContingencia").addClass("disabled"),$("#loadingOverlay").removeClass("d-none"),$.ajax({url:"/send-contingency",method:"POST",success:function(a){let e="",n="success";a.message?(e=a.message,n=a.status):(e+="<p><b>DTEs Enviados:</b></p>",e+="<table>",a.forEach(t=>{e+=`
                            <tr>
                                <td>${t.codGeneracion}</td>
                                <td>${t.estado}</td>
                            </tr>
                        `}),e+="</table>"),Swal.fire({icon:n,html:e,confirmButtonText:"Aceptar"}).then(t=>{window.location.reload()})}})}),$("#reconciliarDBF").on("click",function(){Swal.fire({title:"Reconciliar DBF",html:`
                ¿Está seguro que desea reconciliar los DTEs?<br>
                Actualizará los DTEs en el DBF, y si faltara uno, lo agregará<br>
                <strong>LOS DTE AGREGADOS NO LLEVAN SERIE, DEBERÁ AGREGAR LA SERIE MANUALMENTE</strong><br><br>
                Ingrese fecha de Reconciliación:<br>
                <input type="date" id="fechaReconciliacion" class="swal2-input"><br>
                Ingrese contraseña de Reconciliación:
                <input type="password" id="passwordReconciliacion" class="swal2-input">
            `,icon:"warning",showCancelButton:!0,confirmButtonText:"Reconciliar",cancelButtonText:"Cancelar",preConfirm:async()=>{let a=$("#fechaReconciliacion").val(),e=$("#passwordReconciliacion").val();if((e==""||a=="")&&Swal.showValidationMessage("Debe ingresar una fecha y una contraseña"),e!="Recon$2024")Swal.showValidationMessage("Contraseña incorrecta");else return(await fetch("http://localhost:8000/contingencia/reconciliar?fecha="+a)).json()},allowOutsideClick:()=>!Swal.isLoading()}).then(a=>{a.value&&Swal.fire({icon:a.value.status,text:a.value.message,confirmButtonText:"Aceptar"}).then(e=>{window.location.reload()})})}),$("#activarContingencia").on("click",function(){Swal.fire({title:"Activar Contingencia",html:`
                ¿Está seguro que desea activar la contingencia?<br>
                NO se enviará ningún DTE a Hacienda<br><br>
                Ingrese contraseña de Activación:
            `,icon:"warning",input:"password",showCancelButton:!0,confirmButtonText:"Activar",cancelButtonText:"Cancelar",preConfirm:async a=>{if(a==""&&Swal.showValidationMessage("Debe ingresar una contraseña"),a!="Activa$2024")Swal.showValidationMessage("Contraseña incorrecta");else return(await fetch("http://localhost:8000/contingencia/activar")).json()},allowOutsideClick:()=>!Swal.isLoading()}).then(a=>{a.value&&Swal.fire({icon:a.value.status,text:a.value.message,confirmButtonText:"Aceptar"}).then(e=>{window.location.reload()})})}),$("#desactivarContingencia").on("click",function(){Swal.fire({title:"Desactivar Contingencia",html:`
                ¿Está seguro que desea desactivar la contingencia?<br>
                Se enviarán los DTEs a Hacienda<br><br>
                Ingrese contraseña de Desactivación:
            `,icon:"warning",input:"password",showCancelButton:!0,confirmButtonText:"Desactivar",cancelButtonText:"Cancelar",preConfirm:async a=>{if(a==""&&Swal.showValidationMessage("Debe ingresar una contraseña"),a!="Desact$2024")Swal.showValidationMessage("Contraseña incorrecta");else return(await fetch("http://localhost:8000/contingencia/desactivar")).json()},allowOutsideClick:()=>!Swal.isLoading()}).then(a=>{a.value&&Swal.fire({icon:a.value.status,text:a.value.message,confirmButtonText:"Aceptar"}).then(e=>{window.location.reload()})})})});
