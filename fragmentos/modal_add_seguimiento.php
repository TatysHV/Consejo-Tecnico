<?php
  include '../conexiones/conexion.php';

  $id_oficio = $_POST['id'];


  echo '

    <div class="modal fade" id="add_seguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <center><h4 class="modal-title">Registro de seguimiento</h4></center>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="frm_seguimiento2" encrypte="multipart/form-data" method="POST" class="forma">
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <label>Turnado a:</label>
                    <input type="text" class="form-control" id="" name="turnadoA"/>
                    <input type="hidden" class="form-control" value="'.$id_oficio.'" name="id_oficio"/>
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                    <label>Dependencia:</label>
                    <select class="form-control" data-width="100%" name="dependencia">
                      <option value="Secretaría académica">Secretaría académica</option>
                      <option value="Secretaría de investigación y posgrado">Secretaría de investigación y posgrado</option>
                      <option value="Secretaría de vinculación">Secretaría de vinculación</option>
                      <option value="Servicios escolares">Servicios escolares</option>
                      <option value="Otro departamento">Otro departamento</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <label>Responsable:</label>
                    <input type="text" class="form-control" id="" name="responsable"/>
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                    <label>Observaciones:</label>
                    <input type="textarea" rows="5" class="form-control" id="" name="observaciones"/>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <label>Tipo: </label>
                    <select class="form-control" data-width="100%" name="tipo">
                      <option value="seguimiento">En seguimiento</option>
                      <option value="modificacion">Solicitud de modificación</option>
                      <option value="completado">Completado</option>
                      <option value="copia">Copia de conocimiento</option>
                    </select>
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                    <label>Fecha: </label>
                    <input type="date" class="form-control" id="" name="fecha" style="width:100%; border: 1px solid #CCC;"/>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6">
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                    <label>Oficios respuesta</label>
                    <input type="file" name="seguimiento[]" class="file" style="width: 95%; height: 34px; border: 1px solid #CCC"/>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" onclick="add_seguimiento2()">Guardar</button>
          </div>
        </div>
      </div>
    </div>';

 ?>
