<thead class="<?php if ($clase == 'admin') {echo 'gris';}elseif ($clase == 'vet') {echo 'naranja';} else{echo 'verde';}?> separadito">
    <tr>
        <th colspan="2">MODIFICA LOS DATOS DE TU PERFIL</th>
    </tr>
</thead>
<tbody>
    <tr>
        <th>Nombre(s)</th>
        <td><input class="txb<?php if ($clase == 'admin') {echo '-gris';}elseif ($clase == 'vet') {echo '-naranja';}?>" type="text" name="nombres" id="names" size="30" <?php $validador -> mostrar_nombres();?>>
        </td>
    </tr>
    <?php $validador -> mostrar_error_nombres();?>
    <tr>
        <th>Apellido Paterno</th>
        <td><input class="txb<?php if ($clase == 'admin') {echo '-gris';}elseif ($clase == 'vet') {echo '-naranja';}?>" type="text" name="ap_paterno" id="lastname" size="30"
                <?php $validador -> mostrar_ap_paterno();?>></td>
    </tr>
    <?php $validador -> mostrar_error_ap_paterno();?>
    <tr>
        <th>Apellido Materno</th>
        <td><input class="txb<?php if ($clase == 'admin') {echo '-gris';}elseif ($clase == 'vet') {echo '-naranja';}?>" type="text" name="ap_materno" id="lastname" size="30"
                <?php $validador -> mostrar_ap_materno();?>></td>
    </tr>
    <?php $validador -> mostrar_error_ap_materno();?>
    <tr>
        <th>Nombre de usuario</th>
        <td><input class="txb<?php if ($clase == 'admin') {echo '-gris';}elseif ($clase == 'vet') {echo '-naranja';}?>" type="text" name="nombre_usuario" id="nick" size="30"
                <?php $validador -> mostrar_nom_usuario();?>></td>
    </tr>
    <?php $validador -> mostrar_error_nom_usuario();?>
    <tr>
        <th>Correo electronico</th>
        <td><input class="txb<?php if ($clase == 'admin') {echo '-gris';}elseif ($clase == 'vet') {echo '-naranja';}?>" type="text" name="correo" id="email" size="30" <?php $validador -> mostrar_correo();?>>
        </td>
    </tr>
    <?php $validador -> mostrar_error_correo();?>
    <tr>
        <th>Telefono</th>
        <td><input class="txb<?php if ($clase == 'admin') {echo '-gris';}elseif ($clase == 'vet') {echo '-naranja';}?>" type="text" name="telefono" id="phone" size="30"
                <?php $validador -> mostrar_telefono();?>></td>
    </tr>
    <?php $validador -> mostrar_error_telefono();?>
    <tr>
        <td><button class="btn boton-naranja" name="cancelar"><span class="material-icons">backspace</span> Cancelar</button></td>
        <td><button class="btn boton" name="guardar"><span class="material-icons">edit</span> Guardar cambios</button>
        </td>
    </tr>
</tbody>
