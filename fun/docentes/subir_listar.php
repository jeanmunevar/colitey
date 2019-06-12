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

$directorio = "./../../img/docentes";
$fecha= date('Y-m-d');


require './../conexion.php';
$conexion=connectDB();
if(isset($_GET['tipo'])){
    $tipo = $_GET['tipo'];
    switch ($tipo) {
        case '1':
            // SELECT de todo
            $query = "SELECT iddocente, documento, nombre, fechaNacimiento, docentes.idrol,
            perfil, email, foto, filename, rol.rol
            FROM docentes INNER JOIN rol ON docentes.idrol = rol.idrol";
            $resultado = mysqli_query($conexion, $query);
            if($resultado){
                $data = [];
                while ($docente = mysqli_fetch_assoc($resultado)) {
                    array_push($data, $docente);
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
            $documento=$_GET['documento'];
            $sql1= "SELECT foto FROM docentes WHERE documento = '$documento' LIMIT 1";
            $resultado = mysqli_query($conexion, $sql1);
            $data = [];
            while ($docente = mysqli_fetch_assoc($resultado)) {
                array_push($data, $docente);
            }
            $directorio =$directorio."/". $data[0]['foto'];



            if (unlink($directorio) /*or die("Couldn't delete file")*/) {
                $sql = "DELETE FROM docentes WHERE documento= '$documento' ";
                //Se elminó el archivo
                if(mysqli_query($conexion, $sql)){
                    echo json_encode([
                        'estado' => 'ok',
                        'mensaje' => 'Docente   elimando!!'
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
            //
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

    $iddocente = $_POST['iddocente'];
    $documento = $_POST['documento'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $idrol = $_POST['idrol'];
    $perfil = $_POST['perfil'];
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    //Aca verifico si existe la foto, y obtengo los datos,
    if ($_FILES['foto'])
    {
        $foto = $_FILES['foto'];
        $fotoNombre = str_replace(" ","_",$foto['name']);
        $dir_db=$directorio."/".$fotoNombre;
    }




    $sql= "SELECT foto FROM docentes WHERE docentes.documento = '$documento' LIMIT 1";
    if($resultado = mysqli_query($conexion, $sql)){
        if(mysqli_num_rows($resultado) > 0){
            // Actualización

            $docu=array();
            while ($docent = mysqli_fetch_assoc($resultado)){
                array_push($docu, $docent);
            }
            $directorioAnterior =$directorio."/".$docu[0]['foto'];

            if (!$_FILES['foto'])
            {
                //Sino existe la foto enviada, solo que haga la actualización de datos
                $update = "UPDATE docentes SET documento= '$documento', fechaNacimiento = '$fechaNacimiento',
                                idrol = '$idrol', perfil = '$perfil', email = '$email' WHERE documento = '$documento'  LIMIT 1";
                if(mysqli_query($conexion, $update)){
                    echo json_encode([
                        'estado' => 'ok',
                        'mensaje' => 'Documento Actualizado'
                    ]);
                }else{
                    echo json_encode([
                        'estado' => 'Error',
                        'mensaje' => 'Error al actualizar '. mysqli_error($conexion)
                    ]);
                }

            }
            else{
                //Si existe una foto que se haya enviado
                if ($directorioAnterior !== $dir_db)
                {

                    //Elimina el archivo anterior
                    if (file_exists($directorioAnterior)) {
                        //El archivo existe
                        if (unlink($directorioAnterior)) {
                            //Doy permisos de lectura y escritura al directorio de archivos
                            chmod("./../../img/docentes/", 0777);
                            $resultadoDocumento= move_uploaded_file($_FILES['foto']['tmp_name'], $dir_db);
                            $fileName = $_FILES['foto']['name'];
                            if ($resultadoDocumento ){
                                $update = "UPDATE docentes SET documento= '$documento', fechaNacimiento = '$fechaNacimiento',
                                idrol = '$idrol', perfil = '$perfil', email = '$email', foto ='$fileName' WHERE documento = '$documento'  LIMIT 1";
                                if(mysqli_query($conexion, $update)){
                                    echo json_encode([
                                        'estado' => 'ok',
                                        'mensaje' => 'Documento Actualizado'
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
                        //El archivo no existe
                        chmod("./../../img/docentes/", 0777);
                        $resultadoDocumento= move_uploaded_file($_FILES['foto']['tmp_name'], $dir_db);
                        $fileName = $_FILES['foto']['name'];
                        if ($resultadoDocumento ){
                            $update = "UPDATE docentes SET documento= '$documento', fechaNacimiento = '$fechaNacimiento',
                        idrol = '$idrol', perfil = '$perfil', email = '$email', foto ='$fileName' WHERE documento = '$documento'  LIMIT 1";
                            if(mysqli_query($conexion, $update)){
                                echo json_encode([
                                    'estado' => 'ok',
                                    'mensaje' => 'Documento Actualizado'
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

                }
                else{
                    //Si son iguales  los archivos solo actualizar los otros datos
                    $update = "UPDATE docentes SET documento= '$documento', nombre = '$nombre' ,fechaNacimiento = '$fechaNacimiento',
                        idrol = '$idrol', perfil = '$perfil', email = '$email' WHERE documento = '$documento'  LIMIT 1";
                    if(mysqli_query($conexion, $update)){
                        echo json_encode([
                            'estado' => 'ok',
                            'mensaje' => 'Docente Actualizadox'
                        ]);
                    }else{
                        echo json_encode([
                            'estado' => 'Error',
                            'mensaje' => 'Error al actualizar '. mysqli_error($conexion)
                        ]);
                    }
                }
            }
            //Aqui verifico si los archivos son distintos


        }else{
            //Nuevo
            $resultadoDocumento = move_uploaded_file($foto['tmp_name'], $dir_db);
            $foto =$foto['name'];
            if ($resultadoDocumento)
            {
                $insert = "INSERT INTO docentes (iddocente, documento, nombre, fechaNacimiento, idrol, perfil, email, foto, filename) 
                            VALUES(DEFAULT,'$documento', '$nombre', '$fechaNacimiento', '$idrol', '$perfil', '$email',
                                    '$foto', '') ";
                if(mysqli_query($conexion, $insert)){
                    echo json_encode([
                        'estado' => 'ok',
                        'mensaje' => 'Docente creado'
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