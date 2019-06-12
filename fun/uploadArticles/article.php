<?php
/**
 * Developer: Marteen Munevar
 * Date: 18/04/2019
 * Time: 7:51 PM
 */


require ('./../conexion.php');
$fecha= date('Y-m-d');
$conexion = connectDB();
$directorio = "./../../img/mediaArticles";//Aqui se define el directorio donde se almacena la media de los articulos

// Peticiones tipo GET, Eliminar, Consultar
if ($_GET['tipo']){
    $tipo = $_GET['tipo'];
    switch ($tipo) {
        case '1':
            // SELECT de todo
            $query = "SELECT  idpublicacion, titulo, prefacio, nota,imagen, idcategoria, directorio, fechaCreacion FROM publicaciones";
            $resultado = mysqli_query($conexion, $query);
            if($resultado){
                $data = [];
                while ($articulo = mysqli_fetch_assoc($resultado)) {
                    array_push($data, $articulo);
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
            $sql1= "SELECT directorio, idcategoria FROM publicaciones WHERE publicaciones.idpublicacion = '$id' LIMIT 1";
            $resultado = mysqli_query($conexion, $sql1);
            $data = [];

            while ($articulo = mysqli_fetch_assoc($resultado)) {
                array_push($data, $articulo);
            }
            $idcategoria = $data[0]['idcategoria'];
            $directorio = $data[0]['directorio'];
            if ($idcategoria !=='4'){
                if (unlink($directorio) /*or die("Couldn't delete file")*/) {
                    $sql = "DELETE FROM publicaciones WHERE idpublicacion = '$id' ";
                    //Se elminó el archivo
                    if(mysqli_query($conexion, $sql)){
                        echo json_encode([
                            'estado' => 'ok',
                            'mensaje' => 'Articulo elimando!!'
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
            }else{
                $sql = "DELETE FROM publicaciones WHERE idpublicacion = '$id' ";
                //Se elminó el archivo
                if(mysqli_query($conexion, $sql)){
                    echo json_encode([
                        'estado' => 'ok',
                        'mensaje' => 'Articulo elimando!!'
                    ]);
                }else{
                    echo json_encode([
                        'estado' => 'Error',
                        'mensaje' => 'Error al eliminar en base de datos '. mysqli_error($conexion)
                    ]);
                }
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
//Peticiones tipo post, Crear, editar
if ($_POST['idcategoria']){
    /****************   Aqui se recibe los datos que se enviaron por post  **********************/
    $idpublicacion = $_POST['idpublicacion'];
    $titulo = $_POST['titulo'];
    $idcategoria = $_POST['idcategoria'];
    $prefacio= $_POST['prefacio'];
    $nota = $_POST['nota'];
    $cuerpo = $_POST['cuerpo'];


    /********************************************************************************************/
    if ($_FILES['imagen']){
        $imagen = $_FILES['imagen'];
        $nombreImagen = str_replace(" ","_",$imagen['name']);
        $dir_db=$directorio."/".$idcategoria."/".$nombreImagen;
    }
    //Aca consulto si existe algun registro o publicacion con ese id
    $sql= "SELECT directorio, idcategoria, imagen FROM publicaciones WHERE idpublicacion = '$idpublicacion' ";
    if($resultado = mysqli_query($conexion, $sql)) {
        if(mysqli_num_rows($resultado) > 0){
            //Si existe el registre, es una actualización

            $docu=array();
            //Aca obtengo el directorio que me sirve para comparar si son el mismo archivo o es distinto
            while ($documento = mysqli_fetch_assoc($resultado)){
                array_push($docu, $documento);
            }
            //Debido a que los mensajes no utilizan fotos voy a actualizarlos desde aqui
            if ($idpublicacion === '4'){
                $update = "UPDATE publicaciones SET titulo = '$titulo', prefacio ='$prefacio'
                          WHERE idpublicacion ='$idpublicacion'
                          AND idcategoria = '$idcategoria'";
                if(mysqli_query($conexion, $update)){
                    echo json_encode([
                        'estado' => 'ok',
                        'mensaje' => 'Mensaje  Actualizad0'
                    ]);
                }else{
                    echo json_encode([
                        'estado' => 'Error',
                        'mensaje' => 'Error al actualizar mensaje'. mysqli_error($conexion)
                    ]);
                }
            }
            //************************************************************************************//

            $directorioAnterior = $docu[0]['directorio'];
            $idcategoriaAnterior = $docu[0]['idcategoria'];
            $imagenAnterior = $docu[0]['imagen'];

            if (!$_FILES['imagen']){//No existe una imagen para actualizar
                if ($idcategoria !== $idcategoriaAnterior){
                    //Si son distintos, eso quiere decir que actualizaron la categoria, por lo cual debe moverse al directorio nuevo
                    chmod($directorio."/", 0777);
                    if (rename($directorioAnterior, $directorio."/".$idcategoria."/".$imagenAnterior)){
                        //Se envio la data al archivo
                        $dirToUpdate = $directorio."/".$idcategoria."/".$imagenAnterior;

                        $update = "UPDATE publicaciones SET titulo = '$titulo', prefacio ='$prefacio', nota = '$nota', 
                         directorio = '$dirToUpdate', idcategoria = '$idcategoria'  WHERE idpublicacion ='$idpublicacion'
                          AND idcategoria = '$idcategoriaAnterior'";
                        if(mysqli_query($conexion, $update)){
                            echo json_encode([
                                'estado' => 'ok',
                                'mensaje' => 'Publicacion Actualizada 1'
                            ]);
                        }else{
                            echo json_encode([
                                'estado' => 'Error',
                                'mensaje' => 'Error al actualizar '. mysqli_error($conexion)
                            ]);
                        }

                    }
                    else{
                        //No se envio el archivo
                        echo json_encode([
                            'estado' => 'Error',
                            'mensaje' => 'Error al mover el archivo al nuevo directorio  '
                        ]);
                    }
                }
                else{
                    //Las categorias de los archivos son iguales, pero quiere actualizar datos
                    $update = "UPDATE publicaciones SET titulo = '$titulo', prefacio ='$prefacio', nota = '$nota' 
                          WHERE idpublicacion ='$idpublicacion'
                          AND idcategoria = '$idcategoriaAnterior'";
                    if(mysqli_query($conexion, $update)){
                        echo json_encode([
                            'estado' => 'ok',
                            'mensaje' => 'Publicacion Actualizada 2'
                        ]);
                    }else{
                        echo json_encode([
                            'estado' => 'Error',
                            'mensaje' => 'Error al actualizar '. mysqli_error($conexion)
                        ]);
                    }
                }
            }
            else{
                //Existe un documento enviado
                if ($idcategoria !== $idcategoriaAnterior){
                    //Si son distintos, eso quiere decir que actualizaron la categoria, por lo cual debe moverse al directorio nuevo
                    chmod($directorio."/", 0777);
                    if (rename($directorioAnterior, $dir_db)){
                        //Se envio la data al archivo


                        $update = "UPDATE publicaciones SET titulo = '$titulo', prefacio ='$prefacio', nota = '$nota', 
                         directorio = '$dir_db', idcategoria = '$idcategoria', imagen='$nombreImagen'  WHERE idpublicacion ='$idpublicacion'
                          AND idcategoria = '$idcategoriaAnterior'";
                        if(mysqli_query($conexion, $update)){
                            echo json_encode([
                                'estado' => 'ok',
                                'mensaje' => 'Publicacion Actualizada 3'
                            ]);
                        }else{
                            echo json_encode([
                                'estado' => 'Error',
                                'mensaje' => 'Error al actualizar '. mysqli_error($conexion)
                            ]);
                        }

                    }
                    else{
                        //No se envio el archivo
                        echo json_encode([
                            'estado' => 'Error',
                            'mensaje' => 'Error al mover el archivo al nuevo directorio  '
                        ]);
                    }
                }
                else{
                    //Las categorias de los archivos son iguales,
                    //Verificamos si es el mismo archivo
                    if ($directorioAnterior !== $dir_db) {
                        //Los directorios son distintos
                        if (unlink($directorioAnterior)) {
                            //Doy permisos de lectura y escritura al directorio de archivos
                            chmod($directorio."/", 0777);
                            $resultadoDocumento= move_uploaded_file($_FILES['imagen']['tmp_name'], $dir_db);
                            $fileName = $_FILES['imagen']['name'];
                            if ($resultadoDocumento ){
                                $update = "UPDATE publicaciones SET titulo ='$titulo', prefacio = '$prefacio', nota ='$nota', imagen = '$fileName', directorio = '$dir_db' 
                                WHERE idpublicacion ='$idpublicacion' AND idcategoria = '$idcategoria'";
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
                        //Los directorios son iguales, por lo cual solo vamos a actualizar datos
                        $update = "UPDATE publicaciones SET titulo ='$titulo', prefacio = '$prefacio', nota ='$nota' WHERE idpublicacion = '$idpublicacion'";
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

                    //Elimina el archivo anterior

                }

            }
        }
        else{
            //Sino existe el registro, es un articulo nuevo
            //If para crear articulo tipo mensaje
            if ($idcategoria === '4'){
                $insert = "INSERT INTO publicaciones (idpublicacion, titulo, prefacio, nota, imagen, usuario_id, idcategoria, directorio, fechaCreacion) 
                          VALUES (DEFAULT, '$titulo', '$prefacio', '', '$nombreImagen', 'root','$idcategoria', '', '$fecha' )";
                if(mysqli_query($conexion, $insert)){
                    echo json_encode([
                        'estado' => 'ok',
                        'mensaje' => 'Mensaje creado'
                    ]);
                }else{
                    echo json_encode([
                        'estado' => 'Error',
                        'mensaje' => 'Error al crear mensaje en base de datos '. mysqli_error($conexion)
                    ]);
                }
            }
            else{
                $resultadoDocumento = move_uploaded_file($imagen['tmp_name'], $dir_db);
                $fileName =$imagen['name'];
                if ($resultadoDocumento) {
                    $insert = "INSERT INTO publicaciones (idpublicacion, titulo, prefacio, nota, imagen, usuario_id, idcategoria, directorio, fechaCreacion) 
                          VALUES (DEFAULT, '$titulo', '$prefacio', '$nota', '$nombreImagen', 'root','$idcategoria', '$dir_db', '$fecha' )";
                    if(mysqli_query($conexion, $insert)){
                        echo json_encode([
                            'estado' => 'ok',
                            'mensaje' => 'Publicacion creada'
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
            }





        }
    }
    else{
        echo json_encode([
            'estado' => 'Error',
            'mensaje' => 'Error al consultar '. mysqli_error($conexion)
        ]);
    }

}










