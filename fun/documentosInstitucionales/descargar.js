"use strict";

let app = new Vue({
    el: '#app',
    data: {


        documentos:[],
        documentoParaDescargar:[],
        indice:'',
        documento:{

        }

    },
    methods:{
        select(doc) {
            this.documentoParaDescargar = JSON.parse(JSON.stringify(doc));
            this.descarga(app.documentoParaDescargar.filename, app.documentoParaDescargar.directorio);
        },
        descarga(nombre, directorio ){
            fetch('./fun/documentosInstitucionales/subir.php?tipo=3&nombre='+nombre+'&directorio='+directorio, {
                'method': "GET"
            }).then((response) => {
                return response.json()
            }).then((data) => {
                //La respuesta
                app.documentos = data.data;
            });
        }

    },
    mounted(){
        fetch('./fun/documentosInstitucionales/subir.php?tipo=1', {
            'method': "GET"
        }).then((response) => {
            return response.json()
        }).then((data) => {
            //La respuesta
            app.documentos = data.data;
        });
    }
});