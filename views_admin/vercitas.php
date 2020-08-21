<?php
    $titulo = 'Administrar citas';
    $clase = 'admin';
    include_once 'app/config.inc.php';
    include_once 'app/Conexion.inc.php';
    include_once 'app/RepositorioUsuario.inc.php';
    include_once 'templates/declaracion.php';
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand text-secondary fuente-WM" href="<?php echo SERVER?>">
            <img src="<?php echo RUTA_IMG?>/iconadmin.png" width="30" height="30"
                class="d-inline-block align-top" alt="" loading="lazy">
            HUELLITAS
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Veterinaria
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Clientes</a>
                        <a class="dropdown-item" href="#">Veterinarios</a>
                        <a class="dropdown-item" href="#">Citas</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Llenar recetas</a>
                        <a class="dropdown-item" href="#">Llenar consulta</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Administración
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Servicios</a>
                        <a class="dropdown-item" href="#">Especies</a>
                        <a class="dropdown-item" href="#">Medicamentos</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Registrar usuario</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="sombreado-g"></div>
</header>
<div class="fila">
    <table class="table table-light table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Folio</th>
                <th>Veterinario</th>
                <th>Mascota</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ejemplo</td>
                <td>ejemplo</td>
                <td>ejemplo</td>
                <td>ejemplo</td>
                <td>ejemplo</td>
                <td>ejemplo</td>
            </tr>
            <tr>
                <td>ejemplo</td>
                <td>ejemplo</td>
                <td>ejemplo</td>
                <td>ejemplo</td>
                <td>ejemplo</td>
                <td>ejemplo</td>
            </tr>
            <tr>
                <td>ejemplo</td>
                <td>ejemplo</td>
                <td>ejemplo</td>
                <td>ejemplo</td>
                <td>ejemplo</td>
                <td>ejemplo</td>
            </tr>
        </tbody>
        <tfoot class="text-center fuente-WM">
            <tr>
                <td colspan="2"><button class="btn boton">Agregar</button></td>
                <td colspan="2"><button class="btn boton-gris">Editar</button></td>
                <td colspan="2"><button class="btn boton-naranja">Eliminar</button></td>
            </tr>
        </tfoot>
    </table>
</div>
<div class="esconde-logo"></div>
<?php include_once 'templates/cierre.php'?>