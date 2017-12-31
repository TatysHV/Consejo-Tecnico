function desplegar_docs(ID){
  var id = ID;

  var vista = document.getElementById("vista"+id).value;

  if(vista == "0"){
    $.ajax({
        url: "/consejo_tecnico/fragmentos/archivoSustrato.php",
        data: {"id":id},
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

var numero_punto = 1; //Este punto tendrá que ser corregido después

function add_punto(){
  document.getElementById("add_punto").style.display = "block";
  document.getElementById("add_subcarp").style.display = "none";
  document.getElementById("add_archivo").style.display = "none";
  document.getElementById("addp-btn").style.display = "block";



  numero_punto++;

  var punto = '<table id="tcarpeta">'+
    '<tr>'+
    '<th><center>Punto</center></th>'+
      '<th>Título</th>'+
      '<th></th>'+
      '<th></th>'+
    '</tr>'+
    '<tr>'+
      '<td><center>'+numero_punto+'.</center></td>'+
      '<td style="min-width: 300px"><input type="text" class="fsesion" style="width: 100%;" placeholder="Nombre del punto" id="nombre_punto" name="nombre_punto"/></td>'+
      '<td><center><b>Archivo Protegido: </b><input type="checkbox" class="fseseion" id="proteger" name="proteger"/></center></td>'+
      '<th><center><input type="button" class="btn btn-info" value="Subir" onclick="registrar_punto()"/></center></th>'+
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
  document.getElementById("add_archivo").innerHTML = archivos;
  document.getElementById("menu_files").innerHTML = "";
  document.getElementById("control_puntos").innerHTML = '<input type="button" id="indice_puntos" name="indice_puntos" value="'+numero_punto+'"/>';

  document.getElementById("add_punto").style.background="white";

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
}

function showAddFil(){
  document.getElementById("add_archivo").style.display="block";
  hideAddSub();
  hideOptions();
  hideEditAll();
}

function hideAddFil(){
  document.getElementById("add_archivo").style.display="none";
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


function showFilesViewer(){
var carpeta = $("#carp_selec").val();

  $.ajax({
      url: "/consejo_tecnico/fragmentos/FilesViewer.php",
      data: {"carpeta": carpeta},
      type: "post",
      success: function(data){
        $('#listaContenido').html(data);
      }
    });
  }
