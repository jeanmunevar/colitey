<?php
/**
 * Created by PhpStorm.
 * User: Marteen Munevar
 * Date: 14/05/2019
 * Time: 8:41 PM
 */

require ('./../conexion.php'); $conexion = connectDB();

//Si la variable es por get
if (isset($_GET['func']))
{
    $func = $_GET['func'];
    if ($func == '1')
    {
        //Listar los profesores
        $sqlProfes = "SELECT foto, nombre, perfil, email, iddocente FROM docentes";
        $res = mysqli_query($conexion, $sqlProfes);
        $arrayProfes = array();
        while($profe= mysqli_fetch_assoc($res))
        {
            array_push($arrayProfes, $profe);
        }
        echo json_encode([
           'estado' => 'ok',
           'data' => $arrayProfes
        ], JSON_UNESCAPED_UNICODE);
    }
}
