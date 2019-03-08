<?php
/**
 * Created by PhpStorm.
 * User: Marteen Munevar
 * Date: 25/02/2019
 * Time: 12:32 AM
 */
require_once ('conexion.php');
$id=(file_get_contents("php://input"));
$documento = json_decode($id, true);
$conexion = connectDB();

$id = $documento['documento'];
$fechaBorn = $documento['fechaNacimiento'];


$consultaEstudiante = "SELECT * FROM estudiante WHERE documento = $id AND estudiante.fechaNacimiento = '$fechaBorn'";
//Se genera la consulta
$result = mysqli_query($conexion, $consultaEstudiante);
$infoEstudiante = array();
if ($result){
    while ($alumno = mysqli_fetch_assoc($result)){
        array_push($infoEstudiante, $alumno);
    }
}
///////////////////////////////
$consultaCandidatos = 'SELECT documento, cargo, cursosgrados.curso, cursosgrados.grado ,nombre, imagen FROM candidatos, cursosgrados WHERE candidatos.cargo = "2" AND candidatos.grado_curso = cursosgrados.id';
$res = mysqli_query($conexion, $consultaCandidatos);
if ($res)
{
    $infoCandidatos = array();
    while ($candidatos= mysqli_fetch_assoc($res))
    {
        array_push($infoCandidatos, $candidatos);
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
        'data' => $infoEstudiante,
        'dataCandidato' => $infoCandidatos

    ], JSON_UNESCAPED_UNICODE);
}
