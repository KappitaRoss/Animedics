<?php include_once 'declaracion.php';
if(isset($_POST['xd'])){
    Conexion::abrir_conexion();
    if($_POST['correo'] == 'lmao' && $_POST['clave'] == 'lol'){
        echo 'EL BICHO';
    } else {
        echo 'MI MADRE';
    }
}?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>>" class="fuente-R">
                        <div class="text-center">
                            <label for="correo">Correo electronico o nombre de usuario</label>
                            <br>
                            <input class="txb" type="text" name="correo" id="email" size="40" placeholder="Ej. Gustavo Hernandez">
                            <br>
                            <?php if(isset($_POST['ingresar'])){$validador -> mostrar_error();}?>
                            <label for="contraseña">Contraseña</label>
                            <br>
                            <input class="txb" type="password" name="clave" id="password" size="40" placeholder="Minimo 8 cáracteres" required autofocus>
                        </div>
                        <br>
                        <div class="text-center">
                            <button class="btn boton verde fuente-WM" type="submit" name="xd">Acceder</button>
                        </div>
                        <br>
                    </form>
<?php include_once 'cierre.php';?>