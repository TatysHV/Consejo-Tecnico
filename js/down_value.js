
/**************************** CONTROL DE SESION *******************************/
/******************************************************************************/
/*Funciones necesarias para obtener los valores correspondientes de los diferentes
formularios para subir y modificar los datos de cada sesión, como la orden del día
y todo el contenido que lo compone*/

function registrar_punto(){

  //document.getElementById("btnAddPunto").disabled = true;

  var numero_punto = $("#numPoint").val(); //Contador de puntos, comienza de 0, cuando se registra se va incrementando
  var nombre_punto = $("#nombre_punto").val();
  var id_orden = $("#index_orden").val();
  var proteger = document.getElementById("proteger").checked;

  var cant_puntos = parseInt($("#indice_puntos").val());

  //var nuevo_numero = parseInt(numero_punto) + 1; //Aumenta el contador en 1

  if(proteger == true){ proteger=1} else{proteger=0};

  $.ajax({
     url: "../consejo_tecnico/conexiones/subir_sustrato.php",
     data: {"nombre":nombre_punto, "numero":numero_punto, "proteger":proteger, "caso":2, "orden":id_orden},
     type: "post",
      success: function(data){
        //alert("Punto registrado correctamente");
         document.getElementById("indice_puntos").value = cant_puntos+1;
         document.getElementById("nPunto").innerHTML = numero_punto;

         document.getElementById("add_punto").innerHTML = '<div class="row" style="width:80%; margin:auto;"><div class="col-xs-5"><img src="imagenes/success.png" style="width:100px; height:auto;"/></div><div class="col-xs-7"><br><center><p style="font-size: 1.2em;">Punto <span style="color: #0B3B0B"><b>'+nombre_punto+'</b></span> Registrado Correctamente</p><input type="button" class="btn btn-warning" value="Agregar contenido" onclick="show_addCont()">';
         document.getElementById("add_punto").style.background ="#BCF5A9";
         document.getElementById("add_punto").style.heigth = "110px;"
         //document.getElementById("subtitulo1").style.display = 'none';

         //alert("numero: "+nuevo_numero);
         document.getElementById("nombrePunto").innerHTML = nombre_punto;        // document.getElementById("addp-btn").style.display = "block";
         document.getElementById("index_punto").value = numero_punto;
         document.getElementById("carp_selec").value = 0;
        // document.getElementById("btnAddPunto").disabled = false;

         showFilesViewer();
      }
    });

}

