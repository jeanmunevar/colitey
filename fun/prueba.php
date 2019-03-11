<?php
/**
 * Created by PhpStorm.
 * User: Marteen Munevar
 * Date: 10/03/2019
 * Time: 6:07 PM
 */
require_once ('conexion.php');
$conexion = connectDB();
$id="1222115559";
$fechaBorn = "2013-07-21";

$consultaEstudiante = "SELECT * FROM estudiante INNER JOIN cursosgrados ON cursosgrados.id = estudiante.salon WHERE documento = '$id' AND estudiante.fechaNacimiento = '$fechaBorn'";
//Se genera la consulta
$result = mysqli_query($conexion, $consultaEstudiante);
$infoEstudiante = array();

if ($result) {
    while ($alumno = mysqli_fetch_assoc($result)) {
        array_push($infoEstudiante, $alumno);
    }
    if (count($infoEstudiante) !== 0) {
        //Existe el estudiante
        $student = $infoEstudiante[0];
        $grado = $student['grado'];
        $jornada = $student['jornada'];
        $sqlCandidatosPersoneria = "SELECT * FROM `candidatos` INNER JOIN cursosgrados ON cursosgrados.id = candidatos.grado_curso 
                                    WHERE candidatos.cargo = '2' AND jornada = $jornada AND cursosgrados.grado = '11'";
        $sqlCandidatosRepresentante = "SELECT * FROM candidatos INNER JOIN cursosgrados ON cursosgrados.id = candidatos.grado_curso AND cursosgrados.idJornada = '$jornada' 
                                      WHERE cargo = '1' AND cursosgrados.grado = '$grado'";
        $rezultat = mysqli_query($conexion, $sqlCandidatosPersoneria);
        $resultat = mysqli_query($conexion, $sqlCandidatosRepresentante);
        $infoCandidatosPersoneria = array();
        $infoCandidatosRepresentante = array();
        if ($rezultat) {
            while ($candidatoPersoneria = mysqli_fetch_assoc($rezultat)) {
                array_push($infoCandidatosPersoneria, $candidatoPersoneria);
            }
        }
        if ($resultat) {
            while ($candidatoRepresentante = mysqli_fetch_assoc($resultat)) {
                array_push($infoCandidatosRepresentante, $candidatoRepresentante);
            }
        }
        //Datos de personeros
        echo json_encode([
            "data" => [
                'codigo' => '101',
                "mensaje" => "ok",
                "dataVotante" => $student,
                "dataPersonero" => $infoCandidatosPersoneria,
                "dataRepresentante" => $infoCandidatosRepresentante]
        ]);
    }
}