document.getElementById("formulario").addEventListener('submit', (evt => {
    evt.preventDefault();
    let tipoDocumento = document.getElementById('tipoDocumento').value;
    let numeroDocumento = document.getElementById('numeroDocumento').value;
    let fechaNacimiento = document.getElementById('fechaNacimiento').value;
    var formu = new FormData(document.getElementById('formulario'));
    fetch('./fun/voting.php', {
        'method': 'POST',
        headers:{
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
        'body': JSON.stringify({'documento': numeroDocumento,
            'fechaNacimiento': fechaNacimiento})
    }).then((response)=>{
        return response.json();

    }).then((data)=>{
        console.log(data);
        if (data.data === "vacio")
        {
            alert("Verifique sus credenciales, no registra dicha información en nuestra base de datos");
        }
        else {

            document.getElementById('formularioVotacion').style.display = "";

        }
    }).catch((error)=>{
        console.log(error.message);
    })
}));

