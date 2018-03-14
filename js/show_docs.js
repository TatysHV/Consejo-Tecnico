function irPortal(){
    window.location.assign("../consejo_tecnico/portal.php");
}

function desplegar_docs(ID,padre){
  var id = ID;
  var padre=padre;

  var vista = document.getElementById("vista"+id).value;

  if(vista == "0"){
    $.ajax({
        url: "/consejo_tecnico/fragmentos/archivoSustrato.php",
        data: {"id":id, "padre":padre},
        type: "post",
        success: function(data){
            document.getElementById("puntos"+id).innerHTML = data;
            document.getElementById("puntos"+id).style.display = "block";
            document.getElementById("vista"+id).value = 1;
        }
      });
  } else{
    document.getElementById("vista"+id).value = 0;
    document.getElementById("puntos"+id).style.display = "none";
  }
}

function desplegar_sub(ID,padre){
  var id = ID;
  var padre=padre;

  var vista = document.getElementById("vista"+padre).value;

  if(vista == "0"){
    $.ajax({
        url: "/consejo_tecnico/fragmentos/archivoSustrato.php",
        data: {"id":id, "padre":padre},
        type: "post",
        success: function(data){
            document.getElementById("puntos"+padre).innerHTML = data;
            document.getElementById("puntos"+padre).style.display = "block";
            document.getElementById("vista"+padre).value = 1;
        }
      });
  } else{
    document.getElementById("vista"+padre).value = 0;
    document.getElementById("puntos"+padre).style.display = "none";
  }
}

//var numero_punto = $("#indice_puntos").val(); //Este punto tendrá que ser corregido después

function add_punto(){

  var nuevo_punto = parseInt( $("#indice_puntos").val() )+1;

  document.getElementById("add_punto").style.display = "block";
  //document.getElementById("addp-btn").style.display = "block";


  var punto = '<img src="imagenes/checklist.png" style="max-width: 60px; height: auto; margin-left: 2%; float: left;"/>'+
  '<table id="tcarpeta">'+
    '<tr>'+
    '<th><center>Punto</center></th>'+
      '<th>Título</th>'+
      '<th></th>'+
      '<th></th>'+
    '</tr>'+
    '<tr>'+
      '<td><input type="number" id="numPoint" value="'+nuevo_punto+'" style="width:50px; text-align:center"/></td>'+
      '<td style="min-width: 300px"><input type="text" class="fsesion" style="width: 100%;" placeholder="Nombre del punto" id="nombre_punto" name="nombre_punto"/></td>'+
      '<td><center><b>Archivo Protegido: </b><input type="checkbox" class="fseseion" id="proteger" name="proteger"/></center></td>'+
      '<th><center><input type="button" class="btn btn-success" value="Crear" onclick="registrar_punto()"/></center></th>'+
    '</tr>'+
  '</table>';

  var archivos = '<form method="post" id="frm_addfile" enctype="multipart/form-data">'+
    '<table id="tarchivos" width="90%;">'+
    '<tr>'+
      '<td><b>Elegir Archivos: </b></td>'+
      '<td><input type="file" class="file" id="file_archivo" name="file_archivo[]" multiple></td>'+
      '<td><input type="button" class="btn btn-info" value="Subir" onclick="registrar_archivo()"/></td>'+
    '</tr>'+
    '</table>'+
  '</form>';

  document.getElementById("add_punto").innerHTML = punto;
  document.getElementById("add_punto").style.background="#F7F7F7";

  show_addPunto();

}

function showforyear(){
  var lista = document.getElementById("year");
  var indice = lista.selectedIndex;
  var opcion = lista.options[indice];
  var year = opcion.value;

  $.ajax({
      url: "/consejo_tecnico/fragmentos/sesionesforyear.php",
      data: {"year":year},
      type: "post",
      success: function(data){
          document.getElementById("showyear").innerHTML = '</br>' + '<div class ="titular"><center>SESIONES DEL AÑO '+year+'</center><div>';
          $('#empty').html(data);
			}
    });
}

function show_addCont(){
  document.getElementById("visor_contenido").style.display = "block";
  document.getElementById("notaAddPunto").style.display = "none";
  document.getElementById("add_punto").style.display = "none";
  document.getElementById("tituloZ").style.display = "none";
  showFilesViewer();
}

