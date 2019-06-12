let app = new Vue({
    el: '#app',
    data: {
        articulo:{
            titulo:'',
            categoria:'',
            nota:'',
            cuerpo:'',
            imagen:'',
            video:'',
            usuario: ''
        },
        articulos:[]
    },
    methods:{
        crear(){
            // Continuar con el post de aqui https://gist.github.com/justsml/529d0b1ddc5249095ff4b890aad5e801#advanced-uploading-multiple-files
            let datos = new FormData();
            let imagen = document.querySelector("#imagen");
            let video = document.querySelector("#video");
            if (imagen.files.length > 0)
            {
                datos.append('titulo', this.articulo.titulo);
                datos.append('categoria', this.articulo.categoria);
                datos.append('nota', this.articulo.nota);
                datos.append('cuerpo', this.articulo.cuerpo);
                datos.append('imagen', imagen.files[0]);
                datos.append('video', video.files[0]);
                datos.append('usuario', this.articulo.usuario);
                datos.append('function', "1");//Crear publicación
                //Fetch data
                fetch('./../fun/uploadArticles/egresado.php', {
                    'method': 'POST',
                    'body': datos
                }).then((response)=>{
                    return response.json();
                    app.articulos.push(app.articulo);

                }).then((data)=> {

                })
            }
            else {
                alert("Seleccione un archivo");
            }




        }
    },
    mounted(){
        fetch('./../fun/uploadArticles/egresado.php?function=1', {
                    'method': "GET"
                }).then((response) => {
                    return response.json()
                }).then((data) => {
                   //La respuesta
                    app.articulos = data.data;
                })
    }
});