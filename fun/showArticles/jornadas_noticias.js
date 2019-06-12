let app = new  Vue({
    el: '#app',
    data: {
        noticiasPreescolar:[],
        noticiasPrimaria:[],
        noticiasSecundaria:[],
        noticiasEspecialidad:[],
        noticiasComplementaria:[],
        opcion:'0',
        noticias:[]


    },
    methods:{
        display(numero){
            app.opcion = numero;

        }
    },
    mounted(){

        //Fetch estudiantes preescolar
        fetch('./../fun/showArticles/show.php?categoria=5', {

        }).then((response) => {
            return response.json()
        }).then((data) => {
            //La respuesta
            data.data.forEach((e)=>{
                app.noticiasPreescolar.push(e);
                app.noticias.push(e);
            })
        });
        //Fetch estudiantes primaria
        fetch('./../fun/showArticles/show.php?categoria=6', {

        }).then((response) => {
            return response.json()
        }).then((data) => {
            //La respuesta
            data.data.forEach((e)=>{
                app.noticiasPrimaria.push(e);
                app.noticias.push(e);
            })
        });
        //Fetch estudiantes secundaria
        fetch('./../fun/showArticles/show.php?categoria=7', {

        }).then((response) => {
            return response.json()
        }).then((data) => {
            //La respuesta
            data.data.forEach((e)=>{
                app.noticiasSecundaria.push(e);
                app.noticias.push(e);
            })
        });
        //Fetch estudiantes Especialidad
        fetch('./../fun/showArticles/show.php?categoria=8', {

        }).then((response) => {
            return response.json()
        }).then((data) => {
            //La respuesta
            data.data.forEach((e)=>{
                app.noticiasEspecialidad.push(e);
                app.noticias.push(e);
            })
        });

        //Fetch estudiantes Complementaria
        fetch('./../fun/showArticles/show.php?categoria=9', {

        }).then((response) => {
            return response.json()
        }).then((data) => {
            //La respuesta
            data.data.forEach((e)=>{
                app.noticiasComplementaria.push(e);
                app.noticias.push(e);
            })
        });

    }
});