function show_addPunto(){
  document.getElementById("visor_contenido").style.display = "none";
  document.getElementById("notaAddPunto").style.display = "block";
  document.getElementById("add_punto").style.display = "block";
  document.getElementById("tituloZ").style.display = "block";
}


function show_menu(){
  document.getElementById("menu-sustrato").style.display="block";
}

function hide_menu(){
  document.getElementById("menu-sustrato").style.display="none";
}

function show_tree(){
     document.getElementById("docs-tree").style.display = "block";
     document.getElementById("add_punto").style.display = "none";

}

function showAddSub(){
  document.getElementById("add_subcarp").style.display="block";
  hideAddFil();
  hideOptions();
  hideEditAll();
}

function hideAddSub(){
  document.getElementById("add_subcarp").style.display="none";
  document.getElementById("nombre_subcarp").value="";
}

function showAddFil(){
  document.getElementById("add_archivo").style.display="block";
  hideAddSub();
  hideOptions();
  hideEditAll();
}

function hideAddFil(){
  document.getElementById("add_archivo").style.display="none";
  $('#file_archivo').replaceWith( $('#file_archivo').clone() );
}


function showFoldersnFiles(){
  //Obtiene el ID del punto de la orden del día, para mostrar su contenido (Carpetas y Archivos)
  //Nota: Habrá dos formas de obtener la ID. 1. El ID del último punto creado, 2. El ID específico de un punto.

  //var id_ordenDia;

  $.ajax({
      url: "/consejo_tecnico/fragmentos/carpetas.php",
      data: {},
      type: "post",
      success: function(data){
          document.getElementById("showyear").innerHTML = '</br>' + '<div class ="titular"><center>SESIONES DEL AÑO '+year+'</center><div>';
          $('#empty').html(data);
			}
    });
}

function optionsEditFolder(id_carpeta){
  //Muestra el menu de opciones de edicion de una carpeta y le agrega la id carpeta correspondiente a la funcion.

  var id_carpeta = id_carpeta;

  document.getElementById("efolder").style.display="block";
  document.getElementById("efile").style.display="none";

  var html = '<center><p style="font-size: 1.5em; color: grey;">Editar Carpeta</p>'+
              '<ul class="op">'+
              '<li><a onclick="showEditFolder('+id_carpeta+')">Cambiar nombre de carpeta</a></li>'+
              '<li><a onclick="delete_folder('+id_carpeta+')">Eliminar carpeta y contenido</a></li>'+
              '</ul>'+
              '<button onclick="hideOptions()">Cancelar</button>'+
              '</center>';

  document.getElementById("efolder").innerHTML = html;

  hideEditAll();
  hideAddSub();
  hideAddFil()
}

function optionsEditFile(id_archivo){
  var id_archivo = id_archivo;

  /*Muestra el menú de opciones de edición de un archivo y agrega la id correspondiente a la funcion*/

  document.getElementById("efile").style.display="block";
  document.getElementById("efolder").style.display="none";

  var html =   '<center>'+
               '<p style="font-size: 1.5em; color: grey;">Editar Archivo</p>'+
               '<ul class="op">'+
                  '<li><a onclick="showEditFile('+id_archivo+')">Sustituir archivo</a></li>'+
                  '<li><a onclick="delete_file('+id_archivo+')">Eliminar archivo</a></li>'+
                '</ul>'+
                '<button onclick="hideOptions()">Cancelar</button>'+
              '</center>';

  document.getElementById("efile").innerHTML = html;

  hideEditAll();
  hideAddSub();
  hideAddFil()
}

function hideOptions(){
  document.getElementById("efolder").style.display="none";
  document.getElementById("efile").style.display="none";
}

