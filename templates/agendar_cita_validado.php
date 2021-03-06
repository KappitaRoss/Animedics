<form action="<?php echo RUTA_AGENDAR_CITA?>" method="post">
    <table class="table table-hover table-striped fuente-R icono-15">
        <thead class="fuente-WM verde">
            <tr>
                <th colspan="2">Introduzca los datos solicitados</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th><label for="petname">Nombre de la mascota:</label></th>
                <td>
                    <input class="txb" type="text" name="nombre" id="petname" <?php $validador -> mostrar_nombre();?>>
                </td>
            </tr>
            <?php echo $validador -> mostrar_error_nombre();?>
            <tr>
                <th><label for="petspecie">Especie:</label></th>
                <td>
                    <select name="especie" id="petspecie">
                        <option value="1">Perro</option>
                        <option value="2">Gato</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="petage">Edad de su mascota (Años):</label></th>
                <td>
                    <input class="txb" type="number" name="edad" id="petage" <?php $validador -> mostrar_edad();?>>
                </td>
            </tr>
            <?php echo $validador -> mostrar_error_edad();?>
            <tr>
                <th>Sexo de su mascota:</th>
                <td>
                    <select name="sexo" id="sex">
                        <option value='MACHO'>Macho</option>
                        <option value='HEMBRA'>Hembra</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Día</td>
                <td>
                    <input type="text" id="datepicker" name="fecha" value="<?php echo date("d/m/Y")?>" readonly
                        placeholder="Selecciona un día" required>
                </td>
            </tr>
            <tr>
                <td>Hora</td>
                <td>
                    <select name="hora" id="id_pet">
                        <option value="09:00:00">9:00 a.m.</option>
                        <option value="10:00:00">10:00 a.m.</option>
                        <option value="11:00:00">11:00 a.m.</option>
                        <option value="12:00:00">12:00 p.m.</option>
                        <option value="13:00:00">1:00 p.m.</option>
                        <option value="14:00:00">2:00 p.m.</option>
                        <option value="15:00:00">3:00 p.m.</option>
                        <option value="16:00:00">4:00 p.m.</option>
                        <option value="17:00:00">5:00 p.m.</option>
                        <option value="18:00:00">6:00 p.m.</option>
                        <option value="19:00:00">7:00 p.m.</option>
                        <option value="20:00:00">8:00 p.m.</option>

                    </select>
                </td>
            </tr>
            <tr>
                <td>Servicio(s)</td>
                <td>
                    <select name="servicios[]" id="service" multiple="multiple" required>
                        <?php 
                                    Conexion::abrir_conexion();
                                    Escritor::escribir_servicios(Conexion::obtener_conexion());
                                    Conexion::cerrar_conexion();?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Nombre(s)</td>
                <td>
                    <input class="txb" type="text" name="nombres" id="names" size="30"
                        <?php $validador -> mostrar_nombres();?>>
                </td>
            </tr>
            <?php echo $validador -> mostrar_error_nombres();?>
            <tr>
                <td>Apellido Paterno</td>
                <td>
                    <input class="txb" type="text" name="ap_paterno" id="lastname" size="30"
                        <?php $validador -> mostrar_ap_paterno();?>>
                </td>
            </tr>
            <?php echo $validador -> mostrar_error_ap_paterno();?>
            <tr>
                <td>Apellido Materno</td>
                <td>
                    <input class="txb" type="text" name="ap_materno" id="lastname" size="30"
                        <?php $validador -> mostrar_ap_materno();?>>
                </td>
            </tr>
            <?php echo $validador -> mostrar_error_ap_materno();?>
            <tr>
                <td>Correo de contacto</td>
                <td>
                    <input class="txb" type="text" name="correo" id="email" size="30"
                        <?php $validador -> mostrar_correo();?>>
                </td>
            </tr>
            <?php echo $validador -> mostrar_error_correo();?>
            <tr>
                <td>Teléfono de contacto</td>
                <td>
                    <input class="txb" type="number" name="telefono" id="phone" size="30"
                        <?php $validador -> mostrar_telefono();?>>
                </td>
            </tr>
            <?php echo $validador -> mostrar_error_telefono();?>
        </tbody>
        <tfoot>
            <tr class="text-center">
                <td colspan="2"><button type="submit" class="btn boton fuente-WM" name="agendar">Agendar Cita</button></td>
            </tr>
        </tfoot>
    </table>
</form>