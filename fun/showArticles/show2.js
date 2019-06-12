let app2 = new  Vue({
    el: '#app2',
    data: {

        news:[],
        image: "http://1.bp.blogspot.com/-8PfnHfgrH4I/TylX2v8pTMI/AAAAAAAAJJ4/TICBoSEI57o/s1600/search_by_image_image.png"
    },
    methods:{

    },
    mounted(){

        fetch('./fun/showArticles/show.php?categoria=2',{

        }).then((response) => {
            return response.json()
        }).then((data) => {
            data.data.forEach((e)=>{
                this.news.push(e);
            })
        }).catch((error)=>{
            console.log(error);
        })
    }
});