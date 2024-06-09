<!-- Banner de Cuentas One -->
<div class="graphs">
  <div class="col_3">
    <div class="col-md-3 widget widget1">
      <div class="r3_counter_box">
        <i class="pull-left fa fa-dollar dollar1 icon-rounded"></i>
        <div class="stats">
          <h5 id="ingresosTotales"></h5>
          <span>Ingresos Totales</span>
        </div>
      </div>
    </div>

    <div class="col-md-3 widget widget1">
      <div class="r3_counter_box">
        <i class="pull-left fa fa-dollar dollar1 icon-rounded"></i>
        <div class="stats">
          <h5 id="dineroRestante"></h5>
          <span>Dinero Restante</span>
        </div>
      </div>
    </div>

    <div class="col-md-3 widget widget1">
      <div class="r3_counter_box">
        <i class="pull-left fa fa-dollar dollar1 icon-rounded"></i>
        <div class="stats">
          <h5 id="ahorros"></h5>
          <span>Ahorros</span>
        </div>
      </div>
    </div>

    <div class="col-md-3 widget widget1">
      <div class="r3_counter_box">
        <i class="pull-left fa fa-dollar user1 icon-rounded"></i>
        <div class="stats">
          <h5 id="deudasPorPagar"></h5>
          <span>Deudas por Pagar</span>
        </div>
      </div>
    </div>

    <div class="clearfix"> </div>
  </div>
</div>

<div class="graphs">
  <div class="col_3">

    <div class="col-md-3 widget widget1">
      <div class="r3_counter_box">
        <i class="pull-left fa fa-dollar user1 icon-rounded"></i>
        <div class="stats">
          <h5 id="deudasGlobales"></h5>
          <span>Deudas Globales</span>
        </div>
      </div>
    </div>

    <div class="col-md-3 widget widget1">
      <div class="r3_counter_box">
        <i class="pull-left fa fa-dollar user1 icon-rounded"></i>
        <div class="stats">
          <h5 id="gastosCarrefour"></h5>
          <span>Carrefour</span>
        </div>
      </div>
    </div>

    <div class="col-md-3 widget widget1">
      <div class="r3_counter_box">
        <i class="pull-left fa fa-dollar user1 icon-rounded"></i>
        <div class="stats">
          <h5 id="gastosServicios"></h5>
          <span>Servicios</span>
        </div>
      </div>
    </div>

    <div class="col-md-3 widget widget1">
      <div class="r3_counter_box">
        <i class="pull-left fa fa-dollar user1 icon-rounded"></i>
        <div class="stats">
          <h5 id="gastosDeudas"></h5>
          <span>Deudas</span>
        </div>
      </div>
    </div>
    <div class="clearfix"> </div>
  </div>
</div>

<!-- Obtengo el id Registro Por Get-->
<input type="hidden" id="idRegistro" value="<?= $idRegistro ?>">

<!-- Tabla Historial -->
<div class="bs-example4" data-example-id="simple-responsive-table" style="text-align: center;">

  <!-- Buscador -->
  <input type="search" placeholder="Busca servicios y deudas.. Aqui !" id="buscadorHistorial" />

  <!-- Listar Tabla -->
  <div class="table-responsive" id="tablaHistorial">
  </div>

</div>

