<?php

class htmlRegistro
{
    public static function obtenerTodos($imputBuscador, $paginaActual)
    {
        $registro = new Registro();

        $registro->setBuscador($imputBuscador);

        // Paginador 1: Extraer el Conteo de Registros de la Base de Datos
        $conteoRegistros = $registro->conteoRegistros();

        // Paginador 2: Muestro el total de Registros que se van a Mostrar
        $mostrarRegistros = 25;

        // Paginador 3: Capturo la Pagina Actual => Para Limitar Los Registros, Primer Parametro
        $ultimoRegistro = ($paginaActual - 1) * $mostrarRegistros;

        // Paginador 4: Total de Registros que voy a Mostrar
        $obtenerPaginas = ceil($conteoRegistros / $mostrarRegistros);

        // Pagina Anterior
        $paginaAnterior = $paginaActual - 1;

        // Pagina Siguiente
        $paginaSiguiente = $paginaActual + 1;

        // Obtener Lista
        $obtenerLista = $registro->listar($ultimoRegistro, $mostrarRegistros);

        echo '<div class="agileits-logo navbar-left">';
        echo '<div class="btn-group">';
        echo '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modalCrearRegistro">&#128421 Crear Registro</button>';
        echo '</div>';
        echo '</div>';
        echo '</br></br><br>';

        echo '<table class="table table-bordered">';
        echo '<thead>';
        echo '<tr>';
        echo '<th style=" text-align: center;">Id</th>';
        echo '<th style=" text-align: center;">Ingresos Veronica</th>';
        echo '<th style="text-align: center;">Ingresos Pablo</th>';
        echo '<th style="text-align: center;">Ingresos Extras</th>';
        echo '<th style="text-align: center;">Ahorros</th>';
        echo '<th style="text-align: center;">Mes</th>';
        echo '<th style="text-align: center;">Año</th>';
        echo '<th style="text-align: center;">Historial</th>';
        echo '<th style="text-align: center;">Editar</th>';
        echo '<th style="text-align: center;">Eliminar</th>';
        echo '</tr>';
        echo '</thead>';

        echo '<tbody>';

        if ($obtenerLista->num_rows > 0) {

            while ($listarRegistros = $obtenerLista->fetch_object()) {

                echo '<tr>';

                echo '<td>' . $listarRegistros->id . '</td>';
                echo '<td>' . $listarRegistros->income_veronica . ' &#8364;</td>';
                echo '<td>' . $listarRegistros->income_pablo . ' &#8364;</td>';
                echo '<td>' . $listarRegistros->income_extra . ' &#8364;</td>';
                echo '<td>' . $listarRegistros->saving_verpa . ' &#8364;</td>';
                echo '<td>' . $listarRegistros->month . '</td>';
                echo '<td>' . $listarRegistros->year . '</td>';
                echo '<td><a href="' . base_url . 'historial/index&id=' . $listarRegistros->id . '"><strong> Ver</strong></a></td>';

                echo '<td>';
                echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEditarRegistro" onclick="editar(' . $listarRegistros->id . ', ' . $listarRegistros->income_veronica . ', ' . $listarRegistros->income_pablo . ', ' . $listarRegistros->income_extra . ', ' . $listarRegistros->saving_verpa . ', \'' . $listarRegistros->month . '\', ' . $listarRegistros->year . ', ' . $paginaActual . ')">&#128240; Editar</button>';
                echo '</td>';

                echo '<td>';
                echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalEliminarRegistro" onclick="eliminar(' . $listarRegistros->id . ',\'' . $listarRegistros->month . '\', ' . $listarRegistros->year . ', ' . $paginaActual . ')">&#128465; Eliminar</button>';
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
            echo '<a class="page-link" onclick = "obtenerRegistrosTabla(\'' . $imputBuscador . '\', ' . $paginaAnterior . ')"> Anterior </a>';
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
                echo '<li class="page-item"><a class="page-link"  onclick = "obtenerRegistrosTabla(\'' . $imputBuscador . '\', ' . $i . ')">' . $i . '</a></li>';
            }
        }

        // Siguiente
        if ($paginaActual != $obtenerPaginas) {
            echo '<li class="page-item">';
            echo '<a class="page-link"  onclick = "obtenerRegistrosTabla(\'' . $imputBuscador . '\', ' . $paginaSiguiente . ')" >Siguente</a>';
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
