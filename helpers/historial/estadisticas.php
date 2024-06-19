<?php
require_once 'model/Historial.php';

class estadisticas
{

  public static function banner($idRegistro)
  {
    $historial = new historial;
    $historial->setIdRegistro($idRegistro);
    
    $sumaIngresos = $historial->sumaIngresos();

    $deudasGlobales = ($historial->deudasGlobales()) == 0 ? 0 : $historial->deudasGlobales(); 
    
    $dineroRestante = $sumaIngresos->ingresosTotales - $deudasGlobales;  

    $gastosCarrefour = ($historial->gastosCarrefour()) == 0 ? 0 : $historial->gastosCarrefour();

    $gastosServicios = ($historial->gastosServicios()) == 0 ? 0 : $historial->gastosServicios();

    $gastosDeudas = ($historial->gastosDeudas()) == 0 ? 0 : $historial->gastosDeudas();

    $gastosPendiente = ($historial->gastosPendiente()) == 0 ? 0 : $historial->gastosPendiente();

    echo  "<script>document.getElementById('ingresosTotales').innerHTML=  $sumaIngresos->ingresosTotales + ' €'</script>";
    echo  "<script>document.getElementById('ahorros').innerHTML= $sumaIngresos->ahorros + ' €'</script>";
    echo  "<script>document.getElementById('deudasGlobales').innerHTML= $deudasGlobales + ' €'</script>";
    echo  "<script>document.getElementById('dineroRestante').innerHTML= $dineroRestante + ' €'</script>";
    echo  "<script>document.getElementById('gastosCarrefour').innerHTML= $gastosCarrefour + ' €'</script>";
    echo  "<script>document.getElementById('gastosServicios').innerHTML= $gastosServicios + ' €'</script>";
    echo  "<script>document.getElementById('gastosDeudas').innerHTML= $gastosDeudas + ' €'</script>";
    echo  "<script>document.getElementById('deudasPorPagar').innerHTML= $gastosPendiente + ' €'</script>";
    
  }

}
