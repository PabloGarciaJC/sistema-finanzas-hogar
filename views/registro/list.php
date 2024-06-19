<!-- Tabla Registro -->
<div class="bs-example4" data-example-id="simple-responsive-table" style="text-align: center;">
  <!-- Buscador -->
  <input type="search" placeholder="Busca ingresos del mes.. Aqui !" id="buscadorRegistro" />
  <!-- /Buscador -->
  <div class="table-responsive" id="tablaRegistro">
  </div>
</div>

<!-- Modal Crear -->
<div class="modal fade" id="modalCrearRegistro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Crear Registro</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form id="crearFormularioRegistro"
          class="form-floating ng-pristine ng-invalid ng-invalid-required ng-valid-email ng-valid-url ng-valid-pattern"
          novalidate="novalidate">
          <fieldset>

            <div id="crearRegistroPeticionAjax" style="display: none;"></div>

            <div class="form-group" id="claseCrearIngresoVeronicaR" style="padding-bottom: 14px;">
              <label class="control-label navbar-left"><strong>Ingresos Veronica</strong></label>
              <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="crearIngresoVeronicaR">
              <label class="navbar-left" id="idMensajeErrorIngresosVeronicaCrear" style="color: red;"></label>
            </div>

            <div class="form-group" id="claseCrearIngresoPabloR" style="padding-bottom: 14px;">
              <label class=" control-label navbar-left"><strong>Ingresos Pablo</strong></label>
              <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="crearIngresoPabloR">
              <label class="navbar-left" id="idMensajeErrorIngresoPabloCrear" style="color: red;"></label>
            </div>

            <div class="form-group" id="claseCrearIngresoExtraR" style="padding-bottom: 14px;">
              <label class="control-label navbar-left"><strong>Ingresos Extra</strong></label>
              <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="crearIngresoExtraR">
              <label class="navbar-left" id="idMensajeErrorIngresoExtraCrear" style="color: red;"></label>
            </div>

            <div class="form-group" id="claseCrearAhorrosR" style="padding-bottom: 14px;">
              <label class="control-label navbar-left"><strong>Ahorros</strong></label>
              <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="crearAhorrosR">
              <label class="navbar-left" id="idMensajeErrorAhorrosCrear" style="color: red;"></label>
            </div>

            <div class="form-group" id="claseCrearMesR" style="padding-bottom: 14px;">
              <label class="control-label navbar-left"><strong>Mes</strong></label>
              <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="crearMesR">
              <label class="navbar-left" id="idMensajeErrorMesCrear" style="color: red;"></label>
            </div>

            <div class="form-group" id="claseCrearYearR">
              <label class="control-label navbar-left"><strong>Año</strong></label>
              <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="crearYearR">
              <label class="navbar-left" id="idMensajeErrorYearCrear" style="color: red;"></label>
            </div>
            <br>
          </fieldset>

          <div class="modal-footer">
            <!-- data-dismiss="modal" -->
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="btnCrear">Aceptar</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<!-- Modal Editar -->
<div class="btn-group">
  <div class="modal fade" id="modalEditarRegistro" tabindex="-1" role="dialog" aria-labelledby="btneditarTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Editar Registro</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- Formulario Inicial -->
        <div class="modal-body">
          <form id="editarFormularioRegistro"
            class="form-floating ng-pristine ng-invalid ng-invalid-required ng-valid-email ng-valid-url ng-valid-pattern"
            novalidate="novalidate">
            <fieldset>

              <div id="editarRegistroPeticionAjax" style="display:none"></div>

              <input type="hidden" class="form-control1 ng-invalid ng-invalid-required" id="editarIdRegistro">
              <input type="hidden" class="form-control1 ng-invalid ng-invalid-required" id="editarPaginaActual">

              <div class="form-group" id="claseEditIngresoVeronicaR" style="padding-bottom: 14px;">
                <label class="control-label navbar-left"><strong>Ingresos Veronica</strong></label>
                <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="editarIngresoVeronicaR">
                <label class="navbar-left" id="idMensajeErrorIngresosVeronicaEditar" style="color: red;"></label>
              </div>

              <div class="form-group" id="claseEditIngresoPabloR" style="padding-bottom: 14px;">
                <label class=" control-label navbar-left"><strong>Ingresos Pablo</strong></label>
                <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="editarIngresoPabloR">
                <label class="navbar-left" id="idMensajeErrorIngresoPabloEditar" style="color: red;"></label>
              </div>

              <div class="form-group" id="claseEditIngresoExtraR" style="padding-bottom: 14px;">
                <label class="control-label navbar-left"><strong>Ingresos Extra</strong></label>
                <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="editarIngresoExtraR">
                <label class="navbar-left" id="idMensajeErrorIngresoExtraEditar" style="color: red;"></label>
              </div>

              <div class="form-group" id="claseEditAhorrosR" style="padding-bottom: 14px;">
                <label class="control-label navbar-left"><strong>Ahorros</strong></label>
                <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="editarAhorrosR" value="0">
                <label class="navbar-left" id="idMensajeErrorAhorrosEditar" style="color: red;"></label>
              </div>

              <div class="form-group" id="claseEditMesR" style="padding-bottom: 14px;">
                <label class="control-label navbar-left"><strong>Mes</strong></label>
                <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="editarMesR">
                <label class="navbar-left" id="idMensajeErrorMesEditar" style="color: red;"></label>
              </div>

              <div class="form-group" id="claseEditYearR">
                <label class="control-label navbar-left"><strong>Año</strong></label>
                <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="editarYearR">
                <label class="navbar-left" id="idMensajeErrorYearEditar" style="color: red;"></label>
              </div>
              <br>
            </fieldset>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="btnEditarRegistro">Aceptar</button>
            </div>
          </form>
        </div>
        <!-- //Formulario Final -->
      </div>
    </div>
  </div>
</div>

<!-- Modal Eliminar -->
<div class="btn-group">
  <div class="modal fade" id="modalEliminarRegistro" tabindex="-1" role="dialog" aria-labelledby="btneliminarTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="btneliminarTitle">Eliminar Registro</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST"
            class="form-floating ng-pristine ng-invalid ng-invalid-required ng-valid-email ng-valid-url ng-valid-pattern"
            novalidate="novalidate" ng-submit="submit()">
            <fieldset>

              <input type="hidden" class="form-control1 ng-invalid ng-invalid-required" id="eliminarIdRegistro">
              <input type="hidden" class="form-control1 ng-invalid ng-invalid-required" id="eliminarPaginaActual">

              <div class="form-group" style="padding-bottom: 14px;">
                <label class="control-label navbar-left"><strong>Mes</strong></label>
                <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="eliminarMesR" disabled>
                <label class="navbar-left" id="mensajeErrorR" style="color: red;"></label>
              </div>

              <div class="form-group" style="padding-bottom: 14px;">
                <label class="control-label navbar-left claseEliminarYeardR"><strong>Año</strong></label>
                <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="eliminarYearR" disabled>
                <label class="navbar-left" id="mensajeErrorR" style="color: red;"></label>
              </div>
              <br>
            </fieldset>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-warning" id="btnEliminarRegistro">Eliminar</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>