let app = new  Vue({
    el: '#app',
    data: {
        articulos:[],
        news:[],

    },
    methods:{

    },
    mounted(){

        //Para mostrar estudiantes destacados
        fetch('./fun/showArticles/show.php?categoria=1', {

        }).then((response) => {
            return response.json()
        }).then((data) => {
            //La respuesta
            data.data.forEach((e)=>{
                app.articulos.push(e)

            })
        });

        fetch('./fun/showArticles/show.php?categoria=2',{

        }).then((response) => {
            return response.json()
        }).then((data) => {
            data.data.forEach((e)=>{
                app.news.push(e);
            })
        }).catch((error)=>{
            console.log(error);
        })
    }
});