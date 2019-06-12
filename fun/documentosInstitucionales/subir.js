let app = new  Vue({
    el: '#app',
    data: {
        documento:{
            nombre:'',
            descripcion:'',
            id:''
        },
        documentos:[],
        documentoEnEdicion:'',
        editando:false
    },
    methods: {
        crear() {
            let datos = new FormData();
            let documento = document.querySelector("#documento");

            if (app.editando){
                datos.append('nombre', this.documento.nombre);
                datos.append('descripcion', this.documento.descripcion);

                datos.append('id', this.documento.id);
                if (documento.files.length > 0) {
                    //Hay un archivo y quieren subirlo
                    //Fetch data
                    datos.append('documento', documento.files[0]);
                    fetch('./../fun/documentosInstitucionales/subir.php', {
                        'method': 'POST',
                        'body': datos
                    }).then((response) => {
                        return response.json();
                    }).then((data) => {
                        alert(data.mensaje);
                        if (data.estado === "ok") {
                            if (app.editando) {
                                const index = app.documentos.indexOf(app.documentoEnEdicion);
                                app.documentos.splice(index, 1, app.documento)
                            } else {
                                app.documentos.push(app.documento);
                            }
                        }
                        app.limpiar();
                        app.editando = false;
                    }).catch((err) => {
                        alert(err);
                    })

                } else {
                    //No hay archivo
                    datos.append('documento', documento.files[0]);
                    fetch('./../fun/documentosInstitucionales/subir.php', {
                        'method': 'POST',
                        'body': datos
                    }).then((response) => {
                        return response.json();
                    }).then((data) => {
                        alert(data.mensaje);
                        if (data.estado === "ok") {
                            if (app.editando) {
                                const index = app.documentos.indexOf(app.documentoEnEdicion);
                                app.documentos.splice(index, 1, app.documento)
                            } else {
                                app.documentos.push(app.documento);
                            }
                        }
                        app.limpiar();
                        app.editando = false;
                    }).catch((err) => {
                        alert(err);
                    })

                }
            }
            else{
                //
                if (documento.files.length >0) {
                    datos.append('nombre', this.documento.nombre);
                    datos.append('descripcion', this.documento.descripcion);
                    datos.append('id', this.documento.id);
                    datos.append('documento', documento.files[0]);
                    fetch('./../fun/documentosInstitucionales/subir.php', {
                        'method': 'POST',
                        'body': datos
                    }).then((response) => {
                        return response.json();
                    }).then((data) => {
                        alert(data.mensaje);
                        if (data.estado === "ok") {
                            if (app.editando) {
                                const index = app.documentos.indexOf(app.documentoEnEdicion);
                                app.documentos.splice(index, 1, app.documento)
                            } else {
                                app.documentos.push(app.documento);
                            }
                        }
                        app.limpiar();
                        app.editando = false;
                    }).catch((err) => {
                        alert(err);
                    })
                }
                else {
                    alert("Adjunte archivo")
                }

            }




        },
        limpiar() {
            this.documento = {
                nombre: '',
                descripcion: ''
            };

            //Aqui limpio el input type file, después de enviar.
            const doc = this.$refs.doc;
            doc.type = 'text';
            doc.type = 'file';

        },
        editar(documento) {
            this.documentoEnEdicion = documento;
            this.documento = JSON.parse(JSON.stringify(documento));
            this.editando = true;
        },
        eliminar(documento) {
            if (confirm('Esta seguro?')) {
                fetch('./../fun/documentosInstitucionales/subir.php?id=' + documento.id + '&tipo=2')
                    .then((response) => {
                        return response.json()
                    })
                    .then((data) => {
                        alert(data.mensaje);
                        app.documentos.splice(this.documentos.indexOf(documento), 1)
                    })
                    .catch((err) => {
                        alert(err)
                    })
            }
        },
    },
    mounted(){
        fetch('./../fun/documentosInstitucionales/subir.php?tipo=1', {
            'method': "GET"
        }).then((response) => {
            return response.json()
        }).then((data) => {
            //La respuesta
            app.documentos = data.data;
            console.log(app.documentos);
        })

    }
});