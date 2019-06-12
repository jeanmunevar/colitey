let app = new  Vue({
    el: '#app',
    data: {
        mensaje:{
            titulo:'',
            nombres:'',
            email:'',
            prefacio:''
        }
    },
    methods: {
        crear() {
            let datos = new FormData();

            datos.append('titulo', this.mensaje.titulo);
            datos.append('nombres', this.mensaje.nombres);
            datos.append('email', this.mensaje.email);
            datos.append('prefacio', this.mensaje.prefacio);


            fetch('./fun/contactenos/contactUs.php', {
                'method': 'POST',
                'body': datos
            }).then((response) => {
                return response.json();
            }).then((data) => {
                alert(data.mensaje);
                app.limpiar();

            }).catch((err) => {
                console.log(err);
            })


        },
        limpiar() {
            this.mensaje = {
                titulo:'',
                nombres:'',
                email:'',
                prefacio:''};

        }
    }
});