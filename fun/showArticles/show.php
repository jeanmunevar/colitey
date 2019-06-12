<?php
/**
 * Created by PhpStorm.
 * User: Marteen Munevar
 * Date: 29/04/2019
 * Time: 11:01 PM
 */

require ('./../conexion.php');
$cat = $_GET['categoria'];

consulta($cat);

function consulta($categoria)
{
    $consulta = "SELECT publicaciones.idpublicacion, publicaciones.titulo, publicaciones.prefacio, publicaciones.nota, publicaciones.imagen 
, publicaciones.directorio, publicaciones.idcategoria, publicaciones.fechaCreacion FROM publicaciones WHERE idcategoria = $categoria ORDER BY  publicaciones.fechaCreacion DESC";
    if ($res = mysqli_query(connectDB(), $consulta))
    {
        $data = array();
        while ($articulo = mysqli_fetch_assoc($res))
        {
            array_push($data, $articulo);
        }
        echo json_encode([
            'estado' => 'ok',
            'data' => $data
        ],JSON_UNESCAPED_UNICODE);
    }
    else{
        echo json_encode([
            'estado' => 'error',
            'data' => "salio mal".mysqli_error(connectDB())
        ],JSON_UNESCAPED_UNICODE);

    }
}