<!-- Modal Crear Historial -->
<div class="modal fade" id="modalHistorial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Crear Historial</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form id="crearFormularioHistorial" class="form-floating ng-pristine ng-invalid ng-invalid-required ng-valid-email ng-valid-url ng-valid-pattern" novalidate="novalidate">
          <fieldset>

            <div id="historialPeticionAjax" style="display: none;"></div>

            <div class="form-group" style="padding-bottom: 14px;">
              <label class="control-label navbar-left"><strong>Nombre</strong></label>
            </div>

            <select class="form-control" id="crearNombreHistorial">
              <option selected>Selecione Aqui...</option>
              <option>Carrefour</option>
              <option>Servicios</option>
              <option>Deudas</option>
            </select>
            <br>

            <div class="form-group" id="claseCrearDescripcionHistorial" style="padding-bottom: 14px;">
              <label class="control-label navbar-left"><strong>Descripción</strong></label>
              <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="crearDescripcionHistorial">
              <label class="navbar-left" id="mensajeErrorDescripcion" style="color: red;"></label>
            </div>

            <div class="form-group" id="claseCrearGastosHistorial" style="padding-bottom: 14px;">
              <label class="control-label navbar-left"><strong>Gastos</strong></label>
              <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="crearGastosHistorial">
              <label class="navbar-left" id="mensajeErrorGastos" style="color: red;"></label>
            </div>

            <div class="form-group" id="claseCrearFechaCorteHistorial" style="padding-bottom: 14px;">
              <label class="control-label navbar-left"><strong>FechaCorte</strong></label>
              <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="crearFechaCorteHistorial">
              <label class="navbar-left" id="mensajeErrorFechaCorte" style="color: red;"></label>
            </div>

            <div class="form-group">
              <label class="control-label navbar-left"><strong>Selecciona el Estatus</strong></label>
            </div>
            <select class="form-control" name="statusCrearHistorial[]" id="statusCrearHistorial">
              <option name="status">PENDIENTE</option>
              <option name="status">PAGADO</option>
            </select>
            <br>

          </fieldset>

          <div class="modal-footer">
            <!-- data-dismiss="modal" -->
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="btnCrearHistorial">Aceptar</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditarHistorial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Editar Historial</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form id="editarFormularioConfig" class="form-floating ng-pristine ng-invalid ng-invalid-required ng-valid-email ng-valid-url ng-valid-pattern" novalidate="novalidate">
          <fieldset>

            <div id="editPeticionAjaxHistorial" style="display: none;"></div>

            <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="idHistorial" style="display: none;">

            <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="editPaginaActualHistorial" style="display: none;">

            <div class="form-group">
              <label class="control-label navbar-left"><strong>Nombre</strong></label>
            </div>

            <select class="form-control" id="editNombreHistorial">
              <option>Carrefour</option>
              <option>Servicios</option>
              <option>Deudas</option>
            </select>

            <br>

            <div class="form-group" id="claseEditDescripcionHistorial" style="padding-bottom: 14px;">
              <label class="control-label navbar-left"><strong>Descripción</strong></label>
              <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="editDescripcionHistorial">
              <label class="navbar-left" id="mensajeErrorDescripcion" style="color: red;"></label>
            </div>

            <div class="form-group" id="claseEditGastosHistorial" style="padding-bottom: 14px;">
              <label class="control-label navbar-left"><strong>Gastos</strong></label>
              <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="editGastosHistorial">
              <label class="navbar-left" id="mensajeErrorGastos" style="color: red;"></label>
            </div>

            <div class="form-group" id="claseEditFechaCorteHistorial" style="padding-bottom: 14px;">
              <label class="control-label navbar-left"><strong>FechaCorte</strong></label>
              <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="editFechaCorteHistorial">
              <label class="navbar-left" id="mensajeErrorFechaCorte" style="color: red;"></label>
            </div>

            <div class="form-group">
              <label class="control-label navbar-left"><strong>Selecciona el Estatus</strong></label>
            </div>

            <select class="form-control" name="statusCrearConfig[]" id="editStatusHistorial">
              <option name="status">PENDIENTE</option>
              <option name="status">PAGADO</option>
            </select>

            <br>
          </fieldset>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="btnEditarHistorial">Editar</button>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="modalEliminarHistorial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Eliminar Fila</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form id="eliminarFormularioHistorial" class="form-floating ng-pristine ng-invalid ng-invalid-required ng-valid-email ng-valid-url ng-valid-pattern" novalidate="novalidate">

          <fieldset>

            <div id="eliminarHistorialPeticionAjax" style="display:none"></div>

            <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="eliminarIdHistorial" style="display:none">

            <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="eliminarPaginaActualHistorial" style="display:none">

            <div class="form-group" style="padding-bottom: 14px;">
              <label class="control-label navbar-left"><strong>Nombre</strong></label>
              <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="eliminarNombreHistorial" disabled>
              <label class="navbar-left" id="mensajeErrorNombre" style="color: red;"></label>
            </div>

            <div class="form-group" style="padding-bottom: 14px;">
              <label class="control-label navbar-left"><strong>Descripción</strong></label>
              <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="eliminarDescripcionHistorial" disabled>
              <label class="navbar-left" id="mensajeErrorDescripcion" style="color: red;"></label>
            </div>

            <div class="form-group" style="padding-bottom: 14px;">
              <label class="control-label navbar-left"><strong>Gastos</strong></label>
              <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="eliminarGastosHistorial" disabled>
              <label class="navbar-left" id="mensajeErrorGastos" style="color: red;"></label>
            </div>

            <div class="form-group" style="padding-bottom: 14px;">
              <label class="control-label navbar-left"><strong>FechaCorte</strong></label>
              <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="eliminarFechaCorteHistorial" disabled>
              <label class="navbar-left" id="mensajeErrorFechaCorte" style="color: red;"></label>
            </div>

            <div class="form-group">
              <label class="control-label navbar-left"><strong>Selecciona el Estatus</strong></label>
            </div>
            <select class="form-control" name="statusCrearConfig[]" id="eliminarStatusHistorial" disabled>
              <option name="status">PENDIENTE</option>
              <option name="status">PAGADO</option>
            </select>
            <br>
          </fieldset>

          <div class="modal-footer">
            <!-- data-dismiss="modal" -->
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-danger" id="btnEliminarHistorial">Eliminar</button>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>

