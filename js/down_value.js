
function registrar_punto(){

  var numero_punto = $("#indice_puntos").val();
  var nombre_punto = $("#nombre_punto").val();
  var proteger = document.getElementById("proteger").checked;

  if(proteger == true){ proteger=1} else{proteger=0};

  $.ajax({
     url: "../consejo_tecnico/conexiones/subir_sustrato.php",
     data: {"nombre":nombre_punto, "numero":numero_punto, "proteger":proteger},
     type: "post",
      success: function(data){
         document.getElementById("add_punto").innerHTML = '<div class="row" style="width:80%; margin:auto;"><div class="col-xs-5"><img src="imagenes/success.png" style="width:100px; height:auto;"/></div><div class="col-xs-7"><br><center><p style="font-size: 1.2em;">Punto <span style="color: #0B3B0B"><b>'+nombre_punto+'</b></span> Registrado Correctamente</p><input type="button" class="btn btn-warning" value="Agregar Sustrato" onclick="show_addsubc()">';
         document.getElementById("add_punto").style.background ="#BCF5A9";
         document.getElementById("add_punto").style.heigth = "110px;"
         document.getElementById("subtitulo1").style.display = 'none';
        // document.getElementById("addp-btn").style.display = "block";

      }
    });
}

function registrar_archivo(){
  //Envía el tipo de funcion a través de un input, y se manda mediante todo el paquete del formulario ;)
  var formData = new FormData(document.getElementById("frm_addfile"));
  var carpeta = $("#carp_selec").val();
  var func = 'addFiles';

  formData.append('carpeta', carpeta);

  $.ajax({
      url: "../consejo_tecnico/conexiones/subir_archivo.php",
      data: formData,
      type: "post",
      contentType: false,
      processData: false,
      success: function(data){
        //alert(data);
        //Añadir de nuevo el formulario, para borrar los valores anteriores.
        //document.getElementById("add_archivo").innerHTML = '<form method="post" id="frm_addfile" enctype="multipart/form-data"><table id="tarchivos" width="90%;"><tr><td><b>Elegir Archivos: </b></td><td><input type="file" class="file" id="file_archivo" name="file_archivo[]" multiple="true"></td><td><input type="button" class="btn btn-info" value="Subir" onclick="registrar_archivo()"/></td></tr></table></form>';
        //document.getElementById("menu_files").innerHTML += data; //mostrar los archivos añadidos.
        //$("#menu_files").fadeIn(3000); //mostrar algo en 3segundos.
        showFilesViewer();
      }
    });

  //showAddFil();

}

function registrar_subcarp(){

  var nombre_carpeta = $("#nombre_subcarp").val();
  alert(nombre_carpeta);
  var func = 1;
  var idPadre = $("#carp_selec").val();

  //Envío del tipo de funcion directamente mediante esta variable.

  $.ajax({
     url: "../consejo_tecnico/conexiones/subir_archivo.php",
     data: {"nomCarpeta":nombre_carpeta, "funcion": func, "idPadre":idPadre},
     type: "post",
      success: function(data){
        //alert(data);
        showFilesViewer();
      }
    });

    //showAddSub();

}

function selec_carp(id_carpeta){
  //Esta función recibe el id de carpeta que se ha seleccionado
  document.getElementById("carp_selec").value = id_carpeta;
  showFilesViewer();
}

function selec_padre(){
  //funcion que selecciona el padre de la carpeta en uso y lo manda
  //al botón indicador

  var func = 0;
  var carpeta = $("#carp_selec").val();

  $.ajax({
     url: "../consejo_tecnico/conexiones/subir_archivo.php",
     data: {"funcion":func, "carpeta":carpeta},
     type: "post",
      success: function(data){
          document.getElementById("carp_selec").value = data;
          showFilesViewer();

      }
    });

}

function update_file(){
  eleccion=confirm("¿Estás seguro de que quieres reemplazar el archivo?");
  if(eleccion){
    alert("Archivo reemplazado");
  }
}

function update_folder(){
  eleccion=confirm("¿Estás seguro de que quieres cambiar el nombre de la carpeta?");
  if(eleccion){
    alert("Nombre de carpeta modificado");
  }
}

function delete_folder(){
  eleccion=confirm("Al borrar esta carpeta también se eliminará su contenido.\n¿Seguro de que quieres continuar?");
  if(eleccion){
    alert("Carpeta y contenido eliminados");
  }
}

function delete_file(){
  eleccion=confirm("¿Estás seguro de que quieres eliminar el archivo?");
  if(eleccion){
    alert("Archivo eliminado");
  }
}
