<?php
/**
 * Created by PhpStorm.
 * User: Marteen Munevar
 * Date: 25/02/2019
 * Time: 12:15 AM
 */
function connectDB(){
    $conexion = mysqli_connect("54.39.52.153","coliteye_munzen",'Marteen123%',"coliteye_votaciones");
    mysqli_set_charset($conexion, "utf8");
    if ($conexion){

    }

    else{
        echo "<script>console.log('Error')</script>";
    }
    return $conexion;
}
connectDB();
function disconnectDB($conexion){
    $close = mysqli_close($conexion);
    return $close;
}