function showEditFolder(id_folder){

  //document.getElementById("edit_fold").style.display="block";
  hideOptions();
  document.getElementById("update_folder").style.display="block";
//  document.getElementById("notaEditFolder").style.display="block";

  var html = '<div id ="notaEditFolder" class="notaEdit" style="">'+
              '<center><span style="color: blue">Acción:</span> Estás editando el nombre de la carpeta.</center>'+
              '</div>'+
              '<div id="edit_fold" style="">'+
                '<img src="imagenes/folderBig.png"/ style="width: 60px; height: auto; float: left; margin-left:5%;"></center>'+
                '<p style="float: right; color: red; cursor: pointer;" onclick="hideEditFold()">[ x ]</p>'+
                '<table id="tcarpeta">'+
                  '<tr>'+
                    '<th>Cambiar nombre de carpeta</th>'+
                  '</tr>'+
                  '<tr>'+
                    '<td style="min-width: 400px"><input type="text" class="fsesion" style="width:350px" placeholder="Nombre de la carpeta" id="newfolder" name="neewcarp"/></td>'+
                    '<th><center><input type="button" class="btn btn-info" value="Aceptar" onclick="update_folder('+id_folder+')"/></center></th>'+
                  '</tr>'+
                '</table>'+
              '</div>';

  document.getElementById("update_folder").innerHTML = html;

  hideOptions();
  hideAddSub();
  hideAddFil()
}

function showEditFile(id_file){
  hideOptions();
  document.getElementById("update_file").style.display="block";

  var html =  '<div id ="notaEditFile" class="notaEdit" style="">'+
              '<center><span style="color: blue">Acción:</span> Estás reemplazando el archivo por uno nuevo.</center>'+
            '</div>'+

            '<div id="edit_file" class="archivo" style="display:block;">'+
              '<img src="imagenes/files.png" style="width:60px; height: auto; float: left; margin-left: 5%; margin-top: 10px;"/>'+

              '<form method="post" id="frm_newfile" enctype="multipart/form-data">'+
                '<p style="float: right; color: red; cursor: pointer;" onclick="hideEditFile()">[ x ]</p>'+
                '<!--input discreto que contiene el tipo de función que ejecutará en subir_sustrato.php-->'+
                '<input type="text" name="funcion" value="" style="display:none">'+
                '<!--input discreto que contiene el tipo de función que ejecutará en subir_sustrato.php-->'+
                '<table id="tarchivos" width="85%;">'+
                '<tr>'+
                  '<th>Sustituir archivo</th>'+
                  '<th></th>'+
                '</tr>'+
                '<tr>'+
                  '<td><input type="file" class="file" id="newfile" name="file_archivo[]" multiple="true" style="width: 350px;"></td>'+
                  '<td><input type="button" class="btn btn-info" value="Aceptar" onclick="update_file('+id_file+')"/></td>'+

                '</tr>'+
                '</table>'+
              '</form>'+
            '</div>';

  document.getElementById("update_file").innerHTML = html;

  hideOptions();
  hideAddSub();
  hideAddFil()
}

function hideEditFold(){
  document.getElementById("edit_fold").style.display="none";
  document.getElementById("notaEditFolder").style.display="none";
}

function hideEditFile(){
  document.getElementById("edit_file").style.display="none";
  document.getElementById("notaEditFile").style.display="none";
}

function hideEditAll(){
  /*document.getElementById("edit_fold").style.display="none";
  document.getElementById("edit_file").style.display="none";
  document.getElementById("notaEditFile").style.display="none";
  document.getElementById("notaEditFolder").style.display="none";*/
  document.getElementById("update_file").style.display="none";
  document.getElementById("update_folder").style.display="none";
}


function showFilesViewer(flag){
var carpeta = $("#carp_selec").val();
var puntoActual = $('#index_punto').val();
var id_orden = $("#index_orden").val();
//alert("Punto a mostrar:"+puntoActual);

if(puntoActual > 0){
  $.ajax({
      url: "/consejo_tecnico/fragmentos/FilesViewer.php",
      data: {"carpeta": carpeta, "num_punto":puntoActual, "orden":id_orden},
      type: "post",
      success: function(data){
        $('#listaContenido').html(data);
        retornaNombre(puntoActual);
      }
    });
 }
}

