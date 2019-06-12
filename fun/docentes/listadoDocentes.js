let app = new Vue({
    el: "#app",
    data:{
        docentes: []
    },
    methods:{

    },
    mounted() {
        fetch('./fun/docentes/subir_listar.php?tipo=1', {
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