<?php
/**
 * Created by PhpStorm.
 * User: Marteen Munevar
 * Date: 3/06/2019
 * Time: 11:54 AM
 */

//Por Get 1: Hace la selección de todo
//Por get 2: Elimina

//Ruta donde se almacenan los archivos
$directorio = "./repositorio";
$fecha= date('Y-m-d');


require './../conexion.php';
$conexion=connectDB();
if(isset($_GET['tipo'])){
    $tipo = $_GET['tipo'];
    switch ($tipo) {
        case '1':
            // SELECT de todo
            $query = "SELECT id, nombre, descripcion, directorio, fecha, filename FROM documentos_institucionales";
            $resultado = mysqli_query($conexion, $query);
            if($resultado){
                $data = [];
                while ($documento = mysqli_fetch_assoc($resultado)) {
                    array_push($data, $documento);
                }
                echo json_encode([
                    'estado' => 'ok',
                    'data' => $data
                ]);
            }else{
                echo json_encode([
                    'estado' => 'Error',
                    'mensaje' => 'Error al consultar '. mysqli_error($conexion)
                ]);
            }
            break;
        case '2':
            // DELETE del Estudiante
            $id=$_GET['id'];
            $sql1= "SELECT directorio FROM documentos_institucionales WHERE documentos_institucionales.id = '$id' LIMIT 1";
            $resultado = mysqli_query($conexion, $sql1);
            $data = [];
            while ($documento = mysqli_fetch_assoc($resultado)) {
                array_push($data, $documento);
            }
            $directorio = $data[0]['directorio'];



            if (unlink($directorio) /*or die("Couldn't delete file")*/) {
                $sql = "DELETE FROM documentos_institucionales WHERE id = '$id' ";
                //Se elminó el archivo
                if(mysqli_query($conexion, $sql)){
                    echo json_encode([
                        'estado' => 'ok',
                        'mensaje' => 'Documento  elimando!!'
                    ]);
                }else{
                    echo json_encode([
                        'estado' => 'Error',
                        'mensaje' => 'Error al eliminar en base de datos '. mysqli_error($conexion)
                    ]);
                }
            }
            else{
                echo json_encode([
                    'estado' => 'Error',
                    'mensaje' => 'Error Eliminado archivo '. mysqli_error($conexion)
                ]);
            }
            break;
        case '3':
            //Descargar archivo
            $fileName = $_GET['nombre'];

            $fileName = basename($fileName);
            $filePath = $_GET['directorio'];
            if(file_exists($filePath)){
                // Define headers
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$fileName");
                header("Content-Type: application/pdf");
                header("Content-Transfer-Encoding: binary");

                // Read the file
                readfile($filePath);
                exit;
            }else{
                echo 'The file does not exist.';
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
if (isset($_POST['nombre'])) {
    $id=$_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    if ($_FILES['documento'])
    {
        $documento = $_FILES['documento'];
        $documentoNombre = str_replace(" ","_",$documento['name']);
        $dir_db=$directorio."/".$documentoNombre;
    }


    $sql= "SELECT directorio FROM documentos_institucionales WHERE documentos_institucionales.id = '$id' LIMIT 1";
    if($resultado = mysqli_query($conexion, $sql)){
        if(mysqli_num_rows($resultado) > 0){
            // Actualización

            $docu=array();
            while ($documento = mysqli_fetch_assoc($resultado)){
                array_push($docu, $documento);
            }
            $directorioAnterior = $docu[0]['directorio'];

            if (!$_FILES['documento']){
                //No existe foto, entonces solo haz el update
                $update = "UPDATE documentos_institucionales SET nombre = '$nombre', descripcion = '$descripcion', fecha = '$fecha' WHERE id = '$id'";
                if(mysqli_query($conexion, $update)){
                    echo json_encode([
                        'estado' => 'ok',
                        'mensaje' => 'Archivo Actualizado'
                    ]);
                }else{
                    echo json_encode([
                        'estado' => 'Error',
                        'mensaje' => 'Error al actualizar '. mysqli_error($conexion)
                    ]);
                }
            }
            else{
                //Aqui verifico si los archivos son distintos
                if ($directorioAnterior !== $dir_db)
                {

                    //Elimina el archivo anterior
                    if (unlink($directorioAnterior)) {
                        //Doy permisos de lectura y escritura al directorio de archivos
                        chmod("./repositorio/", 0777);
                        $resultadoDocumento= move_uploaded_file($_FILES['documento']['tmp_name'], $dir_db);
                        $fileName = $_FILES['documento']['name'];
                        if ($resultadoDocumento ){
                            $update = "UPDATE documentos_institucionales SET nombre = '$nombre', descripcion = '$descripcion', directorio = '$dir_db', fecha = '$fecha', filename= '$fileName' WHERE id = '$id'";
                            if(mysqli_query($conexion, $update)){
                                echo json_encode([
                                    'estado' => 'ok',
                                    'mensaje' => 'Archivo Actualizado'
                                ]);
                            }else{
                                echo json_encode([
                                    'estado' => 'Error',
                                    'mensaje' => 'Error al actualizar '. mysqli_error($conexion)
                                ]);
                            }
                        }
                        else{
                            //No se subio el documento correctamente
                            echo json_encode([
                                'estado' => 'Error',
                                'mensaje' => "Not uploaded because of error #".$documento["error"]
                            ]);
                        }
                    }
                    else{
                        //Error eliminando el archivo
                        echo json_encode([
                            'estado' => 'Error',
                            'mensaje' => 'Error eliminando archivo '. mysqli_error($conexion)
                        ]);
                    }
                }
                else{
                    //Si son iguales  los archivos solo actualizar los otros datos
                    $update = "UPDATE documentos_institucionales SET nombre = '$nombre', descripcion = '$descripcion', fecha = '$fecha' WHERE nombre = '$nombre'";
                    if(mysqli_query($conexion, $update)){
                        echo json_encode([
                            'estado' => 'ok',
                            'mensaje' => 'Archivo Actualizado'
                        ]);
                    }else{
                        echo json_encode([
                            'estado' => 'Error',
                            'mensaje' => 'Error al actualizar '. mysqli_error($conexion)
                        ]);
                    }
                }

            }



        }else{
            //Nuevo
            $resultadoDocumento = move_uploaded_file($documento['tmp_name'], $dir_db);
            $fileName =$documento['name'];
            if ($resultadoDocumento)
            {
                $insert = "INSERT INTO documentos_institucionales(id, nombre, descripcion, filename, directorio, fecha) VALUES(DEFAULT, '$nombre', '$descripcion', '$fileName' ,'$dir_db', '$fecha')";
                if(mysqli_query($conexion, $insert)){
                    echo json_encode([
                        'estado' => 'ok',
                        'mensaje' => 'Documento creado'
                    ]);
                }else{
                    echo json_encode([
                        'estado' => 'Error',
                        'mensaje' => 'Error al crear en base de datos '. mysqli_error($conexion)
                    ]);
                }
            }
            else{
                //Error moviendo archivo al servidor
                echo json_encode([
                    'estado' => 'Error',
                    'mensaje' => 'Error al subir documento'
                ]);
            }

            //Mover el archivo a la ruta
        }
    }else{
        echo json_encode([
            'estado' => 'Error',
            'mensaje' => 'Error al consultar '. mysqli_error($conexion)
        ]);
    }
}