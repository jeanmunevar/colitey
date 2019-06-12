let app = new  Vue({
    el: '#app',
    data: {
        docente:{
            iddocente:'',
            documento:'',
            nombre:'',
            fechaNacimiento: '',
            idrol:'',
            perfil:'',
            email:'',
            foto:''
        },
        docentes:[],
        docenteEnEdicion:'',
        editando:false
    },
    methods: {
        crear() {
            let datos = new FormData();
            let foto = document.querySelector("#foto");



            if(app.editando) {
                //Si está editando quiero que haga esto
                datos.append('iddocente', this.docente.iddocente);
                datos.append('documento', this.docente.documento);
                datos.append('nombre', this.docente.nombre);
                datos.append('fechaNacimiento', this.docente.fechaNacimiento);
                datos.append('idrol', this.docente.idrol);
                datos.append('perfil', this.docente.perfil);
                datos.append('email', this.docente.email);
                if (foto.files.length > 0) {
                    //Hay un archivo y quieren subirlo
                    datos.append('foto', foto.files[0]);

                //    Enviar archivo
                    fetch('./../fun/docentes/subir_listar.php', {
                        'method': 'POST',
                        'body': datos
                    }).then((response) => {
                        return response.json();
                    }).then((data) => {
                        alert(data.mensaje);
                        if (data.estado === "ok") {
                            if (app.editando) {
                                const index = app.docentes.indexOf(app.docenteEnEdicion);
                                app.docentes.splice(index, 1, app.docente)
                            } else {
                                app.docentes.push(app.docente);
                            }
                        }
                        app.limpiar();
                        app.editando = false;
                    }).catch((err) => {
                        alert(err);
                    })
                }
                else {
                    //No hay archivo.
                    fetch('./../fun/docentes/subir_listar.php', {
                        'method': 'POST',
                        'body': datos
                    }).then((response) => {
                        return response.json();
                    }).then((data) => {
                        alert(data.mensaje);
                        if (data.estado === "ok") {
                            if (app.editando) {
                                const index = app.docentes.indexOf(app.docenteEnEdicion);
                                app.docentes.splice(index, 1, app.docente)
                            } else {
                                app.docentes.push(app.docente);
                            }
                        }
                        app.limpiar();
                        app.editando = false;
                    }).catch((err) => {
                        alert(err);
                    })
                }

            }
            else {
                //Sino está editando que haga esto
                if (foto.files.length > 0) {
                    datos.append('iddocente', this.docente.iddocente);
                    datos.append('documento', this.docente.documento);
                    datos.append('nombre', this.docente.nombre);
                    datos.append('fechaNacimiento', this.docente.fechaNacimiento);
                    datos.append('idrol', this.docente.idrol);
                    datos.append('perfil', this.docente.perfil);
                    datos.append('email', this.docente.email);
                    datos.append('foto', foto.files[0]);

                    //Fetch data
                    fetch('./../fun/docentes/subir_listar.php', {
                        'method': 'POST',
                        'body': datos
                    }).then((response) => {
                        return response.json();
                    }).then((data) => {
                        alert(data.mensaje);
                        if (data.estado === "ok") {
                            if (app.editando) {
                                const index = app.docentes.indexOf(app.docenteEnEdicion);
                                app.docentes.splice(index, 1, app.docente)
                            } else {
                                app.docentes.push(app.docente);
                            }
                        }
                        app.limpiar();
                        app.editando = false;
                    }).catch((err) => {
                        alert(err);
                    })

                } else {
                    alert("Seleccione un archivo");
                }
            }



        },
        limpiar() {
            this.docente = {
                iddocente:'',
                documento:'',
                nombre:'',
                fechaNacimiento: '',
                idrol:'',
                perfil:'',
                email:'',
                foto:''
            };

            //Aqui limpio el input type file, después de enviar.
            const img = this.$refs.img;
            img.type = 'text';
            img.type = 'file';

        },
        editar(docente) {
            this.docenteEnEdicion = docente;
            this.docente = JSON.parse(JSON.stringify(docente));
            this.editando = true;
        },
        eliminar(docente) {
            if (confirm('Esta seguro?')) {
                fetch('./../fun/docentes/subir_listar.php?documento=' + docente.documento+ '&tipo=2')
                    .then((response) => {
                        return response.json()
                    })
                    .then((data) => {
                        alert(data.mensaje);
                        app.docentes.splice(this.docentes.indexOf(docente), 1)
                    })
                    .catch((err) => {
                        alert(err)
                    })
            }
        },
    },
    mounted(){
        fetch('./../fun/docentes/subir_listar.php?tipo=1', {
            'method': "GET"
        }).then((response) => {
            return response.json()
        }).then((data) => {
            //La respuesta
            app.docentes = data.data;
            console.log(app.docentes);
        })

    }
});