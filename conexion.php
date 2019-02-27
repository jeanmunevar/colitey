<?php
function connectDB(){
    $conexion = mysqli_connect("181.225.70.117","sistemas",'$ConTrol.',"empresa");
    mysqli_set_charset($conexion, "utf8");
    if ($conexion){
        
    }

    else{
        echo " What have you done kiddo?";
    }
    return $conexion;
}

function disconnectDB($conexion){
    $close = mysqli_close($conexion);
    return $close;
}

