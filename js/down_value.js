
function registrar_punto(){

  var numero_punto = $("#indice_puntos").val(); //Contador de puntos, comienza de 0, cuando se registra se va incrementando
  var nombre_punto = $("#nombre_punto").val();
  var id_orden = $("#index_orden").val();
  var proteger = document.getElementById("proteger").checked;

  var nuevo_numero = parseInt(numero_punto) + 1; //Aumenta el contador en 1

  if(proteger == true){ proteger=1} else{proteger=0};

  $.ajax({
     url: "../consejo_tecnico/conexiones/subir_sustrato.php",
     data: {"nombre":nombre_punto, "numero":nuevo_numero, "proteger":proteger, "case":2, "orden":id_orden},
     type: "post",
      success: function(data){
        alert(data);
         document.getElementById("add_punto").innerHTML = '<div class="row" style="width:80%; margin:auto;"><div class="col-xs-5"><img src="imagenes/success.png" style="width:100px; height:auto;"/></div><div class="col-xs-7"><br><center><p style="font-size: 1.2em;">Punto <span style="color: #0B3B0B"><b>'+nombre_punto+'</b></span> Registrado Correctamente</p><input type="button" class="btn btn-warning" value="Agregar contenido" onclick="show_addCont()">';
         document.getElementById("add_punto").style.background ="#BCF5A9";
         document.getElementById("add_punto").style.heigth = "110px;"
         //document.getElementById("subtitulo1").style.display = 'none';

         document.getElementById("indice_puntos").value = nuevo_numero;
         document.getElementById("nPunto").innerHTML = nuevo_numero;
         //alert("numero: "+nuevo_numero);
         document.getElementById("nombrePunto").innerHTML = nombre_punto;        // document.getElementById("addp-btn").style.display = "block";
         document.getElementById("index_punto").value = nuevo_numero;

         showFilesViewer();
      }
    });

}

function editar_punto(){
  var numero_actual = $("#index_punto").val();

  var nuevo_numero = $("#newNumPoint").val(); //Contador de puntos, comienza de 0, cuando se registra se va incrementando
  var nombre_punto = $("#newNamePoint").val();
  var proteger = document.getElementById("newProteger").checked;

  var caso = 3; //Numero de caso 3 que es para editar punto.

  $.ajax({
     url: "../consejo_tecnico/conexiones/subir_sustrato.php",
     data: {"nombre":nombre_punto, "numero":nuevo_numero, "proteger":proteger, "numPunto": numero_actual, "caso": caso},
     type: "post",
      success: function(data){

      }
    });

}

function registrar_archivo(){
  //Envía el tipo de funcion a través de un input, y se manda mediante todo el paquete del formulario ;)
  var formData = new FormData(document.getElementById("frm_addfile"));
  var carpeta = $("#carp_selec").val();
  var func = 'addFiles';
  var orden_dia = $("#index_orden").val();
  var num_punto = $("#index_punto").val();

  //alert("punto actual: "+num_punto);

  formData.append('carpeta', carpeta);
  formData.append('punto', num_punto);
  formData.append('orden_dia', orden_dia);

  $.ajax({
      url: "../consejo_tecnico/conexiones/subir_archivo.php",
      data: formData,
      type: "post",
      contentType: false,
      processData: false,
      success: function(data){
        //alert(data);
        showFilesViewer();
        hideAddFil();
      }
    });

  //showAddFil();

}

function registrar_subcarp(){

  var nombre_carpeta = $("#nombre_subcarp").val();
  //alert(nombre_carpeta);
  var func = 1;
  var idPadre = $("#carp_selec").val();
  var orden_dia = $("#index_orden").val();
  var num_punto = $("#index_punto").val();

  //Envío del tipo de funcion directamente mediante esta variable.

  $.ajax({
     url: "../consejo_tecnico/conexiones/subir_archivo.php",
     data: {"nomCarpeta":nombre_carpeta, "funcion": func, "idPadre":idPadre,"punto":num_punto, "orden_dia": orden_dia },
     type: "post",
      success: function(data){
        //alert(data);
        showFilesViewer();
        hideAddSub();
        document.getElementById("nombre_subcarp").value="";
      }
    });

    //showAddSub();

}

