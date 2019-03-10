let app = new Vue({
    el : '#app',
    data:{
        votante:{
            tipoDocumento: '',
            documento: '',
            fechaNacimiento: '',
            nombre: '',
        },
        candidatosPersoneria:"",
        candidatosRepresentante: "",
        datar: ''

    },
    methods: {
        query(){
            let datos = new FormData();

            datos.append('documento', this.votante.documento);
            datos.append('fechaNacimiento', this.votante.fechaNacimiento);
            //Fetch data
            fetch('./fun/voting.php', {
                'method': 'POST',
                headers:{
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                'body': JSON.stringify({'documento':this.votante.documento,
                    'fechaNacimiento': this.votante.fechaNacimiento})
            }).then((response)=>{
                return response.json();

            }).then((data)=>{
                console.log(data);
                if (data.data === undefined)
                {
                    alert("Verifique sus credenciales, no registra dicha información en nuestra base de datos");
                }
                else {

                    document.getElementById('formularioVotacion').style.display = "";
                    document.getElementById('ingreso').style.display = "none";
                    let d = data.data;
                    let vot = d.dataVotante;
                    app.votante.nombre = vot.primerNombre + ' ' + vot.segundoNombre + ' ' + vot.primerApellido + ' ' + vot.segundoApellido ;
                    app.candidatosPersoneria = d.dataPersonero;
                    if (d.dataRepresentante.length === 0)
                    {
                        //No hay representantes para elegir
                        console.log("No existen representantes apra elegir")
                    }
                    else {
                        //Si hay representantes para elegir
                        console.log("Existen representantes");
                    }

                }
            }).catch((error)=>{
                console.log(error.message);
            })

        }
    },

});


