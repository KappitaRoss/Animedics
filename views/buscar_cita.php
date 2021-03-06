<?php
$titulo = "Datos de la cita";
include_once "app/config.inc.php";
include_once "app/Conexion.inc.php";
include_once "app/Escritor.inc.php";
include_once "app/Mascota.inc.php";
include_once "app/Cita.inc.php";
include_once "app/RepositorioMascota.inc.php";

if(isset($_POST['buscar'])){
    Conexion::abrir_conexion();
    $cita = RepositorioCita::obtener_cita_por_folio(Conexion::obtener_conexion(), $_POST['folio']);
    if(isset($cita) && $cita!= null){
        $veterinario = RepositorioCita::obtener_nombre_veterinario(Conexion::obtener_conexion(), $cita -> obtener_id_cita());
        $mascota = RepositorioMascota::obtener_mascota_por_cita(Conexion::obtener_conexion(), $cita -> obtener_id_cita());
        $persona = RepositorioCita::obtener_persona(Conexion::obtener_conexion(), $cita -> obtener_id_cita());
    }
    Conexion::cerrar_conexion();
}

include_once "templates/declaracion.php";
include_once "templates/navbar.php";
?>
 
<div class="container fila borde-redondo borde-verde">
    <div class="row">
        <div class="col-md-12">
                <h1 class="fuente-WM verde separadito text-center">DATOS DE LA CITA</h1>
                <div class="borde-sup"></div><br>
                <div class="d-flex justify-content-center centrado-vertical fila">
                        <table class="table-sm table-striped table-hover">
                            <tbody>
                                    <?php 
                                    Conexion::abrir_conexion(); 
                                    if(isset($cita) && $cita != null){?>
                                    <tr><th colspan="4" class="text-center">DATOS DE LA CITA</th></tr>
                                    <tr>
                                        <th>Nombre del solicitante:</th>
                                        <td colspan="3"><?php echo $persona;?></td>
                                    </tr>
                                    <tr>
                                        <th>Folio:</th>
                                        <td colspan="3"><?php echo $cita -> obtener_folio();?></td>
                                    </tr>
                                    <tr>
                                        <th>Fecha:</th>
                                        <td colspan="3"><?php echo $cita -> obtener_fecha();?></td>
                                    </tr>
                                    <tr>
                                        <th>Hora:</th>
                                        <td colspan="3"><?php echo $cita -> obtener_hora();?></td>
                                    </tr>
                                    <tr>
                                        <th>Servicio(s):</th>
                                        <td colspan="3"><?php
                                        $cadena = Escritor::escribir_servicios_cita(Conexion::obtener_conexion(), $cita -> obtener_folio());
                                        echo $cadena;
                                        ?></td>
                                    </tr>
                                    <tr><th colspan="4" class="text-center">DATOS DE LA MASCOTA</th></tr>
                                    <tr>
                                        <th>Nombre:</th>
                                        <td colspan="3"><?php echo $mascota -> obtener_nombre();?></td>
                                    </tr>
                                    
                                    <tr>
                                        <th>Sexo:</th>
                                        <td colspan="3"><?php echo $mascota -> obtener_sexo();?></td>
                                    </tr>
                                    <tr>
                                        <th>Edad:</th>
                                        <td><?php echo $mascota -> obtener_edad();?> años</td>
                                    </tr>
                                    <tr><th colspan="4" class="text-center">DATOS DEL VETERINARIO</th></tr>
                                    <tr>
                                        <th>Nombre:</th>
                                        <td colspan="3"><?php echo $veterinario['nombre'];?></td>
                                    </tr>
                                    <tr>
                                        <th>Cédula:</th>
                                        <td colspan="3"><?php echo $veterinario['cedula'];?></td>
                                    </tr>
                                    <?php if($cita -> obtener_completada() == 'SI'){
                                include_once 'app/Datos.inc.php';
                                $datos = RepositorioCita::obtener_datos_medicos(Conexion::obtener_conexion(),$cita -> obtener_id_cita());
                                if(isset($datos) && $datos != null){
                                $receta = RepositorioCita::obtener_receta(Conexion::obtener_conexion(), $datos -> obtener_id_datos());
                            ?>
                                    <tr><th colspan="4" class="text-center">DATOS DE LA CONSULTA MÉDICA</th></tr>
                                    <tr>
                                        <th>Síntomas:</th>
                                        <td colspan="3"><?php echo $datos -> obtener_sintomas();?></td>
                                    </tr>
                                    <tr>
                                        <th>Temperatura:</th>
                                        <td colspan="3"><?php echo $datos -> obtener_temperatura();?> °C</td>
                                    </tr>
                                    <tr>
                                        <th>Peso:</th>
                                        <td colspan="3"><?php echo $datos -> obtener_peso();?> Kg</td>
                                    </tr>
                                    <tr>
                                        <th>Diagnóstico:</th>
                                        <td colspan="3"><?php echo $datos -> obtener_diagnostico();?></td>
                                    </tr>
                                    <tr>
                                        <th>Examen del abdomen:</th>
                                        <td colspan="3"><?php echo $datos -> obtener_abdomen();?></td>
                                    </tr>
                                    <tr>
                                        <th>Estado de los órganos internos:</th>
                                        <td colspan="3"><?php echo $datos -> obtener_org_int();?></td>
                                    </tr>
                                    <tr>
                                        <th>Estado de los órganos externos:</th>
                                        <td colspan="3"><?php echo $datos -> obtener_org_ext();?></td>
                                    </tr>
                                    <tr>
                                        <th>¿Había sido operado previamente?</th>
                                        <td colspan="3"><?php echo $datos -> obtener_operado();?></td>
                                    </tr>
                                    <tr>
                                        <th>Grado de deshidratación:</th>
                                        <td colspan="3"><?php echo $datos -> obtener_deshidratacion();?></td>
                                    </tr>
                                    <?php }if(isset($receta) && $receta != null){?>
                                    <tr><th colspan="4" class="text-center">RECETA MÉDICA</th></tr>
                                    <tr>
                                        <th>Medicamento</th>
                                        <th>Dosis</th>
                                        <th>Durante</th>
                                        <th>Cada</th>
                                    </tr>
                                    <?php foreach ($receta as $medicamento) {?>
                                            <tr>
                                            <td><?php echo $medicamento -> obtener_nombre();?></td>
                                            <td><?php echo $medicamento -> obtener_dosis();?></td>
                                            <td><?php echo $medicamento -> obtener_dias();?> días</td>
                                            <td><?php echo $medicamento -> obtener_horas();?> horas</td>
                                            </tr>
                            <?php }}}
                            Conexion::cerrar_conexion();
                            } 
                            else{ ?>
                                    <tr><div class='alert alert-danger' role='alert'>No existe ninguna cita con ese folio, ingresa un folio valido</div></tr>
                            <?php } ?>
                            </tbody>
                            <tfoot>
                            <tr class="text-center">
                            <td colspan="2"><a role="button" href="<?php echo SERVER?>" class="btn boton fuente-WM">Aceptar</a></td>
                            </tr>
                            </tfoot>
                        </table>    
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    </div>  
<div class="esconde-logo"></div>
<?php include_once "templates/cierre.php";