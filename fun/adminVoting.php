<?php
/**
 * Created by PhpStorm.
 * User: Marteen Munevar
 * Date: 27/02/2019
 * Time: 10:42 PM
 */
require_once ('conexion.php');
$conexion = connectDB();

$id=(file_get_contents("php://input"));
$datos = json_decode($id, true);



$usuario = $datos['usuario'];
$password = $datos['password'];


$consultaEstudiante = "SELECT * FROM `usuario` WHERE usuario.usuario = '$usuario' AND password = MD5('$password')";
//Se genera la consulta
$result = mysqli_query($conexion, $consultaEstudiante);
$infoEstudiante = array();
if ($result){
    while ($alumno = mysqli_fetch_assoc($result)){
        array_push($infoEstudiante, $alumno);
    }
}

$registros = mysqli_num_rows($result);
if ($registros == 0)
{
    $arrayVacio = array();
    echo json_encode([
        'data' => "vacio",
    ], JSON_UNESCAPED_UNICODE);

}
else{
    echo json_encode([
        'data' => "Bien hecho"
    ], JSON_UNESCAPED_UNICODE);
}
