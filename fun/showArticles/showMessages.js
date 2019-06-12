let app = new  Vue({
    el: '#app',
    data: {
        messages:[],

    },
    methods:{

    },
    mounted(){

        //Para mostrar estudiantes destacados
        fetch('./fun/showArticles/show.php?categoria=4',{

        }).then((response) => {
            return response.json()
        }).then((data) => {
            data.data.forEach((e)=>{
                app.messages.push(e);
            })
        }).catch((error)=>{
            console.log(error);
        })
    }
});