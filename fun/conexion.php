<?php
/**
 * Created by PhpStorm.
 * User: Marteen Munevar
 * Date: 25/02/2019
 * Time: 12:15 AM
 */
function connectDB(){
    $conexion = mysqli_connect("51.79.19.180","coliteye_munzen",'Colitey123%',"coliteye_votaciones");
    mysqli_set_charset($conexion, "utf8");
    if (!$conexion){
        echo "<script>console.log('Error')</script>";
    }
    return $conexion;
}

function disconnectDB($conexion){
    $close = mysqli_close($conexion);
    return $close;
}