function selec_carp(id_carpeta){
  //Esta función recibe el id de carpeta que se ha seleccionado
  document.getElementById("carp_selec").value = id_carpeta;
  showFilesViewer();
  hideEditAll();
  hideOptions();
}

function selec_padre(){
  //funcion que selecciona el padre de la carpeta en uso y lo manda
  //al botón indicador

  var func = 0;
  var carpeta = $("#carp_selec").val();

  if(carpeta>0){ //Evita retroceder cuando no hay carpeta padre
    $.ajax({
       url: "../consejo_tecnico/conexiones/subir_archivo.php",
       data: {"funcion":func, "carpeta":carpeta},
       type: "post",
        success: function(data){
            document.getElementById("carp_selec").value = data;
            showFilesViewer();
            hideEditAll();
            hideOptions();
        }
      });
  }


}

function update_file(id_file){
  eleccion=confirm("¿Estás seguro de que quieres reemplazar el archivo?");

  var formData = new FormData(document.getElementById("frm_newfile"));
  var func = 4;
  var id_file = id_file;

  formData.append('file', id_file);
  formData.append('funcion', func);

  $.ajax({
      url: "../consejo_tecnico/conexiones/subir_archivo.php",
      data: formData,
      type: "post",
      contentType: false,
      processData: false,
      success: function(data){
        alert(data);
        showFilesViewer();
        hideEditAll();
        hideOptions();
      }
    });

  if(eleccion){
    alert("Archivo reemplazado");
  }
}

function update_folder(carpeta){
  eleccion=confirm("¿Estás seguro de que quieres cambiar el nombre de la carpeta?");

  var nombre = $("#newfolder").val();
  var func = 3; //Para editar carpeta
  var carpeta = carpeta;

  if(eleccion){ //Si acepta modificar el nombre
    $.ajax({
       url: "../consejo_tecnico/conexiones/subir_archivo.php",
       data: {"funcion":func, "carpeta":carpeta, "nombre":nombre },
       type: "post",
        success: function(data){
            //alert("Nombre de carpeta modificado");
            showFilesViewer();
            hideEditAll();
            hideOptions();
        },
        failure: function(){
          alert("No se ha podido modificar el nombre");
        }
      });
  }
}

function delete_folder(id_folder){
  eleccion = confirm("Al borrar esta carpeta también se eliminará su contenido.\n¿Seguro de que quieres continuar?");

  var func = 5;

  if(eleccion){ //Si acepta modificar el nombre
    $.ajax({
       url: "../consejo_tecnico/conexiones/subir_archivo.php",
       data: {"funcion":func, "carpeta":id_folder },
       type: "post",
        success: function(data){
            //alert("Nombre de carpeta modificado");
            alert("Carpeta y contenido eliminados "+data);
            showFilesViewer();
            hideEditAll();
            hideOptions();
        },
        failure: function(){
          alert("No se ha podido eliminar la carpeta");
        }
      });
  }
}

function delete_file(id_file){
  eleccion=confirm("¿Estás seguro de que quieres eliminar el archivo?");

  var func = 6;
  var file = id_file;

  if(eleccion){

    $.ajax({
       url: "../consejo_tecnico/conexiones/subir_archivo.php",
       data: {"funcion":func, "file":file },
       type: "post",
        success: function(data){
            //alert("Nombre de carpeta modificado");
            alert("Archivo eliminado"+ data);
            showFilesViewer();
            hideEditAll();
            hideOptions();
        },
        failure: function(){
          alert("No se ha podido eliminar la carpeta");
        }
      });

  }
}

function updateContenido(num_punto){

  var id_orden = parseInt($("#id_ordenDia").val());


  eleccion=confirm("id_orden: "+id_orden+" num_punto: "+num_punto);

  /*if(eleccion){$.ajax({
      url: "../consejo_tecnico/editar_contenido.php",
      data: {"orden":id_orden, "punto":num_punto},
      type: "post",
      success: function(data){
        document.location.href="http://localhost/consejo_tecnico/editar_contenido.php";
        alert("id_orden: "+id_orden+" num_punto: "+num_punto);
      }
    });
  }*/

  //document.getElementById("index_orden").value = id_orden;
  //document.getElementById("index_punto").value = num_punto;

}