<!-- Modal Editar Config Registro -->
<div class="btn-group">
  <div class="modal fade" id="modalEditarRegistroC" tabindex="-1" role="dialog" aria-labelledby="btneditarTitle" aria-hidden="true">
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
          <form id="editarFormularioRegistro" class="form-floating ng-pristine ng-invalid ng-invalid-required ng-valid-email ng-valid-url ng-valid-pattern" novalidate="novalidate">
            <fieldset>

              <div id="editarRegistroCPeticionAjax" style="display: none;"></div>

              <input type="hidden" class="form-control1 ng-invalid ng-invalid-required" id="idEditC">
              <input type="hidden" class="form-control1 ng-invalid ng-invalid-required" id="paginaActualEditC">

              <div class="form-group" id="claseEditCIngresoVeronicaR" style="padding-bottom: 14px;">
                <label class="control-label navbar-left"><strong>Ingresos Veronica</strong></label>
                <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="ingresoVeronicaEditC">
                <label class="navbar-left" id="idMensajeErrorIngresosVeronicaEditarC" style="color: red;"></label>
              </div>

              <div class="form-group" id="claseEditCIngresoPabloR" style="padding-bottom: 14px;">
                <label class=" control-label navbar-left"><strong>Ingresos Pablo</strong></label>
                <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="ingresoPabloEditC">
                <label class="navbar-left" id="idMensajeErrorIngresoPabloEditarC" style="color: red;"></label>
              </div>

              <div class="form-group" id="claseEditCIngresoExtraR" style="padding-bottom: 14px;">
                <label class="control-label navbar-left"><strong>Ingresos Extra</strong></label>
                <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="ingresoExtraEditC">
                <label class="navbar-left" id="idMensajeErrorIngresoExtraEditarC" style="color: red;"></label>
              </div>

              <div class="form-group" id="claseEditCAhorrosR" style="padding-bottom: 14px;">
                <label class="control-label navbar-left"><strong>Ahorros</strong></label>
                <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="ahorrosEditC">
                <label class="navbar-left" id="idMensajeErrorAhorrosEditarC" style="color: red;"></label>
              </div>

              <div class="form-group" id="claseEditCMesR" style="padding-bottom: 14px;">
                <label class="control-label navbar-left"><strong>Mes</strong></label>
                <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="mesEditC">
                <label class="navbar-left" id="idMensajeErrorMesEditarC" style="color: red;"></label>
              </div>

              <div class="form-group" id="claseEditCYearR">
                <label class="control-label navbar-left"><strong>Año</strong></label>
                <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="yearEditC">
                <label class="navbar-left" id="idMensajeErrorYearEditarC" style="color: red;"></label>
              </div>
              <br>
            </fieldset>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="btnEditarCRegistro">Aceptar</button>
            </div>
          </form>
        </div>
        <!-- //Formulario Final -->
      </div>
    </div>
  </div>
</div>

<!-- Modal Repoblar -->
<div class="modal fade bd-example-modal-lg" id="modalRepoblar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Repoblar</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form id="repoblar" class="form-floating ng-pristine ng-invalid ng-invalid-required ng-valid-email ng-valid-url ng-valid-pattern" novalidate="novalidate">

          <div id="respuestaPeticionRepoblar" style="display: none;"></div>

          <input type="text" class="form-control1 ng-invalid ng-invalid-required" id="repoblarId" style="display: none;">
          <table class="table">
            <thead>

              <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Gastos</th>
                <th scope="col">Fecha Corte</th>
              </tr>

            </thead>
            <tbody>

              <?php while ($mostrarLista = $mostarConfig->fetch_object()) : ?>

                <tr>
                  <th scope="row"><?= $mostrarLista->nombre ?></th>
                  <td><?= $mostrarLista->descripcion ?></td>
                  <td><?= $mostrarLista->gastos ?></td>
                  <td><?= $mostrarLista->fechaCorte ?></td>
                </tr>

              <?php endwhile ?>

            </tbody>
          </table>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" id="btnRepoblar" class="btn btn-primary" id="">Repoblar</button>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>