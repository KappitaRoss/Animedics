<thead class="<?php if ($clase == 'admin') {echo 'gris';}elseif ($clase == 'vet') {echo 'naranja';} else{echo 'verde';}?> separadito">
    <tr>
        <th colspan="2">MODIFICA TU CONTRASEÑA</th>
    </tr>
</thead>
<tbody>
    <tr>
        <th>Contraseña anterior</th>
        <td><input class="txb<?php if ($clase == 'admin') {echo '-gris';}elseif ($clase == 'vet') {echo '-naranja';}?>" type="password" name="clave_ing" id="password" size="30"></td>
    </tr>
    <tr>
        <th>Nueva contraseña</th>
        <td><input class="txb<?php if ($clase == 'admin') {echo '-gris';}elseif ($clase == 'vet') {echo '-naranja';}?>" type="password" name="clave_1" id="password" size="30"></td>
    </tr>
    <tr>
        <th>Confirmar contraseña</th>
        <td><input class="txb<?php if ($clase == 'admin') {echo '-gris';}elseif ($clase == 'vet') {echo '-naranja';}?>" type="password" name="clave_2" id="password" size="30"></td>
    </tr>
    <tr>
        <td><button class="btn boton-naranja" name="cancelar"><span class="material-icons">backspace</span> Cancelar</button></td>
        <td><button class="btn boton" name="guardar_clave"><span class="material-icons">edit</span> Guardar cambios</button></td>
    </tr>
</tbody>
