<?php
/**
 * Developer: Marteen Munevar
 * Date: 18/04/2019
 * Time: 7:51 PM
 */

require ('./../conexion.php');
$conexion = connectDB();
date_default_timezone_set('America/Bogota');
$d = date('d');
$m = date('m')-1;
$y = date('Y');
$titulo = $_POST['titulo'];$categoria = $_POST['categoria'];$nota = $_POST['nota'];$cuerpo = $_POST['cuerpo'];$usuario = $_POST['usuario'];
$imagen = $_FILES['imagen'];$video = $_FILES['video']; $nombreImagen = $imagen['name']; $nombreVideo= $video['name'];
$fecha= $y."-".$m."-".$d;
date_default_timezone_set('America/Bogota');
$d = date('d');
$m = date('m')-1;
$y = date('Y');
$estructuraDirectorio = "./../../img/mediaArticles/".$categoria."/".$fecha;

$rutaImagen = "/img/mediaArticles/".$categoria."/".$fecha."/".$nombreImagen;
$rutaVideo = "/img/mediaArticles/".$categoria."/".$fecha."/".$nombreVideo;


if (isset($_POST['function']))
{
    $funcion= $_POST['function'];
    switch ($funcion) {
        case '1':
            //Crear un articulo
            if (!is_dir($estructuraDirectorio))
            {
                if (mkdir($estructuraDirectorio, 0777, true))
                {
                    $resultadoImagen = move_uploaded_file($imagen["tmp_name"], "./../../img/mediaArticles/".$categoria."/".$fecha."/".$imagen['name']);
                    $resultadoVideo = move_uploaded_file($video["tmp_name"], "./../../img/mediaArticles/".$categoria."/".$fecha."/".$video['name']);
                    if ($resultadoImagen && $resultadoVideo) {
                        $crearArticuloSql = "INSERT INTO `publicaciones`(`idpublicacion`, `titulo`, `prefacio`, `nota`, `imagen`, `video`,  `usuario_id`, `idcategoria`, `fechaCreacion`)
                            VALUES (DEFAULT, '$titulo' , '$nota', '$cuerpo', '$rutaImagen', '$rutaVideo','$usuario','$categoria','$fecha') ";
                        if(mysqli_query($conexion, $crearArticuloSql))
                        {
                            echo json_encode(
                                [
                                    'data' => [
                                        'mensaje' => "ok",
                                        'descripcion' => 'Articulo subido correctamente'
                                    ]
                                ]
                                , JSON_UNESCAPED_UNICODE);
                        }
                        else{
                            echo json_encode(
                                [
                                    'data' => [
                                        'mensaje' => "error",
                                        'descripcion' => 'No se pudo subir a la base de datos'
                                    ]
                                ]
                                , JSON_UNESCAPED_UNICODE);
                        }
                    }
                    else
                    {
                        echo json_encode(
                            [
                                'data'=>[
                                    'mensaje' => "error",
                                    'descripcion' => 'Hubo un error subiendo los archivos'
                                ]
                            ]
                            , JSON_UNESCAPED_UNICODE);
                    }

                }
                else{
                    echo json_encode(
                        [
                            'data'=>[
                                'mensaje' => "error",
                                'descripcion' => 'Hubo un error creando el directorio'
                            ]
                        ]
                        , JSON_UNESCAPED_UNICODE);
                }
            }
            else{
                $resultadoImagen = move_uploaded_file($imagen["tmp_name"], "./../../img/mediaArticles/".$categoria."/".$fecha."/".$imagen['name']);
                $resultadoVideo = move_uploaded_file($video["tmp_name"], "./../../img/mediaArticles/".$categoria."/".$fecha."/".$video['name']);
                if ($resultadoImagen && $resultadoVideo) {
                    $crearArticuloSql = "INSERT INTO `publicaciones`(`idpublicacion`, `titulo`, `prefacio`, `nota`, `imagen`, `video`,  `usuario_id`, `idcategoria`, `fechaCreacion`)
                            VALUES (DEFAULT, '$titulo' , '$nota', '$cuerpo', '$rutaImagen', '$rutaVideo','$usuario','$categoria','$fecha') ";
                    if(mysqli_query($conexion, $crearArticuloSql))
                    {
                        echo json_encode(
                            [
                                'data' => [
                                    'mensaje' => "ok",
                                    'descripcion' => 'Articulo subido correctamente'
                                ]
                            ]
                            , JSON_UNESCAPED_UNICODE);
                    }
                    else{
                        echo json_encode(
                            [
                                'data' => [
                                    'mensaje' => "error",
                                    'descripcion' => 'No se pudo subir a la base de datos'
                                ]
                            ]
                            , JSON_UNESCAPED_UNICODE);
                    }
                }
                else
                {
                    echo json_encode(
                        [
                            'data'=>[
                                'mensaje' => "error",
                                'descripcion' => 'Hubo un error subiendo los archivos'
                            ]
                        ]
                        , JSON_UNESCAPED_UNICODE);
                }
            }

            break;
        case '2':
            //Editar
            break;
        case '3':
            //Eliminar

            break;

        default:

    }
}
//Para mostrar datos
if (isset($_GET['function']))
{
    $funcion = $_GET['function'];

    if ($funcion == '1')
    {
        $consultarArticuloSql = "SELECT idpublicacion, titulo, prefacio, imagen, video, idcategoria FROM publicaciones";
        $rezult = mysqli_query($conexion, $consultarArticuloSql);
        if ($rezult)
        {
            $data=array();
            while ($articulo = mysqli_fetch_assoc($rezult))
            {
                array_push($data, $articulo);
            }
        }
        echo json_encode([
            'estado' => 'ok',
            'data' => $data
        ],JSON_UNESCAPED_UNICODE);

    }


}