function beforePoint(){
  document.getElementById("carp_selec").value = 0;
  var puntoActual = parseInt( $("#index_punto").val() )-1;
  var id_orden = $("#index_orden").val();

  //alert("Punto a mostrar:"+puntoActual);

  if(puntoActual > 0){
    $.ajax({
        url: "/consejo_tecnico/fragmentos/FilesViewer.php",
        data: {"carpeta": carpeta, "num_punto":puntoActual,"orden":id_orden},
        type: "post",
        success: function(data){
          $('#listaContenido').html(data);
          document.getElementById("index_punto").value = puntoActual;
          document.getElementById("nPunto").innerHTML = puntoActual;
          retornaNombre(puntoActual);
        }
      });
   }
}

function retornaNombre(punto){

var id_orden = $("#index_orden").val();

  $.ajax({
      url: "/consejo_tecnico/fragmentos/NavPoints.php",
      data: {"num_punto":punto, "orden":id_orden},
      type: "post",
      success: function(data){
        $('#nombrePunto').html(data);
      }
    });

}

function nextPoint(){
  document.getElementById("carp_selec").value = 0;
  var puntoActual = parseInt($("#index_punto").val());
  var nextpoint = puntoActual + 1;
  var puntosTotales = parseInt($("#indice_puntos").val());
  var id_orden = $("#index_orden").val();

  if(puntoActual < puntosTotales){
    $.ajax({
        url: "/consejo_tecnico/fragmentos/FilesViewer.php",
        data: {"carpeta": carpeta, "num_punto":nextpoint,"orden":id_orden},
        type: "post",
        success: function(data){
          $('#listaContenido').html(data);
          document.getElementById("index_punto").value =nextpoint;
          document.getElementById("nPunto").innerHTML = nextpoint;
          retornaNombre(nextpoint);
        }
      });
   }
}

/*******************************************************************************/
/************************ PANEL DE CONTROL *************************************/
/*******************************************************************************/

/*************************VISUALIZACION AGREGAR NUEVO USUARIO*******************/
function show_add_user(){
  document.getElementById("bloque_registrar_usuario").style.display="block";
  hide_users_table();
}
function hide_add_user(){
  document.getElementById("bloque_registrar_usuario").style.display="none";
}
/*******************************************************************************/

/*****************VISUALIZACION DE TABLA DE USUARIOS****************************/
function show_users_table(){
  /*Función que muestra la tabla de usuarios desde un AJAX para facilitar las actualizaciones*/
  hide_add_user();
  document.getElementById("tabla_usuarios").style.display="block";
  $.ajax({
      url: "../consejo_tecnico/conexiones/administracion.php",
      data: {"funcion": 3},
      type: "post",
      success: function(data){
        $('#tabla_usuarios').html(data);
      },
      failure: function(){
        alert("Error al mostrar tabla de usuarios");
      }
    });
}
function hide_users_table(){
  document.getElementById("tabla_usuarios").style.display="none";
}
/******************************************************************************/

function show_edit_user(id_user){
  /*Función que coloca en la div #bloque_edicion_usuario de PanelControl el fragmento
  de código html (php en realidad) para visualizar el editor de los datos de un usuario
  a partir de su id.*/
  document.getElementById("bloque_registrar_usuario").style.display="none";

  var id_user = id_user;

  $.ajax({
      url: "../consejo_tecnico/conexiones/administracion.php",
      data: {"funcion": 1, "id_user":id_user},
      type: "post",
      success: function(data){
        $('#bloque_edicion_usuario').html(data);
      },
      failure: function(){
        alert("Error al mostrar formulario para editar usuario");
      }
    });

}

/****************** Visualización de la edición de calendarios ****************/

function showEditCalGral(){ document.getElementById("editCalGral").style.display="block"; }
function hideEditCalGral(){ document.getElementById("editCalGral").style.display="none"; }

function showEditCalSes(){ document.getElementById("editCalSes").style.display="block";}
function hideEditCalSes(){ document.getElementById("editCalSes").style.display="none";}

/******************* Visualización de la edición de normatividad **************/

function showEditRegGral(){ document.getElementById("reglamentoGral").style.display="block";}
function hideEditRegGral(){ document.getElementById("reglamentoGral").style.display="none";}

function showEditRegCT(){ document.getElementById("reglamentoCT").style.display="block";}
function hideEditRegCT(){ document.getElementById("reglamentoCT").style.display="none";}
