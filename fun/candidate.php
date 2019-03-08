<?php
/**
 * Created by PhpStorm.
 * User: Marteen Munevar
 * Date: 3/03/2019
 * Time: 8:06 PM
 */
require('./conexion.php');
$conexion = connectDB();

//Si los datos se reciben por get
if(isset($_GET['tipo'])){
    $tipo = $_GET['tipo'];
    switch ($tipo) {
        case '1':
            // SELECT de todo
            $query = "SELECT candidatos.documento, candidatos.nombre, imagen,tipodocumento.tipoDocumento, jornada.jornada,  cursosgrados.grado, cursosgrados.curso, cargos.nombreCargo FROM candidatos, tipodocumento, jornada, cursosgrados, cargos WHERE  candidatos.tipoDocumento = tipodocumento.idtipoDocumento AND candidatos.jornada = jornada.idJornada AND candidatos.grado_curso = cursosgrados.id AND candidatos.cargo = cargos.idcargos";
            $resultado = mysqli_query($conexion, $query);
            if($resultado){
                $data = [];
                while ($candidato = mysqli_fetch_assoc($resultado)) {
                    array_push($data, $candidato);
                }

                echo json_encode([
                    'estado' => 'ok',
                    'data' => $data

                ]);
            }else{
                echo json_encode([
                    'estado' => 'Error',
                    'mensaje' => 'Error al consultar '
                ]);
            }
            break;
        case '2':
            // Eliminar el estudiante
            $documento = $_GET['doc'];
            $sql = "DELETE FROM candidatos WHERE documento = $documento";
            if(mysqli_query($conexion, $sql)){
                echo json_encode([
                    'estado' => 'ok',
                    'mensaje' => 'Estudiante elimando!!'
                ]);
            }else{
                echo json_encode([
                    'estado' => 'Error',
                    'mensaje' => 'Error al consultar '
                ]);
            }
            break;
        default:
            // Mensaje de Error
            echo json_encode([
                'estado' => 'Error',
                'mensaje' => 'Opcion no permitida!!'
            ]);
            break;
    }
}



//Si los datos se reciben por POST
if (isset($_POST['documento']))
{
    $tipoDocumento = $_POST['tipoDocumento'];
    $documento = $_POST['documento'];
    $nombre = $_POST['nombre'];
    $cargo = $_POST['cargo'];
    $grado = $_POST['grado'];
    $jornada = $_POST['jornada'];
    $imagen = $_POST['imagen'];



    $sql = "SELECT * FROM candidatos WHERE documento = '$documento' LIMIT  1";
    if($resultado = mysqli_query($conexion, $sql)){
        if(mysqli_num_rows($resultado) > 0){
            // Actualización
            $update = "UPDATE candidatos SET nombre = '$nombre' , tipoDocumento = '$tipoDocumento', grado_curso = '$grado', imagen = '$imagen', jornada = '$jornada' WHERE documento = $documento";
            if(mysqli_query($conexion, $update)){
                echo json_encode([
                    'estado' => 'ok',
                    'mensaje' => 'Estudiante actualizado!!'
                ]);
            }else{
                echo json_encode([
                    'estado' => 'Error',
                    'mensaje' => 'Error al actualizar '
                ]);
            }
        }else{
            //Nuevo
            $insert = "INSERT INTO candidatos (idCandidato, documento, cargo, tipoDocumento, grado_curso, jornada, nombre, imagen) VALUES (DEFAULT, '$documento', '$cargo', '$tipoDocumento', '$grado', '$jornada', '$nombre', '$imagen')";
            if(mysqli_query($conexion, $insert)){
                echo json_encode([
                    'estado' => 'ok',
                    'mensaje' => 'Candidato creado'
                ]);
            }else{
                echo json_encode([
                    'estado' => 'Error',
                    'mensaje' => 'Error al crear '
                ]);
            }
        }
    }else{
        echo json_encode([
            'estado' => 'Error',
            'mensaje' => 'Error al consultar '
        ]);
    }
}
