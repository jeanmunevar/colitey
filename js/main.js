let app = new Vue({
    el : '#app',
    data:{
        votante:{
            tipoDocumento: '',
            documento: '',
            fechaNacimiento: '',
            nombre: '',
            grado: '',
            jornada: ''
        },
        candidatosPersoneria:"",
        candidatosRepresentante: "",
        candidatosDocente: '',
        datar: '',
        codigo:'',
        votoPersonero:'',
        votoRepresentante:'',
        votoDocente:''

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
                console.log(data.data);
                var d = data.data;

                switch (d.codigo) {
                    case '101':
                        app.codigo = d.codigo;
                        // document.getElementById('formularioVotacion').style.display = "";
                        // document.getElementById('formRepre').style.display ="";
                        document.getElementById('ingreso').style.display = "none";
                        switch (d.dataVotante.grado) {
                            case '0':
                                d.dataVotante.grado = "Transición";
                                break;
                            case '1':
                                d.dataVotante.grado = "Primero";
                                break;
                            case '2':
                                d.dataVotante.grado = "Segundo";
                                break;
                            case '3':
                                d.dataVotante.grado = "Tercero";
                                break;
                            case '4':
                                d.dataVotante.grado = "Cuarto";
                                break;
                            case '5':
                                d.dataVotante.grado = "Quinto";
                                break;
                            case '6':
                                d.dataVotante.grado = "Sexto";
                                break;
                            case '7':
                                d.dataVotante.grado = "Septimo";
                                break;
                            case '8':
                                d.dataVotante.grado = "Octavo";
                                break;
                            case '9':
                                d.dataVotante.grado = "Noveno";
                                break;
                            case '10':
                                d.dataVotante.grado = "Decimo";
                                break;
                            case '11':
                                d.dataVotante.grado = "Once";
                                break;
                            default:
                                d.dataVotante.grado = "No aplica";
                                break;

                        }
                        d.dataRepresentante.forEach((e)=>{
                            //Switch curso de representante
                            switch (e.curso) {
                                case '1':
                                    e.curso = "A";
                                    break;
                                case '2':
                                    e.curso = "B";
                                    break;
                                case '3':
                                    e.curso = "C";
                                    break;
                                case '4':
                                    e.curso = "D";
                                    break;
                                case '5':
                                    e.curso = "E";
                                    break;
                                case '6':
                                    e.curso = "F";
                                    break;
                                case '7':
                                    e.curso = "G";
                                    break;
                                case '8':
                                    e.curso = "H";
                                    break;
                                case '9':
                                    e.curso = "I";
                                    break;
                                default:
                                    e.curso = "";
                                    break
                            }
                            //Switch grado representante
                            switch (e.grado) {
                                case '0':
                                    e.grado = "Transición";
                                    break;
                                case '1':
                                    e.grado = "Primero";
                                    break;
                                case '2':
                                    e.grado = "Segundo";
                                    break;
                                case '3':
                                    e.grado = "Tercero";
                                    break;
                                case '4':
                                    e.grado = "Cuarto";
                                    break;
                                case '5':
                                    e.grado = "Quinto";
                                    break;
                                case '6':
                                    e.grado = "Sexto";
                                    break;
                                case '7':
                                   e.grado = "Septimo";
                                    break;
                                case '8':
                                    e.grado = "Octavo";
                                    break;
                                case '9':
                                    e.grado = "Noveno";
                                    break;
                                case '10':
                                    e.grado = "Decimo";
                                    break;
                                case '11':
                                    e.grado = "Once";
                                    break;
                                default:
                                    e.grado = "Transición";
                                    break;

                            }
                        });
                        let vot = d.dataVotante;
                        app.votante.nombre = vot.primerNombre + ' ' + vot.segundoNombre + ' ' + vot.primerApellido + ' ' + vot.segundoApellido ;
                        d.dataPersonero.forEach((elemento)=>{

                            switch (elemento.grado) {
                                case '0':
                                    elemento.grado = "Transición";
                                    break;
                                case '1':
                                    elemento.grado = "Primero";
                                    break;
                                case '2':
                                    elemento.grado = "Segundo";
                                    break;
                                case '3':
                                    elemento.grado = "Tercero";
                                    break;
                                case '4':
                                    elemento.grado = "Cuarto";
                                    break;
                                case '5':
                                    elemento.grado = "Quinto";
                                    break;
                                case '6':
                                    elemento.grado = "Sexto";
                                    break;
                                case '7':
                                    elemento.grado = "Septimo";
                                    break;
                                case '8':
                                    elemento.grado = "Octavo";
                                    break;
                                case '9':
                                    elemento.grado = "Noveno";
                                    break;
                                case '10':
                                    elemento.grado = "Decimo";
                                    break;
                                case '11':
                                    elemento.grado = "Once";
                                    break;
                                default:
                                    elemento.grado = "Transición";
                                    break;

                            }
                            //Switch curso personero
                            switch (elemento.curso) {
                                case '1':
                                    elemento.curso = "A";
                                    break;
                                case '2':
                                    elemento.curso = "B";
                                    break;
                                case '3':
                                    elemento.curso = "C";
                                    break;
                                case '4':
                                    elemento.curso = "D";
                                    break;
                                case '5':
                                    elemento.curso = "E";
                                    break;
                                case '6':
                                    elemento.curso = "F";
                                    break;
                                case '7':
                                    elemento.curso = "G";
                                    break;
                                case '8':
                                    elemento.curso = "H";
                                    break;
                                case '9':
                                    elemento.curso = "I";
                                    break;
                                default:
                                    elemento.curso = "";
                                    break
                            }
                        });
                        app.votante.grado = d.dataVotante.grado;
                        app.candidatosPersoneria = d.dataPersonero;
                        if (d.dataRepresentante.length === 0)
                        {
                            //No hay representantes para elegir
                            console.log("No existen representantes para elegir");
                            app.candidatosRepresentante = "";
                        }
                        else {
                            //Si hay representantes para elegir
                            console.log("Existen representantes");
                            app.candidatosRepresentante = d.dataRepresentante;
                        }
                        break;
                    case '102':

                        app.codigo = d.codigo;
                        // document.getElementById('formuProfes').style.display = "";
                        document.getElementById('ingreso').style.display = "none";
                        d.dataVotante.forEach((el)=>{
                            console.log(el);
                            app.votante = el;
                        });
                        app.candidatosDocente = d.dataCandidatos;



                        break;
                    case '103':
                        alert("Verifique sus credenciales");
                        break;
                    default:
                        alert("Verifique sus credenciales");
                        break;

                }
                

            }).catch((error)=>{
                console.log(error.message);
            })

        },
        votaPersonero(){


            let candidato = this.votoPersonero;
            let votante = this.votante.documento;

            if(confirm('Esta seguro?')){
                fetch('./fun/createVote.php?candidato='+candidato+'&votante='+votante+'&cargo=2')
                    .then((response) => {
                        return response.json()
                    })
                    .then((data) => {
                        alert(data.mensaje);

                    })
                    .catch((err) => {
                        alert(err)
                    })
            }

        },
        votaRepresentante(){
            var fecha = new Date();
            var fechaVoto = fecha.getDate()+"/"+(fecha.getMonth()+1)+"/"+fecha.getFullYear();
            let horaVoto = fecha.getHours()+":"+fecha.getMinutes();
            let candidato = this.votoRepresentante;
            let votante = this.votante.documento;

            if(confirm('Esta seguro?')){
                fetch('./fun/createVote.php?candidato='+candidato+'&votante='+votante+'&fecha='+fechaVoto+'&hora='+horaVoto+'&cargo=1')
                    .then((response) => {
                        return response.json()
                    })
                    .then((data) => {
                        alert(data.mensaje);

                    })
                    .catch((err) => {
                        alert(err)
                    })
            }
        },
        votaDocente(){
            var fecha = new Date();
            var fechaVoto = fecha.getDate()+"/"+(fecha.getMonth()+1)+"/"+fecha.getFullYear();
            let horaVoto = fecha.getHours()+":"+fecha.getMinutes();
            let candidato = this.votoDocente;
            let votante = this.votante.documento;

            if(confirm('Esta seguro?')) {
                fetch('./fun/createVote.php?candidato=' + candidato + '&votante=' + votante + '&fecha=' + fechaVoto + '&hora=' + horaVoto + '&cargo=3')
                    .then((response) => {
                        return response.json()
                    })
                    .then((data) => {
                        alert(data.mensaje);

                    })
                    .catch((err) => {
                        alert("Hubo un error."+" "+err);
                    })
            }
        }
    },

});


