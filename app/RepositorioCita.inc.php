<?php
//Esta clase contiene los métodos que permiten trabajar con la tabla Mascotas de la base de datos

class RepositorioCita {

    public static function insertar_cita($conexion, $cita){
        $correcto = false;
        if (isset($conexion)){
            try{
                $sql = "INSERT INTO citas(folio, veterinario, mascota, fecha, hora, completada) 
                VALUES(:folio, :veterinario, :mascota, :fecha, :hora, :completada)";
                $folio_temp = $cita -> obtener_folio();
                $veterinario_temp = $cita -> obtener_veterinario();
                $mascota_temp = $cita -> obtener_mascota();
                $fecha_temp = $cita -> obtener_fecha();
                $hora_temp = $cita -> obtener_hora();
                $completada_temp = $cita -> obtener_completada();
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':folio', $folio_temp, PDO::PARAM_STR);
                $sentencia -> bindParam(':veterinario', $veterinario_temp, PDO::PARAM_INT);
                $sentencia -> bindParam(':mascota', $mascota_temp , PDO::PARAM_INT);
                $sentencia -> bindParam(':fecha', $fecha_temp, PDO::PARAM_STR);
                $sentencia -> bindParam(':hora', $hora_temp, PDO::PARAM_STR);
                $sentencia -> bindParam(':completada', $completada_temp, PDO::PARAM_STR);
                $sentencia -> execute();                
                $id_cita = $conexion -> lastInsertId();

	    } catch(PDOException $ex){
		print "ERROR: ".$ex ->getMessage();
            }
        }
        return $id_cita;
    }

    public static function obtener_citas_pendientes($conexion, $id_mascota){
        $citas = [];
        if(isset($conexion)){
            try{
                include_once 'app/Cita.inc.php';

                $sql = "SELECT * FROM citas WHERE mascota = :mascota AND completada = 'NO'";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':mascota', $id_mascota, PDO::PARAM_INT);
                $sentencia -> execute();
                $resultado = $sentencia -> fetchAll();

                $filas_afectadas = $sentencia -> rowCount();
                if($filas_afectadas!==0){
                    foreach ($resultado as $fila){
                        $citas[] = new Cita($fila['id_cita'], $fila['folio'], $fila['veterinario'], 
                        $fila['mascota'], $fila['fecha'], $fila['hora'], $fila['completada']);
                    }
                }
            } catch(PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
        return $citas;
    }
    public static function obtener_citas_completadas($conexion, $id_mascota){
        $citas = [];
        if(isset($conexion)){
            try{
                include_once 'app/Cita.inc.php';

                $sql = "SELECT * FROM citas WHERE mascota = :mascota AND completada = 'SI'";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':mascota', $id_mascota, PDO::PARAM_INT);
                $sentencia -> execute();
                $resultado = $sentencia -> fetchAll();

                $filas_afectadas = $sentencia -> rowCount();
                if($filas_afectadas!==0){
                    foreach ($resultado as $fila){
                        $citas[] = new Cita($fila['id_cita'], $fila['folio'], $fila['veterinario'], 
                        $fila['mascota'], $fila['fecha'], $fila['hora'], $fila['completada']);
                    }
                }
            } catch(PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
        return $citas;
    }

    public static function obtener_cita_por_folio($conexion, $folio){
        $cita = null;
        if(isset($conexion)){
            try{
                include_once 'app/Mascota.inc.php';

                $sql = "SELECT * FROM citas AS c INNER JOIN datos_medicos AS dm WHERE c.folio = :folio";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':folio', $folio, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetch();

                $filas_afectadas = $sentencia -> rowCount();
                if($filas_afectadas!==0){
                        $cita = new Cita($resultado['id_cita'], $resultado['folio'], $resultado['veterinario'], 
                        $resultado['mascota'], $resultado['fecha'], $resultado['hora'], $resultado['completada']);
                }
            } catch(PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
        return $cita;
    }
    public static function obtener_datos_medicos($conexion, $id_cita){
        $datos = null;
        if(isset($conexion)){
            try{
                include_once 'app/Datos.inc.php';

                $sql = "SELECT * FROM datos_medicos WHERE cita = :cita";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':cita', $id_cita, PDO::PARAM_INT);
                $sentencia -> execute();
                $resultado = $sentencia -> fetch();

                $filas_afectadas = $sentencia -> rowCount();
                if($filas_afectadas!==0){
                        $datos = new Datos($resultado['id_datos'], $resultado['sintomas'], $resultado['temperatura_c'], 
                        $resultado['peso_kg'], $resultado['diagnostico'], $resultado['examen_abdomen'], $resultado['estado_org_int'],
                        $resultado['estado_org_ext'], $resultado['operado'], $resultado['grado_deshidratacion']);
                }
            } catch(PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
        return $datos;
    }
    public static function obtener_nombre_veterinario($conexion, $id_cita){
        $veterinario = [];
        if(isset($conexion)){
            try{
                $sql = "SELECT concat(p.nombres,' ', p.ap_paterno,' ', p.ap_materno) AS nombre, v.cedula FROM citas AS c
                INNER JOIN veterinarios AS v ON c.veterinario = v.id_veterinario INNER JOIN personas AS p ON v.persona = p.id_persona
                WHERE c.id_cita = :cita";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':cita', $id_cita, PDO::PARAM_INT);
                $sentencia -> execute();
                $resultado = $sentencia -> fetch();
                
                $filas_afectadas = $sentencia -> rowCount();
                if($filas_afectadas!==0){
                        $veterinario['nombre'] = $resultado['nombre'];
                        $veterinario['cedula'] = $resultado['cedula'];
                }
            } catch(PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
        return $veterinario;
    }
    public static function obtener_persona($conexion, $id_cita){
        $persona = null;
        if(isset($conexion)){
            try{
                include_once 'app/Mascota.inc.php';

                $sql = "SELECT concat(p.nombres,' ', p.ap_paterno,' ', p.ap_materno) AS nombre
                FROM citas AS c INNER JOIN mascotas AS m ON c.mascota = m.id_animal INNER JOIN personas AS p
                ON m.propietario = p.id_persona WHERE c.id_cita = :cita";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':cita', $id_cita, PDO::PARAM_INT);
                $sentencia -> execute();
                $resultado = $sentencia -> fetch();

                $filas_afectadas = $sentencia -> rowCount();
                if($filas_afectadas!==0){
                    $persona = $resultado['nombre'];
                }
            } catch(PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
        return $persona;
    }
    public static function obtener_receta($conexion, $id_datos){
        $receta = [];
        if(isset($conexion)){
            try{
                include_once 'app/Medicamento.inc.php';

                $sql = "SELECT m.nom_comercial AS nombre, rm.dosis, rm.dias, rm.horas 
                FROM receta_medicamento AS rm INNER JOIN medicamento AS m ON rm.medicamento = m.id_medicamento
                INNER JOIN recetas AS r ON rm.receta = r.id_receta WHERE r.datos = :id_datos";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':id_datos', $id_datos, PDO::PARAM_INT);
                $sentencia -> execute();
                $resultado = $sentencia -> fetchAll();

                $filas_afectadas = $sentencia -> rowCount();
                if($filas_afectadas!==0){
                    foreach ($resultado as $fila){
                        $receta[] = new Medicamento($fila['nombre'], $fila['dosis'], $fila['dias'], $fila['horas']);
                    }
                }
            } catch(PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
        return $receta;
    }
    public static function agregar_datos_medicos($conexion, $folio, $datos){
        if(isset($conexion)){
            try{
                include_once 'app/Datos.inc.php';
                $select = "SELECT id_cita FROM citas WHERE folio = :folio";
                $sentencia_s = $conexion -> prepare($select);
                $sentencia_s -> bindParam(':folio', $folio, PDO::PARAM_STR);
                $sentencia_s -> execute();
                $resultado = $sentencia_s -> fetch();

                $sql = "INSERT INTO datos_medicos VALUES('',:sintomas,:temp,:peso,:diagnostico,:cita,:abdomen,
                :org_int,:org_ext,:operado,:desh)";
                $sintomas_temp = $datos-> obtener_sintomas();
                $temp_temp = $datos -> obtener_temperatura();
                $peso_temp = $datos -> obtener_peso();
                $diagnostico_temp = $datos -> obtener_diagnostico();
                $abdomen_temp = $datos -> obtener_abdomen();
                $org_int_temp = $datos -> obtener_org_int();
                $org_ext_temp = $datos -> obtener_org_ext();
                $operado_temp = $datos -> obtener_operado();
                $desh_temp = $datos -> obtener_deshidratacion();
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':sintomas', $sintomas_temp, PDO::PARAM_STR);
                $sentencia -> bindParam(':temp', $temp_temp, PDO::PARAM_INT);
                $sentencia -> bindParam(':peso', $peso_temp , PDO::PARAM_INT);
                $sentencia -> bindParam(':diagnostico', $diagnostico_temp, PDO::PARAM_STR);
                $sentencia -> bindParam(':cita', $resultado['id_cita'], PDO::PARAM_STR);
                $sentencia -> bindParam(':abdomen', $abdomen_temp, PDO::PARAM_STR);
                $sentencia -> bindParam(':org_int', $org_int_temp, PDO::PARAM_STR);
                $sentencia -> bindParam(':org_ext', $org_ext_temp, PDO::PARAM_STR);
                $sentencia -> bindParam(':operado', $operado_temp, PDO::PARAM_STR);
                $sentencia -> bindParam(':desh', $desh_temp, PDO::PARAM_STR);
                $sentencia -> execute();
                
                $id_datos = $conexion -> lastInsertId();
                $sql_2 = "INSERT into recetas VALUES('', :datos)";
                $sentencia_2 = $conexion -> prepare($sql_2);
                $sentencia_2 -> bindParam(':datos', $id_datos , PDO::PARAM_INT);
                $sentencia_2 -> execute();

            } catch(PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
    }
    public static function agregar_med_receta($conexion, $folio, $medicamento){
        if(isset($conexion)){
            try{
                include_once 'app/Medicamento.inc.php';
                $select = "SELECT r.id_receta FROM citas AS c INNER JOIN datos_medicos AS dm ON dm.cita = c.id_cita
                INNER JOIN recetas AS r ON r.datos = dm.id_datos WHERE c.folio = :folio";
                $sentencia_s = $conexion -> prepare($select);
                $sentencia_s -> bindParam(':folio', $folio, PDO::PARAM_STR);
                $sentencia_s -> execute();
                $resultado = $sentencia_s -> fetch();

                $sql = "INSERT INTO receta_medicamento VALUES(:receta,:medicamento,:dosis,:horas,:dias)";
                $med_temp = $medicamento -> obtener_nombre();
                $dosis_temp = $medicamento -> obtener_dosis();
                $horas_temp = $medicamento -> obtener_horas();
                $dias_temp = $medicamento -> obtener_dias();
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':receta', $resultado['id_receta'], PDO::PARAM_INT);
                $sentencia -> bindParam(':medicamento', $med_temp, PDO::PARAM_INT);
                $sentencia -> bindParam(':dosis', $dosis_temp , PDO::PARAM_STR);
                $sentencia -> bindParam(':horas', $horas_temp, PDO::PARAM_STR);
                $sentencia -> bindParam(':dias', $dias_temp, PDO::PARAM_STR);
                $sentencia -> execute();

            } catch(PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
    }
    public static function revisar_datos_med($conexion, $folio){
        $existen_datos = false;
        if(isset($conexion)){
            try{
                $sql = "SELECT * FROM datos_medicos AS dm INNER JOIN citas AS c ON dm.cita = c.id_cita
                WHERE c.folio = :folio";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':folio', $folio, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetchAll();
                if(count($resultado)){
                    $existen_datos = false;
                } else{
                    $existen_datos = true;
                }
            } catch (PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
        return $existen_datos;
    }
    public static function completada($conexion, $folio){
        $completada = false;
        if(isset($conexion)){
            try{
                $sql = "SELECT * FROM citas WHERE folio = :folio";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':folio', $folio, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetch();
                if($resultado['completada'] == 'NO'){
                    $completada = false;
                } else if($resultado['completada'] == 'SI'){
                    $completada = true;
                }
            } catch (PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
        return $completada;
    }
    public static function completar($conexion, $folio){
        if(isset($conexion)){
            try{
                $sql = "UPDATE citas SET completada = 'SI' WHERE folio = :folio";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':folio', $folio, PDO::PARAM_STR);
                $sentencia -> execute();

            } catch (PDOException $ex){
                print "ERROR: ". $ex -> getMessage();
            }
        }
    }
}   