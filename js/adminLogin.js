document.getElementById("formulario").addEventListener('submit', (evt => {
    evt.preventDefault();
    let usuario = document.getElementById('usuario').value;
    let password = document.getElementById('password').value;

    fetch('./fun/adminVoting.php', {
        'method': 'POST',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        'body': JSON.stringify({'usuario': usuario,
            'password': password})
    }).then((response)=>{
        return response.json();

    }).then((data)=>{
        console.log(data);
        if (data.data === "vacio")
        {
            alert("Verifique sus credenciales, no registra dicha información en nuestra base de datos");
            var contexto = false;
        }
        else {

            alert("Bienvenido administrador");
            window.location = './add.html';

        }
    }).catch((error)=>{
        console.log(error.message);
    })
}));