function editar_punto(id_punto){

  var numero_actual = $("#index_punto").val();
  var id_orden = $("#index_orden").val();

  var numero_nuevo = $("#newNumPoint").val(); //Contador de puntos, comienza de 0, cuando se registra se va incrementando
  var nombre_punto = $("#newNamePoint").val();
  var proteger = document.getElementById("newProteger").checked;
  if(proteger == true){ proteger=1} else{proteger=0};

  var caso = 3; //Numero de caso 3 que es para editar punto.

  $.ajax({
     url: "../consejo_tecnico/conexiones/subir_sustrato.php",
     data: {"nombre":nombre_punto, "numeroNuevo":numero_nuevo,"numeroAnterior":numero_actual, "proteger":proteger, "idPunto": id_punto,"orden":id_orden, "caso": caso},
     type: "post",
      success: function(data){
        alert("Punto modificado correctamente");
        window.location.assign("../consejo_tecnico/sesiones.php");
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

  //Desactivamos el botón de "Subir" para evitar duplicados
  document.getElementById('file_archivo').disabled = true;

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
        document.getElementById('file_archivo').disabled = false;
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

function delete_punto(id_punto,num,ID){
  var id_punto = id_punto;
  var num=num;
  var id=ID;
  var func = 8;
  eleccion = confirm("¿Seguro que quiere eliminar el Punto "+id_punto+"?");
  if(eleccion){
    $.ajax({
       url: "../consejo_tecnico/conexiones/subir_archivo.php",
       data: {"id_punto":id_punto,"funcion":func,"numero":num,"id_orden":id},
       type: "post",
        success: function(data){
            //alert("Nombre de carpeta modificado");
            alert(data);
            window.location.assign("../consejo_tecnico/sesion.php?sesion="+id);

        },
        failure: function(){
          alert("No se ha podido eliminar el punto");
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


function delete_orden_dia(ID){
  var id=ID;
  var func = 9;
  eleccion = confirm("¿Seguro que quiere eliminar la Orden del día "+ID+"?");
  if(eleccion){
    $.ajax({
       url: "../consejo_tecnico/conexiones/subir_archivo.php",
       data: {"id_orden":id,"funcion":func},
       type: "post",
        success: function(data){
            //alert("Nombre de carpeta modificado");
            //alert(data);
            window.location.assign("../consejo_tecnico/sesiones.php");
        },
        failure: function(){
          alert("No se ha podido eliminar el punto");
        }
      });

  }
}

/********************** CONTROL DE ACTAS **************************************/
/******************************************************************************/

function registrar_acta(){

/**OBTIENE TODO EL FORMULARIO PARA SUBIR EL ACTA*/

  var formData = new FormData(document.getElementById("frm_addActa"));

  $.ajax({
      url: "../consejo_tecnico/conexiones/registrar_acta.php",
      data: formData,
      type: "post",
      contentType: false,
      processData: false,
      success: function(data){
        alert("Acta registrada con éxito, nombre: "+data);
        window.location.assign("../consejo_tecnico/actas.php");
      },
      failure: function(){
        alert("No se ha podido eliminar el punto"+data);
      }
    });

}

function delete_acta(ID){
  var id=ID;
  var func = 10;
  eleccion = confirm("¿Seguro que quiere eliminar el Acta"+ID+"?");
  if(eleccion){
    $.ajax({
       url: "../consejo_tecnico/conexiones/subir_archivo.php",
       data: {"id_acta":id,"funcion":func},
       type: "post",
        success: function(data){
            //alert("Eliminando acta");
            alert(data);
            window.location.assign("../consejo_tecnico/actas.php");
        },
        failure: function(){
          alert("No se ha podido eliminar el acta");
        }
      });

  }
}

/******************************************************************************/
/************************CONTROLES DE ADMINISTRACIÓN***************************/
/******************************************************************************/


/************************** CONTROL DE USUARIOS ***************************/
function addUser(){
  var nombreUsuario = $("#userName").val();
  var passUsuario = $("#userPass").val();
  var notaUsuario = $("#userDesc").val();

  var lista = document.getElementById("userType");
  var indice = lista.selectedIndex;
  var opcion = lista.options[indice];
  var tipoUsuario = opcion.value;

  alert("Datos obtenidos correctamente "+nombreUsuario+" "+passUsuario+" "+tipoUsuario);

  if(tipoUsuario == "Todos"){
    tipoUsuario = parseInt(0);
    alert("tipo usuario pasre: "+tipoUsuario);
  }

  else if(tipoUsuario == "Limitados"){tipoUsuario = parseInt(1);}

  $.ajax({
     url: "../consejo_tecnico/conexiones/administracion.php",
     data: {"username":nombreUsuario,"password":passUsuario,"type":tipoUsuario,"nota": notaUsuario, "funcion":0},
     type: "post",
      success: function(data){
          alert("Registro de usuario exitoso "+data);
      },
      failure: function(){
        alert("No se pudo registrar el nuevo usuario");
      }
    });
}


function updateUser(id_user){
  /**********************************************************************************************/
  /********************* función que modifica los datos de un usuario *******************/

  var id_user = id_user;
  var newname = $("#newuserName").val();
  var newtype = $("#newuserType").val();
  var newnote = $("#newuserDesc").val(); //La nota no es un campo obligatorio, puede ser vacío
  var newpass = $("#newuserPass").val();

  var eleccion = confirm("¿Seguro que quiere modificar el usuario?"); //Pregunta de seguridad para confirmar

  if (eleccion){
    if (newname == ""){alert("Debes agregar un nombre de usuario");}
    if (newtype == ""){alert("Debes seleccionar un tipo de usuario");}

    if (newpass == ""){//Si no se escribió nada en el espacio de nueva contraseña, no se le hará ningún cambio.
      //Así se mandan sólo 3 valores por ajax, nombre, tipo y nota.
      $.ajax({
         url: "../consejo_tecnico/conexiones/administracion.php",
         data: {"id":id_user, "username":newname,"type":newtype,"nota": newnote, "funcion":2, "flagPass": false},
         type: "post",
          success: function(data){
              alert("Modificación exitosa de usuario");
              show_users_table();//Actualiza la tabla de usuarios
          },
          failure: function(){
            alert("No se pudo modificar el usuario"+data);
          }
        });

    }
    else{//Sí se colocó una nueva contraseña
      $.ajax({
         url: "../consejo_tecnico/conexiones/administracion.php",
         data: {"id":id_user, "username":newname,"password":newpass,"type":newtype,"nota": newnote, "funcion":2, "flagPass": true},
         //flagPass es un booleano que ayuda a no sufrir error en el PHP al no recibir la variable que espera, para no esperarlo, si no se manda =)
         type: "post",
          success: function(data){
              alert("Modificación exitosa de usuario");
              show_users_table();//Actualiza la tabla de usuarios
          },
          failure: function(){
            alert("No se pudo modificar el usuario"+data);
          }
        });
    }
  }
}

function deleteUser(id_user){

  var eleccion = confirm("¿Seguro que desea eliminar el usuario?");//Pregunta de seguridad

  if(eleccion){
    $.ajax({
       url: "../consejo_tecnico/conexiones/administracion.php",
       data: {"id":id_user, "funcion":4},
       //flagPass es un booleano que ayuda a no sufrir error en el PHP al no recibir la variable que espera, para no esperarlo, si no se manda =)
       type: "post",
        success: function(data){
            alert("Usuario eliminado con éxito");
            show_users_table();//Actualiza la tabla de usuarios
        },
        failure: function(){
          alert("Error al eliminar usuario"+data);
        }
      });
    }
}
/********************************************************************/
/************** CONTROL DE CALENDARIO *******************************/

function subirCalendario(tipo){
  //Envía el tipo de funcion a través de un input, y se manda mediante todo el paquete del formulario ;)
  var formData;

  if(tipo == 'calgeneral'){
    var formData = new FormData(document.getElementById("frm_CalendarGral"));
  }
  else if(tipo == 'calsesiones'){
    var formData = new FormData(document.getElementById("frm_CalendarSes"));
  }

  //alert(tipo);

  formData.append('tipo', tipo);
  formData.append('funcion', 5);


  $.ajax({
      url: "../consejo_tecnico/conexiones/administracion.php",
      data: formData,
      type: "post",
      contentType: false,
      processData: false,
      success: function(data){
        alert("Calendario modificado de manera correcta"+data);
      },
      failure: function(){
        alert("Error al subir el nuevo calendario"+data);
      }
    });
  }
  /***************************************************************************/
  /************************ CONTROL DE NORMATIVIDAD **************************/

  function regReglamentoGral(){
    var formData = new FormData(document.getElementById("frm_regGral"));

    formData.append('funcion', 6);

    $.ajax({
        url: "../consejo_tecnico/conexiones/administracion.php",
        data: formData,
        type: "post",
        contentType: false,
        processData: false,
        success: function(data){
          alert("Reglamento UNAM registrado correctamente. ");
          window.location.assign("../consejo_tecnico/normatividad.php");
        },
        failure: function(){
          alert("Error al registrar nuevo reglamento. "+data);
        }
      });

  }

  function regReglamentoCT(){
        var formData = new FormData(document.getElementById("frm_regCT"));

        formData.append('funcion', 7);

        $.ajax({
            url: "../consejo_tecnico/conexiones/administracion.php",
            data: formData,
            type: "post",
            contentType: false,
            processData: false,
            success: function(data){
              alert("Reglamento HCT registrado correctamente. ");
              window.location.assign("../consejo_tecnico/normatividad.php");
            },
            failure: function(){
              alert("Error al registrar nuevo reglamento. "+data);
            }
          });

  }

  function deleteReg(id_reg){

    var eleccion = confirm("¿Estás seguro de eliminar este reglamento?"); //Pregunta de seguridad para confirmar

    if (eleccion){
      //Así se mandan sólo 3 valores por ajax, nombre, tipo y nota.
      $.ajax({
         url: "../consejo_tecnico/conexiones/administracion.php",
         data: {"id":id_reg, "funcion":8},
         type: "post",
          success: function(data){
              alert("Se ha eliminado el reglamento");
              window.location.assign("../consejo_tecnico/normatividad.php");

          },
          failure: function(){
            alert("No se logró eliminar el reglamento"+data);
          }
        });

    }
  }

    /***************************************************************************/
  /************************ CONTROL DE COMITES **************************/

  function regComiteA(){
    var formData = new FormData(document.getElementById("frm_comA"));

    formData.append('funcion', 9);

    $.ajax({
        url: "../consejo_tecnico/conexiones/administracion.php",
        data: formData,
        type: "post",
        contentType: false,
        processData: false,
        success: function(data){
          alert("Comité de académicos, licenciaturas y programas registrado correctamente. ");
          window.location.assign("../consejo_tecnico/comites.php");
        },
        failure: function(){
          alert("Error al registrar nuevo comité. "+data);
        }
      });

  }

  function regComiteO(){
        var formData = new FormData(document.getElementById("frm_comO"));

        formData.append('funcion', 10);

        $.ajax({
            url: "../consejo_tecnico/conexiones/administracion.php",
            data: formData,
            type: "post",
            contentType: false,
            processData: false,
            success: function(data){
              alert("Comité de otro tipo registrado correctamente. ");
              window.location.assign("../consejo_tecnico/comites.php");
            },
            failure: function(){
              alert("Error al registrar nuevo comité. "+data);
            }
          });

  }


  function deleteCom(id_reg){

    var eleccion = confirm("¿Estás seguro de eliminar este comité?"); //Pregunta de seguridad para confirmar

    if (eleccion){
      //Así se mandan sólo 3 valores por ajax, nombre, tipo y nota.
      $.ajax({
         url: "../consejo_tecnico/conexiones/administracion.php",
         data: {"id":id_reg, "funcion":11},
         type: "post",
          success: function(data){
              alert("Se ha eliminado el comité");
              window.location.assign("../consejo_tecnico/comites.php");

          },
          failure: function(){
            alert("No se logró eliminar el comité"+data);
          }
        });

    }
  }


function editComite(){
  alert("Registrando modificaciones...");

      var formData = new FormData(document.getElementById("frm_com"));

      formData.append('funcion', 16);

      $.ajax({
          url: "../consejo_tecnico/conexiones/administracion.php",
          data: formData,
          type: "post",
          contentType: false,
          processData: false,
          success: function(data){
            alert("Modificación registrada correctamente"+data);
            window.location.assign("../consejo_tecnico/comites.php");
          },
          failure: function(){
            alert("Error al registrar modificación. "+data);
          }
        });

}
/***************************************************************************/
  /************************ CONTROL DE COMISIONES **************************/

  function regComisionD(){
    var formData = new FormData(document.getElementById("frm_comD"));

    formData.append('funcion', 12);

    $.ajax({
        url: "../consejo_tecnico/conexiones/administracion.php",
        data: formData,
        type: "post",
        contentType: false,
        processData: false,
        success: function(data){
          alert("Comisión dictaminadora registrada correctamente. ");
          window.location.assign("../consejo_tecnico/comisiones.php");
        },
        failure: function(){
          alert("Error al registrar nueva comisión. "+data);
        }
      });

  }

  function regComisionE(){
        var formData = new FormData(document.getElementById("frm_comE"));

        formData.append('funcion', 13);

        $.ajax({
            url: "../consejo_tecnico/conexiones/administracion.php",
            data: formData,
            type: "post",
            contentType: false,
            processData: false,
            success: function(data){
              alert("Comisión evaluadora registrado correctamente. ");
              window.location.assign("../consejo_tecnico/comisiones.php");
            },
            failure: function(){
              alert("Error al registrar nueva comisión. "+data);
            }
          });

  }


  function deleteComision(id_reg){

    var eleccion = confirm("¿Estás seguro de eliminar esta comisión?"); //Pregunta de seguridad para confirmar

    if (eleccion){
      //Así se mandan sólo 3 valores por ajax, nombre, tipo y nota.
      $.ajax({
         url: "../consejo_tecnico/conexiones/administracion.php",
         data: {"id":id_reg, "funcion":14},
         type: "post",
          success: function(data){
              alert("Se ha eliminado la comisión");
              window.location.assign("../consejo_tecnico/comisiones.php");

          },
          failure: function(){
            alert("No se logró eliminar la comisión"+data);
          }
        });

    }
  }

function editComision(){
   alert("Registrando modificaciones...");

      var formData = new FormData(document.getElementById("frm_com"));

      formData.append('funcion', 15);

      $.ajax({
          url: "../consejo_tecnico/conexiones/administracion.php",
          data: formData,
          type: "post",
          contentType: false,
          processData: false,
          success: function(data){
            alert("Modificación registrada correctamente"+data);
            window.location.assign("../consejo_tecnico/comisiones.php");
          },
          failure: function(){
            alert("Error al registrar modificación. "+data);
          }
        });

}

  /*------------------------------------------------------------------------------
  -------------------------CONTROL DE ACUERDOS ----------------------------------
  -----------------------------------------------------------------------------*/

function add_etiqueta(){ //Registrar nuevas etiquetas
  var etiqueta = $("#new_etiqueta").val();

  var pertenece = $("#dirigido").val();


  $.ajax({
     url: "../consejo_tecnico/conexiones/upload.php",
     data: {"etiqueta":etiqueta, "pertenece":pertenece},
     type: "post",
      success: function(data){
          alert("Etiqueta registrada correctamente");
        //  $("#etiqueta").load('../consejo_tecnico/fragmentos/etiquetas.php'); // Volver a colocar el select de etiquetas actualizado
        //  Se intentó cargar mediante ajax pero hay un problema externo con el select de bootstrap, que no se puede cambiar el display: none. :c
        //  mejor hacerlo de manera tradicional, refrescando página y recargando los valores anteriores para evitar pérdida de información.
          location.reload();

        //A partir de que se recarga la página ya no sigue realizando las tareas :c

      },
      failure: function(){
        alert("Error al registrar etiqueta"+data);
      }
    });
}

function registrar_acuerdo(){

      alert("Registrando acuerdo...");

      var formData = new FormData(document.getElementById("frm_acuerdo"));

      formData.append('funcion', 0);

      $.ajax({
          url: "../consejo_tecnico/conexiones/acuerdos.php",
          data: formData,
          type: "post",
          contentType: false,
          processData: false,
          success: function(data){
            alert("Acuerdo registrado correctamente js"+data);
            //window.location.assign("../consejo_tecnico/normatividad.php");
          },
          failure: function(){
            alert("Error al registrar acuerdo js"+data);
          }
        });

}

function add_acuerdo_file(){
  alert("Registrando archivos de seguimiento");

  var formData = new FormData(document.getElementById("frm_acuerdo_files"));

  formData.append('funcion', 1);

  $.ajax({
      url: "../consejo_tecnico/conexiones/acuerdos.php",
      data: formData,
      type: "post",
      contentType: false,
      processData: false,
      success: function(data){
        alert("Archivos de seguimiento registrados"+data);
        //window.location.assign("../consejo_tecnico/normatividad.php");
      },
      failure: function(){
        alert("Error al registrar archivos de seguimiento"+data);
      }
    });

}

function show_acuerdo(id_acuerdo){
  // Coloca el contenido PHP en el div de la ventana Modal
  // para ver los archivos de seguimiento del acuerdo
  var id = id_acuerdo;

  $.ajax({
    url: "../consejo_tecnico/fragmentos/modal_acuerdo.php",
    data: {"id":id},
    type: "post",
    success: function(data){
      document.getElementById("modal_acuerdo").innerHTML = data;
      $("#info_acuerdo").modal('show');
    }
  });
}

function show_notes(id_acuerdo){
  // Coloca el contenido PHP en el div de la ventana Modal
  // para ver las notas del acuerdo
  var id = id_acuerdo;

  $.ajax({
    url: "../consejo_tecnico/fragmentos/modal_notes.php",
    data: {"id":id},
    type: "post",
    success: function(data){
      document.getElementById("modal_notes").innerHTML = data;
      $("#notas_acuerdo").modal('show');
    }
  });
}


function edit_acuerdo(){

      alert("Registrando modificaciones...");

      var formData = new FormData(document.getElementById("frm_acuerdo"));

      formData.append('funcion', 2);

      $.ajax({
          url: "../consejo_tecnico/conexiones/acuerdos.php",
          data: formData,
          type: "post",
          contentType: false,
          processData: false,
          success: function(data){
            alert("Modificación registrada correctamente");
            window.location.assign("../consejo_tecnico/acuerdos.php");
          },
          failure: function(){
            alert("Error al registrar modificación. "+data);
          }
        });

}

function delete_acuerdo(ID){
  var id=ID;
  var func = 3;
  eleccion = confirm("¿Seguro que quiere eliminar el acuerdo"+ID+"?");
  if(eleccion){
    $.ajax({
       url: "../consejo_tecnico/conexiones/acuerdos.php",
       data: {"id":id,"funcion":func},
       type: "post",
        success: function(data){
            //alert("Eliminando acta");
            alert(data);
            window.location.assign("../consejo_tecnico/acuerdos.php");
        },
        failure: function(){
          alert("No se ha podido eliminar el acuerdo");
        }
      });

  }
}

function delete_file_seguimiento(ID){
  var id=ID;
  var func = 4;
  eleccion = confirm("¿Seguro que quiere eliminar el archivo "+ID+"?");
  if(eleccion){
    $.ajax({
       url: "../consejo_tecnico/conexiones/acuerdos.php",
       data: {"id":id,"funcion":func},
       type: "post",
        success: function(data){
            //alert("Eliminando acta");
            alert(data);
            window.location.assign("../consejo_tecnico/acuerdos.php");
        },
        failure: function(){
          alert("No se ha podido eliminar el archivo");
        }
      });

  }
}


function change_page(pag){
    $("#pag_acuerdos").val(pag);
    busqueda_acuerdos();
}

function change_page_oficios(pag){
    $("#pag_oficios").val(pag);
    busqueda_oficios();
}

function check_file(file, type){

//Cualquier cantidad de letras de la a a la z sin importar mayúsculas
//y minúsculas y símbolos en cualquier parte, seguido por un punto . y en seguida (pdf o PDF)
var exReg_word = '/[a-z]/';
var exReg_pdf = '';

  switch(type){
    case 'word':

    break;
    case 'pdf':
    break;
  }

}

function bloquear_campos(){
  //Bloqueo de Año & Rango, permitido Año o Rango
  var fecha = $("#srch_year").val();
  var init = $("#srch_init").val();
  var finish = $("#srch_finish").val();

  if(fecha!=""){
    document.getElementById("srch_init").disabled = true;
    document.getElementById("srch_finish").disabled = true;
  }

  else if(init!=""||finish!=""){
      document.getElementById("srch_year").disabled = true;
  }

}

function busqueda_acuerdos(){

  var fecha = $("#srch_year").val();
  var etiqueta = $("#srch_etiqueta").val();
  var titulo = $("#srch_titulo").val();
  var estatus = $("#srch_estatus").val();
  var acuerdo = $("#srch_acuerdo").val();
  var rango = "";

  var init = $("#srch_init").val();
  var finish = $("#srch_finish").val();

  if(init!="" && finish!=""){
    var rango = "=)";
  }


//****************Identifica el tipo de búsqueda y combinaciones ***************
 /* Índice de combinaciones disponibles de búsqueda

 ORDEN JERÁRQUICO: Año, Título, Etiqueta, Estatus, Acuerdo, Rango

 1. año [OK]
 2. año, titulo [OK]
 3. año, etiqueta [OK]
 4. año, estatus [OK]
 5. año, acuerdo [OK]
 6. año, titulo, etiqueta [OK]
 7. año, titulo, etiqueta, estatus [OK]
 8. año, titulo, etiqueta, estatus, acuerdo [OK] 25
 9. año, titulo, etiqueta, acuerdo [OK]
 10. año, titulo, estatus [OK]
 11. año, titulo, estatus, acuerdo [OK]
 12. año, titulo, acuerdo [OK]
 13. año, etiqueta, acuerdo [OK]
 14. año, estatus, etiqueta [OK]
 15. año, estatus, etiqueta, acuerdo [OK]
 1515. año, estatus, acuerdo [OK]


16. etiqueta [OK]
17. etiqueta, titulo [OK]
18. etiqueta, estatus [OK]
19. etiqueta, acuerdo [OK]
20. etiqueta, rango [OK]
21. etiqueta, titulo, acuerdo [OK]
22. etiqueta, titulo, rango [OK]
23. etiqueta, titulo, estatus [OK] igual que el 29
24. etiqueta, titulo, estatus, acuerdo [OK]
25. ################################### año (Número 8 = 25, se cambió de posición)
26. etiqueta, titulo, estatus, acuerdo, rango [OK]
27. etiqueta, titulo, estatus, rango [OK]
28. etiqueta, titulo, acuerdo, rango [OK]
29. ################################# etiqueta, estatus, titulo = 23 [OK]
30. etiqueta, estatus, acuerdo [OK]
31. etiqueta, estatus, acuerdo, rango [OK]
32. etiqueta, estatus, rango [OK]
33. etiqueta, acuerdo, rango [OK]

34. estatus [OK]
35. estatus, titulo [OK]
36. estatus, titulo, acuerdo [OK]
37. ########################## estatus, titulo, acuerdo, año  = 11 [OK]
38. estatus, titulo, acuerdo, rango [OK]
39. estatus, titulo, rango [OK]
40. estatus, acuerdo [OK]
41. estatus, acuerdo, rango [OK]
42. estatus, rango [OK]

43. titulo [OK]
44. titulo, acuerdo [OK]
45. titulo, acuerdo, rango [OK]
46. titulo, acuerdo, año [OK]
47. titulo, rango [OK]

48. acuerdo [OK]
49. acuerdo, rango [OK]

50. rango [OK]


 */

  var nivel_busqueda = 0;


/**************************** FECHA ***************************/
  if(fecha!=""){
    if(titulo!=""){
      if(etiqueta!=""){
          if(estatus!=""){
            if(acuerdo!=""){ //fecha, titulo, etiqueta, estatus, acuerdo
              nivel_busqueda = 8;
            }
            else{
              nivel_busqueda = 7; //fecha, titulo, etiqueta, estatus
            }
          }
          else if(acuerdo!=""){ //fecha, titulo, etiqueta, acuerdo
            nivel_busqueda = 9;
          }
          else if(estatus=="" && acuerdo==""){ //fecha, titulo, etiqueta
            nivel_busqueda = 6;
          }
      }

      else if(estatus!=""){
          if(acuerdo!=""){ //fecha, titulo, estatus, acuerdo
            nivel_busqueda = 11;
          }
          else{ //fecha, titulo, estatus
            nivel_busqueda = 10;
          }
      }

      else if(acuerdo!=""){ //fecha, titulo, acuerdo
        nivel_busqueda = 12;
      }

      else if(etiqueta=="" && estatus=="" && acuerdo==""){ //fecha, titulo
        nivel_busqueda = 2;
      }
    }

    else if(estatus!=""){
      if(etiqueta!=""){
        if(acuerdo!=""){ //fecha, estatus, etiqueta, acuerdo
          nivel_busqueda = 15;
        }
        else{ //fecha, estatus, etiqueta
          nivel_busqueda = 14;
        }
      }
      else if(acuerdo!=""){ //fecha, estatus, acuerdo
        nivel_busqueda =  1515;
      }
      else if(etiqueta==""&&acuerdo==""){ //fecha, estatus
        nivel_busqueda = 4;
      }
    }

    else if(etiqueta!=""){
      if(acuerdo!=""){ //fecha, etiqueta, acuerdo
        nivel_busqueda = 13;
      }
      else{
        nivel_busqueda = 3;    //fecha, etiqueta
      }
    }

    else if(acuerdo!=""){ //fecha, acuerdo
      nivel_busqueda = 5;
    }

    else if(titulo==""&&estatus==""&&etiqueta==""&&acuerdo==""){
      nivel_busqueda = 1; //fecha
    }
  } /********************** ETIQUETA *********************************/

  else if(etiqueta!=""){
    if(titulo!=""){
      if(estatus!=""){
          if(acuerdo!=""){
            if(rango!=""){ //etiqueta, titulo, estatus, acuerdo, rango
              nivel_busqueda = 26;
            }
            else if(fecha!=""){ //etiqueta, titulo, estatus, acuerdo, fecha
              nivel_busqueda = 25; //8
            }
            else  if(rango=="" && fecha==""){ //etiqueta, titulo, estatus, acuerdo
              nivel_busqueda = 24;
            }
          }
          else if(rango!=""){ //etiqueta, titulo, estatus, rango
            nivel_busqueda = 27;
          }
          else if(acuerdo=="" && rango==""){ //etiqueta, titulo, estatus
            nivel_busqueda = 23;
          }
      }

      else if(acuerdo!=""){
          if(rango!=""){ ///etiqueta, titulo, acuerdo, rango
            nivel_busqueda = 28;
          }
          else{ //etiqueta, titulo, acuerdo
            nivel_busqueda = 21;
          }
      }

      else if(rango!=""){ //etiqueta, titulo, rango
        nivel_busqueda = 22;
      }

      else if(acuerdo=="" && rango ==""){ //etiqueta, titulo
        nivel_busqueda = 17;
      }
    }

    else if(estatus!=""){
      if(acuerdo!=""){
        if(rango!=""){ //etiqueta, estatus, acuerdo, rango
          nivel_busqueda = 31;
        }
        else{ //etiqueta, estatus, acuerdo
          nivel_busqueda = 30;
        }
      }
      else if(rango!=""){ // etiqueta, estatus, rango
        nivel_busqueda = 32;
      }
      else if(titulo=="" && acuerdo =="" && rango==""){
        nivel_busqueda = 18; // etiqueta, estatus
      }
    }

    else if(acuerdo!=""){
      if(rango!=""){ //etiqueta, acuerdo, rango
        nivel_busqueda = 33;
      }
      else{ //etiqueta, acuerdo
        nivel_busqueda = 19;
      }
    }

    else if(rango!=""){ //etiqueta, rango
      nivel_busqueda = 20;
    }
    else if(titulo=="" && estatus=="" && acuerdo=="" && fecha=="" && rango=="" ){
      nivel_busqueda = 16; // etiqueta
    }
  }/************************** ESTATUS *******************************/

  else if(estatus!=""){
    if(titulo!=""){
      if(acuerdo!=""){
        if(fecha!=""){ // estatus, titulo, acuerdo, fecha
          nivel_busqueda = 11;
        }
        else if(rango!=""){ //estatus, titulo, acuerdo, rango
          nivel_busqueda = 38;
        }
        else if(fecha=="" && rango==""){ //estatus, titulo, acuerdo
          nivel_busqueda = 36;
        }
      }
      else if(rango!=""){ // estatus, titulo, rango
        nivel_busqueda = 39;
      }
      else if(acuerdo==""&&rango==""&&etiqueta==""&&fecha==""){
        nivel_busqueda = 35; // estatus, título
      }
    }
    else if(acuerdo!=""){
      if(rango!=""){ //estatus, acuerdo, rango
        nivel_busqueda = 41;
      }
      else{ //estatus, acuerdo
        nivel_busqueda = 40;
      }
    }
    else if(rango!=""){ //estatus, rango
      nivel_busqueda = 42;
    }
    else if(titulo=="" && acuerdo=="" && fecha=="" && rango==""){
      nivel_busqueda = 34; //estatus
    }
  } /************************ TITULO ********************************/

  else if(titulo!=""){
    if (acuerdo!=""){
      if(rango!=""){ //titulo, acuerdo, rango
        nivel_busqueda = 45;
      }
      else if(fecha!=""){ //titulo, acuerdo, año
        nivel_busqueda = 12;
      }
      else if(rango=="" && fecha==""){ //titulo, acuerdo
        nivel_busqueda =44;
      }
    }
    else if(rango!=""){ //titulo, rango
      nivel_busqueda = 47;
    }
    else if(acuerdo=="" && rango==""){ // titulo
      nivel_busqueda = 43;
    }
  }/********************* ACUERDO ***********************/

  else if(acuerdo!=""){
    if(rango!=""){ //acuerdo, rango
      nivel_busqueda = 49;
    }
    else{ //acuerdo
      nivel_busqueda = 48;
    }
  }/******************** RANGO ************************/

  else if(rango!=""){ //rango
    nivel_busqueda = 50;
  }

/******************************************************************/

  var consulta ="";
  var consulta2 ="";

  var pag = $("#pag_acuerdos").val();
  var cantidad = 2; // cantidad de resultados por página
  var inicial = pag * cantidad;



/*********************** SELECCIÓN DE SENTENCIA SQL CORRESPONDIENTE ***********/

  switch (nivel_busqueda){
    case 1: // Año
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+"";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+"";
      break;
    case 2: // Año, Título
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%'";
      break;
    case 3: // Año, Etiqueta
      //alert("búsqueda por año y etiqueta");
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND etiqueta = '"+etiqueta+"'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND etiqueta = '"+etiqueta+"'";
      break;
    case 4: // Año, Estatus
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND estatus = '"+estatus+"'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND estatus = '"+estatus+"'";
      break;
    case 5: // Año, Acuerdo
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND acuerdo LIKE '%"+acuerdo+"%' ";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND acuerdo LIKE '%"+acuerdo+"%' ";
      break;
    case 6: // Año, Título, Etiqueta
      consulta =  "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%' AND etiqueta = '"+etiqueta+"'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%' AND etiqueta = '"+etiqueta+"'";
      break;
    case 7: // Año, Título, Etiqueta, Estatus
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%' AND etiqueta = '"+etiqueta+"' AND estatus = '"+estatus+"'"; // % cualquier valor antes o despues de lo que escribes.
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%' AND etiqueta = '"+etiqueta+"' AND estatus = '"+estatus+"'";
      break;
    case 8: // Año, Titulo, Etiqueta, Estatus, Acuerdo
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%' AND etiqueta = '"+etiqueta+"' AND estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%' AND etiqueta = '"+etiqueta+"' AND estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      break;
    case 9: // Año, Título, Etiqueta, Acuerdo
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%' AND etiqueta = '"+etiqueta+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%' AND etiqueta = '"+etiqueta+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      break;
    case 10: // Año, Título, Estatus
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%' AND estatus = '"+estatus+"'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%' AND estatus = '"+estatus+"'";
      break;
    case 11: // Año, Titulo, Estatus, Acuerdo
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%' AND estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%' AND estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      break;
    case 12: // Año, Título, Acuerdo
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%' AND acuerdo LIKE '%"+acuerdo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%' AND acuerdo LIKE '%"+acuerdo+"%'";
      break;
    case 13: // Año, Etiqueta, Acuerdo
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND etiqueta = '"+etiqueta+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND etiqueta = '"+etiqueta+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      break;
    case 14: // Año, Estatus, Etiqueta
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND estatus = '"+estatus+"' AND etiqueta = '"+etiqueta+"'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND estatus = '"+estatus+"' AND etiqueta = '"+etiqueta+"'";
      break;
    case 15: // Año, Estatus, Etiqueta, Acuerdo
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND estatus = '"+estatus+"' AND etiqueta = '"+etiqueta+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND estatus = '"+estatus+"' AND etiqueta = '"+etiqueta+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      break;
    case 1515: // Año, Estatus, Acuerdo
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      break;
    case 16: // Etiqueta
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"'";
      break;
    case 17: // Etiqueta, Título
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%'";
      break;
    case 18: // Etiqueta, Estatus
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND estatus = '"+estatus+"'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND estatus = '"+estatus+"'";
      break;
    case 19: // Etiqueta, Acuerdo
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      break;
    case 20: // Etiqueta, Rango
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+" AND etiqueta = '"+etiqueta+"'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+" AND etiqueta = '"+etiqueta+"'";
      break;
    case 21: // Etiqueta, Título, Acuerdo
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%' AND acuerdo LIKE '%"+acuerdo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%' AND acuerdo LIKE '%"+acuerdo+"%'";
      break;
    case 22: // Etiqueta, Título, Rango
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+" AND etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) > "+init+" OR year(fecha_acta) = "+init+" AND year(fecha_acta) < "+finish+" OR year(fecha_acta) = "+finish+" AND etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%'";
      break;
    case 23: // Etiqueta, Título, Estatus
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%' AND estatus = '"+estatus+"'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%' AND estatus = '"+estatus+"'";
      break;
    case 24: // Etiqueta, Título, Estatus, Acuerdo
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%' AND estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%' AND estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      break;
    case 25: // Etiqueta, Título, Estatus, Acuerdo, Año --> Año, etiqueta, titulo, estatus, acuerdo
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%' AND estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) = "+fecha+"";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%' AND estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) = "+fecha+"";
      break;
    case 26: // Etiqueta, Título, Estatus, Acuerdo, Rango
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%' AND estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%' AND estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      break;
    case 27: // Etiqueta, Título, Estatus, Rango
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%' AND estatus = '"+estatus+"' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%' AND estatus = '"+estatus+"' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      break;
    case 28: // Etiqueta, Título, Acuerdo, Rango
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      break;
    case 29: // Etiqueta, Estatus, Titulo
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND estatus = '"+estatus+"' AND titulo LIKE '%"+titulo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND estatus = '"+titulo+"' AND acuerdo LIKE '%"+titulo+"%'";
      break;
    case 30: // Etiqueta, Estatus, Acuerdo
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      break;
    case 31: // Etiqueta, Estatus, Acuerdo, Rango
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      break;
    case 32: // Etiqueta, Estatus, Rango
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND estatus = '"+estatus+"' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND estatus = '"+estatus+"' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      break;
    case 33: // Etiqueta, Acuerdo, Rango
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      break;
    case 34: // Estatus
      consulta = "SELECT * FROM acuerdos WHERE estatus = '"+estatus+"'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE estatus = '"+estatus+"'";
      break;
    case 35: // Estatus, Título
      consulta = "SELECT * FROM acuerdos WHERE estatus = '"+estatus+"' AND titulo LIKE '%"+titulo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE estatus = '"+estatus+"' AND titulo LIKE '%"+titulo+"%'";
      break;
    case 36: // Estatus, Título, Acuerdo
      consulta = "SELECT * FROM acuerdos WHERE estatus = '"+estatus+"' AND titulo LIKE '%"+titulo+"%' AND acuerdo LIKE '%"+acuerdo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE estatus = '"+estatus+"' AND titulo LIKE '%"+titulo+"%' AND acuerdo LIKE '%"+acuerdo+"%'";
      break;
    case 37: // Estatus, Título, Acuerdo, Año //######## INNECESARIA ########## = CASE 11
      consulta = "SELECT * FROM acuerdos WHERE estatus = '"+estatus+"' AND titulo LIKE '%"+titulo+"%' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) = "+fecha+"";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE estatus = '"+estatus+"' AND titulo LIKE '%"+titulo+"%' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) = "+fecha+"";
      break;
    case 38: // Estatus, Título, Acuerdo, Rango
      consulta = "SELECT * FROM acuerdos WHERE estatus = '"+estatus+"' AND titulo LIKE '%"+titulo+"%' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE estatus = '"+estatus+"' AND titulo LIKE '%"+titulo+"%' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      break;
    case 39: // Estatus, Título, Rango
      consulta = "SELECT * FROM acuerdos WHERE estatus = '"+estatus+"' AND titulo LIKE '%"+titulo+"%' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE estatus = '"+estatus+"' AND titulo LIKE '%"+titulo+"%' AND year(fecha_acta) >= "+init+" OR year(fecha_acta) = "+init+" AND year(fecha_acta) <= "+finish+"";
      break;
    case 40: // Estatus, Acuerdo
      consulta = "SELECT * FROM acuerdos WHERE estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%'";
      break;
    case 41: // Estatus, Acuerdo, Rango
      consulta = "SELECT * FROM acuerdos WHERE estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE estatus = '"+estatus+"' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      break;
    case 42: // Estatus, Rango
      consulta = "SELECT * FROM acuerdos WHERE estatus = '"+estatus+"' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE estatus = '"+estatus+"' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      break;
    case 43: // Título
      consulta = "SELECT * FROM acuerdos WHERE titulo LIKE '%"+titulo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE titulo LIKE '%"+titulo+"%'";
      break;
    case 44: // Título, Acuerdo
      consulta = "SELECT * FROM acuerdos WHERE titulo LIKE '%"+titulo+"%' AND acuerdo LIKE '%"+acuerdo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE titulo LIKE '%"+titulo+"%'";
      break;
    case 45: // Título, Acuerdo, Rango
      consulta = "SELECT * FROM acuerdos WHERE titulo LIKE '%"+titulo+"%' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE titulo LIKE '%"+titulo+"%' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      break;
    case 46: // Título, Acuerdo, Año == Año, título, acuerdo == 12
      consulta = "SELECT * FROM acuerdos WHERE titulo LIKE '%"+titulo+"%' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) = "+fecha+"";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE titulo LIKE '%"+titulo+"%' AND acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) = "+fecha+"";
      break;
    case 47: // Título, Rango
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+" AND titulo LIKE '%"+titulo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+" AND titulo LIKE '%"+titulo+"%'";
      break;
    case 48: // Acuerdo
      consulta = "SELECT * FROM acuerdos WHERE acuerdo LIKE '%"+acuerdo+"%'";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE acuerdo LIKE '%"+acuerdo+"%'";
      break;
    case 49: // Acuerdo, Rango
      consulta = "SELECT * FROM acuerdos WHERE acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE acuerdo LIKE '%"+acuerdo+"%' AND year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      break;
    case 50: // Rango
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      consulta2 = "SELECT id, titulo, acuerdo, etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) >= "+init+" AND year(fecha_acta) <= "+finish+"";
      break;

  }

  /**************** ENVÍO A PÁGINA DE CREACIÓN DE TABLA ***********************/
  $.ajax({
    url: "../consejo_tecnico/fragmentos/tabla_acuerdos.php",
    data: {"query":consulta, "query2":consulta2, "pag":pag},
    type: "post",
    success: function(data){
      //alert("Mostrando resultados");
      document.getElementById("tabla_acuerdos").innerHTML = data;
    }
  });


}

/*------------------------------------------------------------------------------
-------------------------CONTROL DE OFICIOS ----------------------------------
-----------------------------------------------------------------------------*/

function add_oficio(){
  //alert("Registrando oficio");

  var formData = new FormData(document.getElementById("frm_oficio"));

  formData.append('funcion', 0);

  $.ajax({
      url: "../consejo_tecnico/conexiones/oficios.php",
      data: formData,
      type: "post",
      contentType: false,
      processData: false,
      success: function(data){
        alert("Oficio registrado"+data);
        document.getElementById("form_add_oficio").innerHTML = '<div class="row" style="width:80%; margin:auto; margin-top: 10%; background-color:#BCF5A9; border-radius:4px; "><div class="col-xs-5" style="padding:20px;"><img src="imagenes/success.png" style="width:100px; height:auto"/></div><div class="col-xs-7" style="padding:15px"><br><center><p style="font-size: 1.3em; color: #0B3B0B">Oficio registrado correctamente</p><input data-toggle="modal" data-target="#add_seguimiento" type="button" class="btn btn-warning" value="Agregar seguimiento"><form action="oficios.php?pag=0" method="get" style="display:inline-block"><input type="submit" class="btn btn-danger" style="margin-left: 15px; display:inline-block;" value="Agregar después"></form>';
        window.scrollTo(0, 0);
      },
      failure: function(){
        alert("Error al registrar oficio"+data);
      }
    });

}

function add_seguimiento(){

  var formData = new FormData(document.getElementById("frm_seguimiento"));
  formData.append('funcion', 2);


  $.ajax({
    url: "../consejo_tecnico/conexiones/oficios.php",
    data: formData,
    type: "post",
    contentType: false,
    processData: false,
    success: function(data){
      //alert("Información de seguimiento registrado!!!!!"+data);
      document.getElementById("frm_seguimiento").reset();
      /*document.getElementById("footer-seguimiento").innerHTML = ''+
        '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>'
        '<button type="button" class="btn btn-primary" onclick="add_seguimiento()">Guardar</button>';*/

    },
    failure: function(){
      alert("Error al registrar seguimiento"+data);
    }
  });

}

function add_seguimiento2(){ //Se usa este método cuando se especifica el id del oficio

  //alert("registrando seguimiento 2");
  var formData = new FormData(document.getElementById("frm_seguimiento2"));
  formData.append('funcion', 4);

  $.ajax({
    url: "../consejo_tecnico/conexiones/oficios.php",
    data: formData,
    type: "post",
    contentType: false,
    processData: false,
    success: function(data){
      alert("Información de seguimiento registrado!!!!!"+data);
      document.getElementById("frm_seguimiento2").reset();

    },
    failure: function(){
      alert("Error al registrar seguimiento"+data);
    }
  });

}


function show_anexos(id_oficio){
  // Coloca el contenido PHP en el div de la ventana Modal
  // para ver los archivos anexados del oficio
  var id = id_oficio;

  $.ajax({
    url: "../consejo_tecnico/fragmentos/modal_anexos.php",
    data: {"id":id},
    type: "post",
    success: function(data){
      document.getElementById("modal_anexos").innerHTML = data;
      $("#oficio_anexos").modal('show');
    }
  });
}

function show_seguimiento(id_oficio){
  // Coloca el contenido PHP en el div de la ventana modal
  // para ver los archivos anexados del oficio

  var id = id_oficio;

  $.ajax({
    url: "../consejo_tecnico/fragmentos/modal_seguimiento.php",
    data: {"id":id},
    type: "post",
    success: function(data){
      document.getElementById("modal_seguimiento").innerHTML = data;
      $("#tabla_seguimiento").modal('show');
    }
  });
}

function show_add_seguimiento(id_oficio){
  // Coloca el contenido PHP en el div de la ventana modal
  // para registrar nueva información en la tabla de seguimiento del oficio

  var id = id_oficio;

  $.ajax({
    url: "../consejo_tecnico/fragmentos/modal_add_seguimiento.php",
    data: {"id":id},
    type: "post",
    success: function(data){
      document.getElementById("modal_add_seguimiento").innerHTML = data;
      $("#add_seguimiento").modal('show');
    }
  });

}

function editar_oficio(id_oficio){

  var id = id_oficio;

  var formData = new FormData(document.getElementById("frm_edit_oficio"));
  formData.append('funcion', 5);
  formData.append('id', id);

  $.ajax({
    url: "../consejo_tecnico/conexiones/oficios.php",
    data: formData,
    type: "post",
    contentType: false,
    processData: false,
    success: function(data){
      alert("Oficio modificado" + data);
    }
  });

}


function busqueda_oficios(){
  //alert("entra busqueda oficios");
  var pag = $("#pag_oficios").val();

  var formData = new FormData(document.getElementById("frm_src_oficios"));
  formData.append('pag', pag);

  $.ajax({
    url: "../consejo_tecnico/fragmentos/tabla_oficios.php",
    data: formData,
    type: "post",
    contentType: false,
    processData: false,
    success: function(data){
      document.getElementById("result_oficios").innerHTML = data;

    },
    failure: function(){
      alert("Error al registrar seguimiento"+data);
    }
  });

}

function delete_file_anexos(ID){
  var id=ID;
  var func = 3;
  eleccion = confirm("¿Seguro que quiere eliminar el archivo "+ID+"?");
  if(eleccion){
    $.ajax({
       url: "../consejo_tecnico/conexiones/oficios.php",
       data: {"id":id,"funcion":func},
       type: "post",
        success: function(data){
            //alert("Eliminando acta");
            alert("Archivo anexo eliminado correctamente ");
            $("#oficio_anexos").modal('hide');
        },
        failure: function(){
          alert("No se ha podido eliminar el archivo");
        }
      });

  }
}

function delete_oficio(id_oficio){

  //alert("Eliminando archivo");

  var id = id_oficio;

  $.ajax({
    url: "../consejo_tecnico/conexiones/oficios.php",
    data: {"id":id, "funcion": 6},
    type: "post",
    success: function(data){
      alert("Oficio eliminado correctamente ");
      location.reload();
    }
  });

}

function add_dependencia(){
  var dependencia = $("#new_dependencia").val();

  $.ajax({
     url: "../consejo_tecnico/conexiones/oficios.php",
     data: {"dependencia":dependencia,"funcion":7},
     type: "post",
      success: function(data){
          alert("Registrando dependencia"+data);
        //  $("#etiqueta").load('../consejo_tecnico/fragmentos/etiquetas.php'); // Volver a colocar el select de etiquetas actualizado
        //  Se intentó cargar mediante ajax pero hay un problema externo con el select de bootstrap, que no se puede cambiar el display: none. :c
        //  mejor hacerlo de manera tradicional, refrescando página y recargando los valores anteriores para evitar pérdida de información.
          location.reload();
        }
      });
}
