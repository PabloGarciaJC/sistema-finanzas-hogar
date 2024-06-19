<?php

require_once 'model/Historial.php';

class htmlHistorial
{

    public static function obtenerTodos($imputBuscador, $paginaActualHistorial, $idRegistro)
    {
        $historial = new Historial();
        $historial->setBuscador($imputBuscador);
        $historial->setIdRegistro($idRegistro);
      
        // Estadisticas Banner
        estadisticas::banner($idRegistro);

        // Paginador 1: Extraer el Conteo de Registros de la Base de Datos
        $conteoHistorial = $historial->conteoRegistros();

        // Paginador 2: Muestro el total de Registros que se van a Mostrar
        $mostrarRegistros = 20;

        // Paginador 3: Capturo la Pagina Actual => Para Limitar Los Registros, Primer Parametro
        $ultimoRegistro = ($paginaActualHistorial - 1) * $mostrarRegistros;

        // Paginador 4: Total de Registros que voy a Mostrar
        $obtenerPaginas = ceil($conteoHistorial / $mostrarRegistros);

        // Pagina Anterior
        $paginaAnterior = $paginaActualHistorial - 1;

        // Pagina Siguiente
        $paginaSiguiente = $paginaActualHistorial + 1;

        // Obtener Lista
        $obtenerLista = $historial->listar($ultimoRegistro, $mostrarRegistros);

        echo '<div class="graphs">';
        echo '<div class="col_3">';
        echo '<div class="col-md-3 widget widget1">';
        echo '<div class="r3_counter_box">';
        echo '<div class="text-center" style="margin-top: 9px;">';

        echo '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modalHistorial">&#128421 Crear Historial</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        echo '<div class="col-md-3 widget widget1">';
        echo '<div class="r3_counter_box">';
        echo '<div class="text-center" style="margin-top: 9px;">';

        echo '<a href="" id="" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#modalRepoblar" onclick="repoblar(' . $idRegistro . ')">&#128421; Repoblar Tabla</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        echo '<div class="col-md-3 widget widget1">';
        echo '<div class="r3_counter_box">';
        echo '<div class="text-center" style="margin-top: 9px;">';
        echo '<a href="' . BASE_URL . '" class="btn btn-info btn-lg">&#11013 Volver</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        echo '<div class="clearfix"> </div>';
        echo '</div>';
        echo '</div>';

        echo '<table class="table table-bordered">';
        echo '<thead>';
        echo '<tr>';

        echo '<th style=" text-align: center;">Nombre</th>';
        echo '<th style="text-align: center;">Descripcion</th>';
        echo '<th style="text-align: center;">Gastos</th>';
        echo '<th style="text-align: center;">Fecha Corte</th>';
        echo '<th style="text-align: center;">Status</th>';
        echo '<th style="text-align: center;">Editar</th>';
        echo '<th style="text-align: center;">Eliminar</th>';

        echo '</tr>';
        echo '</thead>';

        echo '<tbody>';

        if ($obtenerLista->num_rows > 0) {

            while ($listarRegistros = $obtenerLista->fetch_object()) {

                echo '<tr>';

                echo '<td><strong>' . $listarRegistros->nombre . '</strong></td>';
                echo '<td>' . $listarRegistros->descripcion . '</td>';
                echo '<td><strong>' . $listarRegistros->gastos . '  &#8364;</strong></td>';
                echo '<td>' . $listarRegistros->fechaCorte . '</td>';

                if ($listarRegistros->status == 'PENDIENTE') {
                    echo '<td style="  color: red;"><strong>' . $listarRegistros->status . '</strong></td>';
                } else {
                    echo '<td style="  color: #00c887;"> <strong>' . $listarRegistros->status . '</strong></td>';
                }

                echo '<td>';
                echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEditarHistorial" onclick="editarHistorial(' . $listarRegistros->id . ',\'' . $listarRegistros->nombre . '\',\'' . $listarRegistros->descripcion . '\',' . $listarRegistros->gastos . ',\'' . $listarRegistros->fechaCorte . '\',\'' . $listarRegistros->status . '\', ' . $paginaActualHistorial . ' )">&#128240; Editar</button>';
                echo '</td>';

                echo '<td>';
                echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalEliminarHistorial" onclick="eliminarHistorial(' . $listarRegistros->id . ',\'' . $listarRegistros->nombre . '\',\'' . $listarRegistros->descripcion . '\',' . $listarRegistros->gastos . ',\'' . $listarRegistros->fechaCorte . '\',\'' . $listarRegistros->status . '\', ' . $paginaActualHistorial . ' )">&#128465 Eliminar</button>';
                echo '</td>';

                echo '</tr>';
            };
        } else {
            echo '<td colspan="10" class="alert alert-success" role="alert">No hay ningun registro</td>';
        }

        echo '</tbody>';

        echo '</table>';

        // Paginador => Inicio
        echo '<nav aria-label="Page navigation example" style="text-align: center;">';
        echo '<ul class="pagination justify-content-end">';

        // Anterior
        if ($paginaActualHistorial != 1) {
            echo '<li class="page-item">';
            echo '<a class="page-link" onclick = "obtenerHistorialTabla(\'' . $imputBuscador . '\', ' . $paginaAnterior . ')"> Anterior </a>';
            echo '</li>';
        } else {
            echo '<li class="page-item disabled">';
            echo '<a class="page-link" >Anterior</a>';
            echo '</li>';
        }

        // Cuerpo
        for ($i = 1; $i <= $obtenerPaginas; $i++) {
            if ($i == $paginaActualHistorial) {
                echo '<li class="page-item active"><a class="page-link" >' . $i . '</a></li>';
            } else {
                echo '<li class="page-item"><a class="page-link"  onclick = "obtenerHistorialTabla(\'' . $imputBuscador . '\', ' . $i . ')">' . $i . '</a></li>';
            }
        }

        // Siguiente
        if ($paginaActualHistorial != $obtenerPaginas) {
            echo '<li class="page-item">';
            echo '<a class="page-link"  onclick = "obtenerHistorialTabla(\'' . $imputBuscador . '\', ' . $paginaSiguiente . ')" >Siguente</a>';
            echo '</li>';
        } else {
            echo '<li class="page-item disabled">';
            echo '<a class="page-link" >Siguente</a>';
            echo '</li>';
        }
        echo '</ul>';
        echo '</nav>';
    }
}
