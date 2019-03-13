<?php
/**
 * Created by PhpStorm.
 * User: Marteen Munevar
 * Date: 12/03/2019
 * Time: 10:30 PM
 */
require_once ('conexion.php');
$conexion = connectDB();
date_default_timezone_set('America/Bogota');


    $votante = $_GET['votante'];
    $candidato = $_GET['candidato'];
    $cargo = $_GET['cargo'];
    $fecha = date("Y-m-d,h:m:s");
    $consulta ="SELECT * FROM votos WHERE idEstudiante = '$votante' AND  cargo='$cargo'";
    $resultado= mysqli_query($conexion, $consulta);
    $total = mysqli_num_rows($resultado);
    if ($total===0)
    {
        //No existe el voto

        $sqlVoto = "INSERT INTO votos(idvotos, fecha, idEstudiante, idCandidato, cargo) VALUES (DEFAULT,'$fecha','$votante','$candidato','$cargo') ";
        if(mysqli_query($conexion, $sqlVoto)){
            echo json_encode([
                'estado' => 'ok',
                'mensaje' => 'Candidato creado'
            ]);
        }else{
            echo json_encode([
                'estado' => 'Error',
                'mensaje' => 'Error al crear '.mysqli_error($conexion)
            ]);
        }
    }
    else{
        //Existe el voto
        echo json_encode([
            'codigo' => '101',
            'Mensaje' => "Ya votó",
        ], JSON_UNESCAPED_UNICODE);

    }
