
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
        alert("Punto registrado correctamente");
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

  var lista = document.getElementById("perteneceAC");
  var indice = lista.selectedIndex;
  var opcion = lista.options[indice];
  var pertenece = opcion.value;


  //------------ Salvar valores escritos en formulario --------
  var titulo = $("#titulo_acuerdo").val();
  var fecha = $("#fecha_acuerdo").val();
  var acuerdo = $("#acuerdo").val();
  var observaciones = $("#observaciones").val();
  var estatus = $("#estatus").val();

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
          alert("nofunciona");
          $("#titulo_acuerdo").val(titulo);
          $("#fecha_acuerdo").val(fecha);
          $("#acuerdo").val(acuerdo);
          $("#observaciones").val(observaciones);
          $("#estatus").val(estatus);

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
            alert("Acuerdo registrado correctamente"+data);
            //window.location.assign("../consejo_tecnico/normatividad.php");
          },
          failure: function(){
            alert("Error al registrar acuerdo. "+data);
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
            alert("Modificación registrada correctamente"+data);
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
function bloqueo_años(){

}

function change_page(pag){
    $("#pag_acuerdos").val(pag);
    busqueda_acuerdos();
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

function busqueda_acuerdos(){

  var fecha = $("#srch_year").val();
  var etiqueta = $("#srch_etiqueta").val();
  var titulo = $("#srch_titulo").val();

  var init = $("#srch_init").val();
  var finish = $("#srch_finish").val();


//****************Identifica el tipo de búsqueda y combinaciones ***************
 /* Índice de combinaciones disponibles de búsqueda
 1. Año
 2. Año, Título
 3. Año, Etiqueta
 4. Año, Título, Etiqueta

 5. Etiqueta
 6. Etiqueta, Título

 7. Título

 8. Rango
 9. Rango, Etiqueta
 10. Rango, Título
 11. Rango, Etiqueta, Título

 */

  var nivel_busqueda = 0;

  if(fecha!=""){
      if(etiqueta!=""){
          if(titulo!=""){
            nivel_busqueda = 4; //Fecha, etiqueta, titulo
          }
          else{
             nivel_busqueda = 3; //Fecha, etiqueta
          }
      }
      else if(titulo!=""){
        nivel_busqueda = 2;//Fecha, titulo
      }
      else if(etiqueta==""&&titulo==""){
          nivel_busqueda = 1; //Fecha
      }

  }//***************************************************************************
  else if(init!="" && finish!="") {
      if(etiqueta!=""){
          if(titulo!=""){ // Rango, etiqueta, titulo
              nivel_busqueda = 11;
          }
          else{
              nivel_busqueda = 9;// Rango, etiqueta
          }
      }
      else if (titulo!="") {
          nivel_busqueda = 10; // Rango, título
      }
      else if (etiqueta==""&&titulo=="") {
          nivel_busqueda = 8; // Rango
      }
  }/***************************************************************************/
  else if(etiqueta!="") {
      if(fecha!=""){
          if(titulo!=""){ // Etiqueta, fecha, titulo
              nivel_busqueda = 4;
          }
          else{
            nivel_busqueda = 3; // Etiqueta, fecha
          }
      }
      else if (titulo!="") { // Etiqueta, titulo
        nivel_busqueda = 6;
      }
      else if (fecha==""&&titulo=="") {
          nivel_busqueda = 5; // Etiqueta
      }
  }//***************************************************************************
  else if(titulo!="") {
      if(fecha!=""){
          if(etiqueta!=""){ // Titulo, fecha, etiqueta
              nivel_busqueda = 4;
          }else{
            nivel_busqueda = 2; // Titulo, fecha
          }
      }
      else if (etiqueta!="") {
        nivel_busqueda = 6; // Titulo, etiqueta
      }
      else if (fecha==""&&etiqueta=="") {
        nivel_busqueda = 7; // Titulo
      }
  }//***************************************************************************


  var consulta ="";

  var pag = $("#pag_acuerdos").val();
  var cantidad = 2; // cantidad de resultados por página
  var inicial = pag * cantidad;


  switch (nivel_busqueda){
    case 1: // Año
      alert("búsqueda por año");
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+"";
      consulta2 = "SELECT id,titulo,acuerdo,etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+""; 
      break;
    case 2: // Año, Título
      alert("búsqueda por año y titulo");
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%'";
      consulta2 = "SELECT id,titulo,acuerdo,etiqueta,estatus,tipo,numero_sesion,fecha_acta,observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%'";
      break;
    case 3: // Año, Etiqueta
      alert("búsqueda por año y etiqueta");
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND etiqueta = '"+etiqueta+"'";
      consulta2 = "SELECT id,titulo,acuerdo,etiqueta,estatus,tipo,numero_sesion,fecha_acta,observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND etiqueta = '"+etiqueta+"'";      
      break;
    case 4: // Año, Título, Etiqueta
      alert("búsqueda por año, titulo, etiqueta");
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%' AND etiqueta = '"+etiqueta+"' ";
      consulta2 = "SELECT id,titulo,acuerdo,etiqueta,estatus,tipo,numero_sesion,fecha_acta,observaciones FROM acuerdos WHERE year(fecha_acta) = "+fecha+" AND titulo LIKE '%"+titulo+"%' AND etiqueta = '"+etiqueta+"' ";
      break;
    case 5: // Etiqueta
      alert("búsqueda por etiqueta");
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"' ";
      consulta2 = "SELECT id,titulo,acuerdo,etiqueta,estatus,tipo,numero_sesion,fecha_acta,observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"' "; 
      break;
    case 6: // Etiqueta, Titulo
      alert("búsqueda por etiqueta y titulo");
      consulta = "SELECT * FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%'";
      consulta2 = "SELECT id,titulo,acuerdo,etiqueta,estatus,tipo,numero_sesion,fecha_acta,observaciones FROM acuerdos WHERE etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%'";
      break;
    case 7: // Titulo
      alert("búsqueda por titulo");
      consulta = "SELECT * FROM acuerdos WHERE titulo LIKE '%"+titulo+"%' "; // % cualquier valor antes o despues de lo que escribes.
      consulta2 = "SELECT id,titulo,acuerdo,etiqueta,estatus,tipo,numero_sesion,fecha_acta,observaciones FROM acuerdos WHERE titulo LIKE '%"+titulo+"%' ";
      break;
    case 8: // Rango
      alert("búsqueda por rango");
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) > "+init+" OR year(fecha_acta) = "+init+" AND year(fecha_acta) < "+finish+" OR year(fecha_acta) = "+finish+"";
      consulta2 = "SELECT id,titulo,acuerdo,etiqueta,estatus,tipo,numero_sesion,fecha_acta,observaciones FROM acuerdos WHERE year(fecha_acta) > "+init+" OR year(fecha_acta) = "+init+" AND year(fecha_acta) < "+finish+" OR year(fecha_acta) = "+finish+"";
      break;
    case 9: // Rango, Etiqueta
      alert("búsqueda por rango y etiqueta");
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) > "+init+" OR year(fecha_acta) = "+init+" AND year(fecha_acta) < "+finish+" OR year(fecha_acta) = "+finish+" AND etiqueta = '"+etiqueta+"'";
      consulta2 = "SELECT id,titulo,acuerdo,etiqueta,estatus,tipo,numero_sesion,fecha_acta,observaciones FROM acuerdos WHERE year(fecha_acta) > "+init+" OR year(fecha_acta) = "+init+" AND year(fecha_acta) < "+finish+" OR year(fecha_acta) = "+finish+" AND etiqueta = '"+etiqueta+"'";
      break;
    case 10: // Rango, Titulo
      alert("búsqueda por rango y titulo");
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) > "+init+" OR year(fecha_acta) = "+init+" AND year(fecha_acta) < "+finish+" OR year(fecha_acta) = "+finish+" AND titulo LIKE '%"+titulo+"%'";
      consulta2 = "SELECT id,titulo,acuerdo,etiqueta,estatus,tipo,numero_sesion,fecha_acta,observaciones FROM acuerdos WHERE year(fecha_acta) > "+init+" OR year(fecha_acta) = "+init+" AND year(fecha_acta) < "+finish+" OR year(fecha_acta) = "+finish+" AND titulo LIKE '%"+titulo+"%'";
      break;
    case 11: // Rango, Etiqueta, Titulo
      alert("búsqueda por rango, etiqueta y titulo");
      consulta = "SELECT * FROM acuerdos WHERE year(fecha_acta) > "+init+" OR year(fecha_acta) = "+init+" AND year(fecha_acta) < "+finish+" OR year(fecha_acta) = "+finish+" AND etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%'";
      consulta2 = "SELECT id,titulo,acuerdo,etiqueta,estatus,tipo,numero_sesion,fecha_acta,observaciones FROM acuerdos WHERE year(fecha_acta) > "+init+" OR year(fecha_acta) = "+init+" AND year(fecha_acta) < "+finish+" OR year(fecha_acta) = "+finish+" AND etiqueta = '"+etiqueta+"' AND titulo LIKE '%"+titulo+"%'";
      break;
  }

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
