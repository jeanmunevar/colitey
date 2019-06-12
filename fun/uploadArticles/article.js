let app = new Vue({
    el: '#app',
    data: {
        prevImage:"",
        articulo: {
            idpublicacion: '',
            titulo:'',
            prefacio:'',
            nota:'',
            imagen:'',
            usuario_id:'',
            idcategoria:'',
            directorio:'',
            fechaCreacion:''
        },
        articulos: [],
        articuloEnEdicion:'',
        editando: false
    },
    methods: {
        verImagen: function(event){
            let input = event.target;
            if (input.files && input.files[0]){
                var reader = new FileReader();
                reader.onload = (e) =>{
                    this.prevImage = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        },
        fetchSend(data){
            fetch('./../fun/uploadArticles/article.php', {
                'method': 'POST',
                'body': data
            }).then((response) => {
                return response.json();
            }).then((data) => {
                alert(data.mensaje);
                if (data.estado === "ok") {
                    if (app.editando) {
                        const index = app.articulos.indexOf(app.articuloEnEdicion);
                        app.articulos.splice(index, 1, app.articulo)
                    } else {
                        app.articulos.push(app.articulo);
                    }
                }
                app.limpiar();
                app.editando = false;
            }).catch((err) => {
                console.log(err);
            })
        },
        crear() {
            // Continuar con el post de aqui https://gist.github.com/justsml/529d0b1ddc5249095ff4b890aad5e801#advanced-uploading-multiple-files
            let datos = new FormData();
            let imagen = document.querySelector("#imagen");
            datos.append('idpublicacion', this.articulo.idpublicacion);
            datos.append('titulo', this.articulo.titulo);
            datos.append('idcategoria', this.articulo.idcategoria);
            datos.append('prefacio', this.articulo.prefacio);
            datos.append('nota', this.articulo.nota);
            datos.append('usuario', this.articulo.usuario);
            if (this.articulo.idcategoria !== '4'){
                datos.append('imagen', imagen.files[0]);
                if (app.editando)
                {
                    app.fetchSend(datos);
                }else {
                    if (imagen.files.length  > 0) {
                        app.fetchSend(datos);
                    }else{
                        alert("Seleccione un archivo");
                    }
                }
            }else{
                app.fetchSend(datos);
            }
        },
        eliminar(articulo) {
            if (confirm('¿Está seguro?')) {

                fetch('./../fun/uploadArticles/article.php?tipo=2&id='+articulo.idpublicacion+"&cat="+articulo.idcategoria, {
                    'method': 'GET'
                }).then((response) => {
                    return response.json()
                }).then((data) => {
                    app.articulos.splice(this.articulos.indexOf(articulo),1)
                    //La respuesta
                }).catch((err) => {
                    console.log(err);
                });
            }

        },
        editar(articulo) {
            app.articuloEnEdicion = articulo;
            app.articulo = JSON.parse(JSON.stringify(articulo));
            this.editando = true;


        },
        limpiar() {
            this.articulo = {
                idpublicacion: '',
                titulo:'',
                prefacio:'',
                nota:'',
                imagen:'',
                usuario_id:'',
                idcategoria:'',
                directorio:'',
                fechaCreacion:''
            };
            this.prevImage = '';
            //Aqui limpio el input type file, después de enviar.
            const img = this.$refs.img;
            img.type = 'text';
            img.type = 'file';
        }
    },
    mounted() {

        fetch('./../fun/uploadArticles/article.php?tipo=1', {
            'method': "GET"
        }).then((response) => {
            return response.json()
        }).then((data) => {
            //La respuesta
            app.articulos = data.data;
            console.log(app.articulos);
        })


    }

});

//Javascript plano

