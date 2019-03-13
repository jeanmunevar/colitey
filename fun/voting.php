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




$consultaEstudiante = "SELECT estudiante.documento, estudiante.primerNombre, estudiante.segundoNombre, estudiante.primerApellido, estudiante.segundoApellido, estudiante.salon, cursosgrados.grado, cursosgrados.curso, estudiante.jornada FROM estudiante INNER JOIN cursosgrados ON cursosgrados.id = estudiante.salon WHERE documento = '$id' AND estudiante.fechaNacimiento = '$fechaBorn'";
//Se genera la consulta
$result = mysqli_query($conexion, $consultaEstudiante);
$infoEstudiante = array();

if ($result){
    while ($alumno = mysqli_fetch_assoc($result)){
        array_push($infoEstudiante, $alumno);
    }
    if (count($infoEstudiante)!== 0)
    {
        //Existe el estudiante
        $student = $infoEstudiante[0];
        $grado = $student['grado'];
        $jornada = $student['jornada'];
        $sqlCandidatosPersoneria = "SELECT candidatos.documento, candidatos.nombre, candidatos.cargo, candidatos.grado_curso, cursosgrados.grado,candidatos.imagen ,cursosgrados.curso, cursosgrados.idJornada, candidatos.tarjeton FROM candidatos INNER JOIN cursosgrados ON cursosgrados.id = candidatos.grado_curso AND cursosgrados.grado = '11' WHERE candidatos.cargo = '2' ORDER BY candidatos.tarjeton ASC";
        $sqlCandidatosRepresentante = "SELECT candidatos.documento, candidatos.nombre, candidatos.cargo, candidatos.grado_curso, candidatos.imagen,cursosgrados.grado, cursosgrados.curso, cursosgrados.idJornada, candidatos.tarjeton FROM candidatos INNER JOIN cursosgrados ON cursosgrados.id = candidatos.grado_curso AND cursosgrados.grado = '$grado' WHERE candidatos.cargo = '1' AND candidatos.jornada = '$jornada' ORDER BY candidatos.tarjeton ASC";
        $rezultat = mysqli_query($conexion, $sqlCandidatosPersoneria);
        $resultat = mysqli_query($conexion, $sqlCandidatosRepresentante);
        $infoCandidatosPersoneria = array();
        $infoCandidatosRepresentante = array();
        if ($rezultat)
        {
            while ($candidatoPersoneria = mysqli_fetch_assoc($rezultat))
            {
                array_push($infoCandidatosPersoneria, $candidatoPersoneria);
            }
        }
        if ($resultat)
        {
            while ($candidatoRepresentante = mysqli_fetch_assoc($resultat))
            {
                array_push($infoCandidatosRepresentante, $candidatoRepresentante);
            }
        }
        //Datos de personeros
        echo json_encode([
            "data"=>[
                'codigo' => '101',
                'mensaje' => 'ok',
                'dataVotante' => $student,
                'dataPersonero'=> $infoCandidatosPersoneria,
                'dataRepresentante' => $infoCandidatosRepresentante]
        ]);
    }
    else{
        $consultaDocente="SELECT * FROM docentes WHERE documento = $id AND docentes.fechaNacimiento = '$fechaBorn'";
        $dataResult = mysqli_query($conexion, $consultaDocente);
        $infoDocente = array();
        if ($dataResult)
        {
            while ($docente = mysqli_fetch_assoc($dataResult))
            {
                array_push($infoDocente, $docente);
            }
            if (count($infoDocente)!== 0)
            {
                //Existe el docente
                $sqlCandidatoDocente = "SELECT documento, nombre, cargo, jornada, imagen, tarjeton FROM candidatos WHERE cargo = '3' ORDER BY candidatos.tarjeton ASC" ;
                $ergebnis = mysqli_query($conexion, $sqlCandidatoDocente);
                $infoCandidatosDocente = array();
                if ($ergebnis)
                {
                    while ($candidatoDocente = mysqli_fetch_assoc($ergebnis))
                    {
                        array_push($infoCandidatosDocente, $candidatoDocente);
                    }
                }
                echo json_encode([
                    'data'=>[
                        'codigo' => '102',
                        'mensaje' => 'ok',
                        'dataVotante' => $infoDocente,
                        'dataCandidatos' => $infoCandidatosDocente
                    ]
                ]);
            }
            else
            {
                //No existe en la base de datos
                echo json_encode([
                 'codigo' => '103',
                'Mensaje' => "El numero digitado no existe en la base de datos",
                ], JSON_UNESCAPED_UNICODE);
            }
        }
    }
}