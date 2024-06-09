<?php

class htmlConfiguracion
{

    public static function obtenerTodos($imputBuscador, $paginaActual)
    {
        $configuracion = new Configuracion();
        $configuracion->setBuscador($imputBuscador);
        
        // Estadisticas Banner
        estadisticasConfig::bannerConfig();

        // Paginador 1: Extraer el Conteo de Registros de la Base de Datos
        $conteoRegistros = $configuracion->conteoRegistros();

        // Paginador 2: Muestro el total de Registros que se van a Mostrar
        $mostrarRegistros = 20;

        // Paginador 3: Capturo la Pagina Actual => Para Limitar Los Registros, Primer Parametro
        $ultimoRegistro = ($paginaActual - 1) * $mostrarRegistros;

        // Paginador 4: Total de Registros que voy a Mostrar
        $obtenerPaginas = ceil($conteoRegistros / $mostrarRegistros);

        // Pagina Anterior
        $paginaAnterior = $paginaActual - 1;

        // Pagina Siguiente
        $paginaSiguiente = $paginaActual + 1;

        // Obtener Lista
        $obtenerLista = $configuracion->listar($ultimoRegistro, $mostrarRegistros);

        // echo '<div class="graphs">';
        // echo '<div class="col_3">';
        // echo '<div class="col-md-3 widget widget1">';
        // echo '<div class="r3_counter_box">';
        // echo '<div class="text-center" style="margin-top: 9px;">';

        // echo '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modalCrearConfiguracion">&#128421 Crear Filas</button>';
        // echo '</div>';
        // echo '</div>';
        // echo '</div>';

        // if ($obtenerLista->num_rows > 0) {
        //     echo '<div class="col-md-3 widget widget1">';
        //     echo '<div class="r3_counter_box">';
        //     echo '<div class="text-center" style="margin-top: 9px;">';
        //     echo '<a href="" id="" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalEditarRegistroC"
        // onclick="editarRegistroConfig(' . $obtenerIdRegistro . ', ' . $obtenerRegistro->income_veronica . ', ' . $obtenerRegistro->income_pablo . ', ' . $obtenerRegistro->income_extra . ', ' . $obtenerRegistro->saving_verpa . ', \'' . $obtenerRegistro->month . '\', ' . $obtenerRegistro->year . ', ' . $paginaActual . ')">&#128240;  Editar Ingresos</a>';
        //     echo '</div>';
        //     echo '</div>';
        //     echo '</div>';
        // }

        // echo '<div class="col-md-3 widget widget1">';
        // echo '<div class="r3_counter_box">';
        // echo '<div class="text-center" style="margin-top: 9px;">';

        // echo '<a href="" id="" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#modalRepoblar" onclick="repoblar(' . $obtenerIdRegistro . ')">&#128452; Repoblar Tabla</a>';
        // echo '</div>';
        // echo '</div>';
        // echo '</div>';

        // echo '<div class="col-md-3 widget widget1">';
        // echo '<div class="r3_counter_box">';
        // echo '<div class="text-center" style="margin-top: 9px;">';
        // echo '<a href="' . base_url . '" class="btn btn-info btn-lg">&#11013 Volver</a>';
        // echo '</div>';
        // echo '</div>';
        // echo '</div>';

        // echo '<div class="clearfix"> </div>';
        // echo '</div>';
        // echo '</div>';
       
        echo '<table class="table table-bordered">';
        echo '<thead>';
        echo '<tr>';
        // echo '<th style=" text-align: center;">Id</th>';
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
                echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEditarConfig" onclick="editarConfig(' . $listarRegistros->id . ',\'' . $listarRegistros->nombre . '\',\'' . $listarRegistros->descripcion . '\',' . $listarRegistros->gastos . ',\'' . $listarRegistros->fechaCorte . '\',\'' . $listarRegistros->status . '\', ' . $paginaActual . ' )">&#128240; Editar</button>';
                echo '</td>';

                echo '<td>';
                echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalEliminarrConfig" onclick="eliminarConfig(' . $listarRegistros->id . ',\'' . $listarRegistros->nombre . '\',\'' . $listarRegistros->descripcion . '\',' . $listarRegistros->gastos . ',\'' . $listarRegistros->fechaCorte . '\',\'' . $listarRegistros->status . '\', ' . $paginaActual . ' )">&#128465 Eliminar</button>';
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
        if ($paginaActual != 1) {
            echo '<li class="page-item">';
            echo '<a class="page-link" onclick = "obtenerConfigTabla(\'' . $imputBuscador . '\', ' . $paginaAnterior . ')"> Anterior </a>';
            echo '</li>';
        } else {
            echo '<li class="page-item disabled">';
            echo '<a class="page-link" >Anterior</a>';
            echo '</li>';
        }

        // Cuerpo
        for ($i = 1; $i <= $obtenerPaginas; $i++) {
            if ($i == $paginaActual) {
                echo '<li class="page-item active"><a class="page-link" >' . $i . '</a></li>';
            } else {
                echo '<li class="page-item"><a class="page-link"  onclick = "obtenerConfigTabla(\'' . $imputBuscador . '\', ' . $i . ')">' . $i . '</a></li>';
            }
        }

        // Siguiente
        if ($paginaActual != $obtenerPaginas) {
            echo '<li class="page-item">';
            echo '<a class="page-link"  onclick = "obtenerConfigTabla(\'' . $imputBuscador . '\', ' . $paginaSiguiente . ')" >Siguente</a>';
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
