<?php
//Esta clase contiene los métodos que permiten trabajar con la tabla Usuarios de la base de datos.

class RepositorioUsuario {

    public static function insertar_usuario($conexion, $usuario){
        if (isset($conexion)){
            try{
                $sql_1 = "INSERT INTO usuarios(nombre_usuario, correo, clave, fecha_registro, rol) VALUES(:nombre_usuario, :correo, :clave, NOW(), :rol)";
                $correo_temp = $usuario -> obtener_correo();
                $clave_temp = $usuario -> obtener_clave();
                $nombre_usuario_temp = $usuario -> obtener_nombre_usuario();
                $rol_temp = $usuario -> obtener_rol();
                $sentencia_1 = $conexion -> prepare($sql_1);
                $sentencia_1 -> bindParam(':correo', $correo_temp, PDO::PARAM_STR);
                $sentencia_1 -> bindParam(':clave', $clave_temp, PDO::PARAM_STR);
                $sentencia_1 -> bindParam(':nombre_usuario', $nombre_usuario_temp , PDO::PARAM_STR);
                $sentencia_1 -> bindParam(':rol', $rol_temp, PDO::PARAM_INT);
                $sentencia_1 -> execute();

                $select = "SELECT * FROM usuarios WHERE nombre_usuario = :nombre_usuario";
                $sentencia_select = $conexion -> prepare($select);
                $sentencia_select -> bindParam(':nombre_usuario', $nombre_usuario_temp , PDO::PARAM_STR);
                $sentencia_select -> execute();
                $resultadito = $sentencia_select -> fetch();
                
                $sql_2 = "INSERT INTO personas(nombres, ap_paterno, ap_materno, telefono, correo_contacto, usuario) VALUES(:nombres, :ap_paterno, :ap_materno, :telefono, :correo, :id_usuario)";
                $nombres_temp = $usuario -> obtener_nombres();
                $ap_paterno_temp = $usuario -> obtener_ap_paterno();
                $ap_materno_temp = $usuario -> obtener_ap_materno();
                $telefono_temp = $usuario -> obtener_telefono();
                $sentencia_2 = $conexion -> prepare($sql_2);
                $sentencia_2 -> bindParam(':nombres', $nombres_temp, PDO::PARAM_STR);
                $sentencia_2 -> bindParam(':ap_paterno', $ap_paterno_temp, PDO::PARAM_STR);
                $sentencia_2 -> bindParam(':ap_materno', $ap_materno_temp, PDO::PARAM_STR);
                $sentencia_2 -> bindParam(':telefono', $telefono_temp, PDO::PARAM_INT);
                $sentencia_2 -> bindParam(':correo', $resultadito['correo'], PDO::PARAM_STR);
                $sentencia_2 -> bindParam(':id_usuario', $resultadito['id_usuario'], PDO::PARAM_INT);
                $sentencia_2 -> execute();
                if ($rol_temp == 2) {
                    $select_vet = "SELECT * FROM personas WHERE nombres = :nombres_vet";
                    $sentencia_select_vet = $conexion -> prepare($select_vet);
                    $nombres_vet = $usuario -> obtener_nombres();
                    $sentencia_select_vet -> bindParam(':nombres_vet', $nombres_vet , PDO::PARAM_STR);
                    $sentencia_select_vet -> execute();
                    $resultadito_vet = $sentencia_select_vet -> fetch();    
                    $sql_vet = "INSERT INTO veterinarios(cedula, persona) VALUES(:cedula, :persona)";
                    $cedula_temp = $usuario->obtener_cedula();
                    $sentencia_vet = $conexion -> prepare($sql_vet);
                    $sentencia_vet -> bindParam(':cedula', $cedula_temp, PDO::PARAM_STR);
                    $sentencia_vet -> bindParam(':persona', $resultadito_vet['id_persona'], PDO::PARAM_INT);
                    $sentencia_vet -> execute();
                }
	    } catch(PDOException $ex){
		print "ERROR: ".$ex ->getMessage();
            }
        }   
    }

