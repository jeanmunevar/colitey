<?php
/**
 * Created by PhpStorm.
 * User: Marteen Munevar
 * Date: 17/03/2019
 * Time: 11:46 AM
 */
require_once ('./conexion.php');
$conexion = connectDB();

//Consulta resultados votacion

$resultados = "SELECT candidatos.documento, candidatos.cargo, candidatos.grado_curso, candidatos.nombre, candidatos.tarjeton, COUNT(votos.idCandidato) AS 'totalVotos', candidatos.imagen, candidatos.jornada FROM candidatos INNER JOIN votos ON votos.idCandidato = candidatos.documento AND candidatos.cargo = votos.cargo GROUP BY votos.idCandidato ORDER BY candidatos.grado_curso DESC";
//Se genera la consulta
$result = mysqli_query($conexion, $resultados);
$infoResultados = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($infoResultados, $row);
    }
}
echo json_encode(
    [
        'data'=>[
            'mensaje' => "Ok",
            'resultados' => $infoResultados
        ]
    ]
    , JSON_UNESCAPED_UNICODE);