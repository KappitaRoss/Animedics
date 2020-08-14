<?php
//Así no va a ser esto, mañana lo edito, es sólo para ejemplificar.
$titulo = "Mi Perfil";
include_once "app/config.inc.php";
include_once "templates/declaracion.php";
include_once "templates/navbar.php";

if(Sesion::sesion_iniciada()){
    Redireccion::redirigir(SERVER);
}
Conexion::abrir_conexion();
$usuario = RepositorioUsuario::obtener_usuario(Conexion::obtener_conexion(), $_SESSION['nombre_usuario']); 

if(isset($_POST['guardar'])){
    $cambio_listo == false;
    $validador = new ValidadorPerfil(Conexion::obtener_conexion(), $_POST['nombres'], $_POST['ap_paterno'], $_POST['ap_materno'], 
    $_POST['correo'], $_POST['nom_usuario'], $_POST['telefono'], $usuario -> obtener_nombre_usuario(), $usuario -> obtener_correo(),
    $usuario -> obtener_telefono());
    if($validador -> validar_edicion()){
        $usuario_c = new Usuario($_SESSION['id_usuario'], $validador -> obtener_nombres(), $validador -> obtener_ap_paterno(), $validador -> obtener_ap_materno(),
        $validador -> obtener_correo(),'', $validador -> obtener_nom_usuario(), $validador -> obtener_telefono(), '', '');
        RepositorioUsuario::editar_usuario(Conexion::obtener_conexion(), $usuario_c);
        $cambio_listo == true; 
    }
}
Conexion::cerrar_conexion();
?>
<body>
    <div class="container justify-content-center fila borde-redondo borde-verde">
    <form method="post" action="<?php echo htmlspecialchars(RUTA_PERFIL);?>">
        <table class="table table-hover bg-blanco text-center fuente-R">
        <?php if(isset($_POST['editar'])){
            if(isset($_POST['cancelar'])||isset($_POST['guardar'])&&$cambio_listo == true){
                include_once 'templates/perfil_ver'; 
            } else {
                if(isset($_POST['guardar'])){
                    include_once 'templates/perfil_editar_validado';
                } else{
                    include_once 'templates/perfil_editar_vacio';
                }
            }
        } else{
            include_once 'templates/perfil_ver';
        }?>
        </table>
    </form>
    </div>
    <br><br><br><br><br><br><br><br><br>    <!--Preciso que el footer se vea así XD-->
<?php include_once "templates/cierre.php";?>