    public static function correo_disponible($conexion, $correo){
        $correo_disp = false;
        if(isset($conexion)){
            try{
                $sql = "SELECT * FROM usuarios WHERE correo = :correo";

                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':correo', $correo, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetchAll();
                if(count($resultado)){
                    $correo_disp = false;
                } else{
                    $correo_disp = true;
                }
            } catch (PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
        return $correo_disp;
    }
    public static function nombre_usuario_disponible($conexion, $nombre_usuario){
        $nombre_usuario_disp = false;
        if(isset($conexion)){
            try{
                $sql = "SELECT * FROM usuarios WHERE nombre_usuario = :nombre_usuario";

                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetchAll();
                if(count($resultado)){
                    $nombre_usuario_disp = false;
                } else{
                    $nombre_usuario_disp = true;
                }
            } catch (PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
        return $nombre_usuario_disp;
    }
    public static function telefono_disponible($conexion, $telefono){
        $telefono_disp = false;
        if(isset($conexion)){
            try{
                $sql = "SELECT * FROM personas WHERE telefono = :telefono";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':telefono', $telefono, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetchAll();
                if(count($resultado)){
                    $telefono_disp = false;
                } else{
                    $telefono_disp = true;
                }
            } catch (PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
        return $telefono_disp;
    }

    public static function obtener_usuario($conexion, $nom_o_correo){
        $usuario = null;
        if(isset($conexion)){
            try{
                include_once 'Usuario.inc.php';

                $sql = "SELECT * FROM usuarios AS u INNER JOIN personas AS p ON p.usuario = u.id_usuario WHERE
                u.correo = BINARY :nom_o_correo OR u.nombre_usuario = BINARY :nom_o_correo";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':nom_o_correo', $nom_o_correo, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetch();

                $filas_afectadas = $sentencia -> rowCount();
                if($filas_afectadas!==0){
                    $usuario = new Usuario($resultado['id_usuario'], $resultado['nombres'], $resultado['ap_paterno'], $resultado['ap_materno'],
                    $resultado['correo'], $resultado["clave"], $resultado['nombre_usuario'], $resultado['telefono'], $resultado['rol'],
                    $resultado['fecha_registro']);
                }
            } catch(PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
        return $usuario;
    }

    public static function editar_usuario($conexion, $usuario){
        if(isset($conexion)){
            try{
                $sql_1 = "UPDATE usuarios SET nombre_usuario = :nombre_usuario, correo = :correo WHERE id_usuario = :id_usuario";
                $correo_temp = $usuario -> obtener_correo();
                $nombre_usuario_temp = $usuario -> obtener_nombre_usuario();
                $id_temp = $usuario -> obtener_id_usuario();
                $sentencia_1 = $conexion -> prepare($sql_1);
                $sentencia_1 -> bindParam(':correo', $correo_temp, PDO::PARAM_STR);
                $sentencia_1 -> bindParam(':nombre_usuario', $nombre_usuario_temp , PDO::PARAM_STR);
                $sentencia_1 -> bindParam(':id_usuario', $id_temp , PDO::PARAM_INT);
                $sentencia_1 -> execute();

                $sql_2 = "UPDATE personas SET nombres = :nombres, ap_paterno = :ap_paterno, ap_materno = :ap_materno, 
                telefono = :telefono, correo_contacto = :correo_contacto WHERE usuario = :usuario";
                $nombres_temp = $usuario -> obtener_nombres();
                $app_temp = $usuario -> obtener_ap_paterno();
                $apm_temp = $usuario -> obtener_ap_materno();
                $tel_temp = $usuario -> obtener_telefono();
                $sentencia_2 = $conexion -> prepare($sql_2);
                $sentencia_2 -> bindParam(':nombres', $nombres_temp, PDO::PARAM_STR);
                $sentencia_2 -> bindParam(':ap_paterno', $app_temp, PDO::PARAM_STR);
                $sentencia_2 -> bindParam(':ap_materno', $apm_temp , PDO::PARAM_STR);
                $sentencia_2 -> bindParam(':telefono', $tel_temp , PDO::PARAM_INT);
                $sentencia_2 -> bindParam(':correo_contacto', $correo_temp, PDO::PARAM_STR);
                $sentencia_2 -> bindParam(':usuario', $id_temp, PDO::PARAM_INT);
                $sentencia_2 -> execute();

            } catch(PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
        return $usuario;
    }

    public static function cambiar_clave($conexion, $id_usuario, $clave){
        if(isset($conexion)){
            try{
                $sql = "UPDATE usuarios SET clave = :clave WHERE id_usuario = :id_usuario";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':clave', $clave, PDO::PARAM_STR);
                $sentencia -> bindParam(':id_usuario', $id_usuario , PDO::PARAM_INT);
                $sentencia -> execute();

            } catch(PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
    }
     public static function obtener_id_persona($conexion, $id_usuario){
        $id_persona = null;
        if(isset($conexion)){
            try{
                $sql = "SELECT p.id_persona from personas AS p INNER JOIN usuarios AS u ON p.usuario = u.id_usuario
                WHERE u.id_usuario = :id_usuario";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':id_usuario', $id_usuario , PDO::PARAM_INT);
                $sentencia -> execute();
                $resultado = $sentencia -> fetch();
                $id_persona = $resultado['id_persona'];

            } catch(PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
        return $id_persona;
     }

     public static function insertar_persona_invitada($conexion, $usuario){
        $id_persona = null;
        if (isset($conexion)){
            try{
                $sql = "INSERT INTO personas(nombres, ap_paterno, ap_materno, telefono, correo_contacto)
                VALUES(:nombres, :ap_paterno, :ap_materno, :telefono, :correo)";
                $nombres_temp = $usuario -> obtener_nombres();
                $ap_paterno_temp = $usuario -> obtener_ap_paterno();
                $ap_materno_temp = $usuario -> obtener_ap_materno();
                $telefono_temp = $usuario -> obtener_telefono();
                $correo_temp = $usuario -> obtener_correo();
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':nombres', $nombres_temp, PDO::PARAM_STR);
                $sentencia -> bindParam(':ap_paterno', $ap_paterno_temp, PDO::PARAM_STR);
                $sentencia -> bindParam(':ap_materno', $ap_materno_temp, PDO::PARAM_STR);
                $sentencia -> bindParam(':telefono', $telefono_temp, PDO::PARAM_INT);
                $sentencia -> bindParam(':correo', $correo_temp, PDO::PARAM_STR);
                $sentencia -> execute();

                $id_persona = $conexion -> lastInsertId();

            } catch(PDOException $ex){
            print "ERROR: ".$ex ->getMessage();
            }
            return $id_persona;
        }   
    }
}   
