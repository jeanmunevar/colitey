

Vue.component('v-select', VueSelect.VueSelect);
let app = new Vue({
    el: '#swap',
    data:{
        candidato:{
            tipoDocumento: "",
            documento: "",
            nombre: "",
            cargo: "",
            grado: "",
            jornada: "",
        },
        nombresArchivos: [],
        image: "",
        picture: '',
        cargos: [
            {value: '1', label:'Representante de grado'},
            {value: '2', label: 'Personero'},
            {value: '3', label: 'Delegado profesorado'}
        ],
        tiposDocumento:[
            {value:'1', label:'Cedula de ciudadanía'},
            {value:'2', label: 'Tarjeta de identidad'},
            {value:'3', label: 'Registro civil'},
            {value:'4', label: 'Numero establecido por la secretaría.'}
        ],
        jornadas:[
            {value:'1', label:'Jornada mañana'},
            {value:'2', label:'Jornada tarde'}
        ],
        grados:[
            {value:'1' , label:'TRANSICIÓN A TARDE', grado: "0"},
            {value:'2' , label:'TRANSICIÓN B TARDE'},
            {value:'3' , label:'TRANSICIÓN C TARDE'},
            {value:'4' , label:'TRANSICIÓN D TARDE'},
            {value:'5' , label:'TRANSICIÓN E TARDE'},
            {value:'6' , label:'TRANSICIÓN F TARDE'},
            {value:'101' , label:'PRIMERO A'},
            {value:'102' , label:'PRIMERO B'},
            {value:'103' , label:'PRIMERO C'},
            {value:'104' , label:'PRIMERO D'},
            {value:'105' , label:'PRIMERO E'},
            {value:'106' , label:'PRIMERO F'},
            {value:'107' , label:'PRIMERO G'},
            {value:'108' , label:'PRIMERO H'},
            {value:'109' , label:'PRIMERO I'},
            {value:'111' , label:'TRANSICIÓN A MAÑANA'},
            {value:'112' , label:'TRANSICIÓN B MAÑANA'},
            {value:'113' , label:'TRANSICIÓN C MAÑANA'},
            {value:'114' , label:'TRANSICIÓN D MAÑANA'},
            {value:'115' , label:'TRANSICIÓN E MAÑANA'},
            {value:'116' , label:'TRANSICIÓN F MAÑANA'},
            {value:'201' , label:'SEGUNDO A'},
            {value:'202' , label:'SEGUNDO B'},
            {value:'203' , label:'SEGUNDO C'},
            {value:'204' , label:'SEGUNDO D'},
            {value:'205' , label:'SEGUNDO E'},
            {value:'206' , label:'SEGUNDO F'},
            {value:'207' , label:'SEGUNDO G'},
            {value:'208' , label:'SEGUNDO H'},
            {value:'209' , label:'SEGUNDO I'},
            {value:'301' , label:'TERCERO A'},
            {value:'302' , label:'TERCERO B'},
            {value:'303' , label:'TERCERO C'},
            {value:'304' , label:'TERCERO D'},
            {value:'305' , label:'TERCERO E'},
            {value:'306' , label:'TERCERO F'},
            {value:'307' , label:'TERCERO G'},
            {value:'308' , label:'TERCERO H'},
            {value:'401' , label:'CUARTO A'},
            {value:'402' , label:'CUARTO B'},
            {value:'403' , label:'CUARTO C'},
            {value:'404' , label:'CUARTO D'},
            {value:'405' , label:'CUARTO E'},
            {value:'406' , label:'CUARTO F'},
            {value:'407' , label:'CUARTO G'},
            {value:'408' , label:'CUARTO H'},
            {value:'501' , label:'QUINTO A'},
            {value:'502' , label:'QUINTO B'},
            {value:'503' , label:'QUINTO C'},
            {value:'504' , label:'QUINTO D'},
            {value:'505' , label:'QUINTO E'},
            {value:'506' , label:'QUINTO F'},
            {value:'507' , label:'QUINTO G'},
            {value:'508' , label:'QUINTO H'},
            {value:'601' , label:'SEXTO A'},
            {value:'602' , label:'SEXTO B'},
            {value:'603' , label:'SEXTO C'},
            {value:'604' , label:'SEXTO D'},
            {value:'605' , label:'SEXTO E'},
            {value:'606' , label:'SEXTO F'},
            {value:'607' , label:'SEXTO G'},
            {value:'608' , label:'SEXTO H'},
            {value:'609' , label:'SEXTO I'},
            {value:'701' , label:'SEPTIMO A'},
            {value:'702' , label:'SEPTIMO B'},
            {value:'703' , label:'SEPTIMO C'},
            {value:'704' , label:'SEPTIMO D'},
            {value:'705' , label:'SEPTIMO E'},
            {value:'706' , label:'SEPTIMO F'},
            {value:'707' , label:'SEPTIMO G'},
            {value:'708' , label:'SEPTIMO H'},
            {value:'709' , label:'SEPTIMO I'},
            {value:'801' , label:'OCTAVO A'},
            {value:'802' , label:'OCTAVO B'},
            {value:'803' , label:'OCTAVO C'},
            {value:'804' , label:'OCTAVO D'},
            {value:'805' , label:'OCTAVO E'},
            {value:'806' , label:'OCTAVO F'},
            {value:'807' , label:'OCTAVO G'},
            {value:'808' , label:'OCTAVO H'},
            {value:'901' , label:'NOVENO A'},
            {value:'902' , label:'NOVENO B'},
            {value:'903' , label:'NOVENO C'},
            {value:'904' , label:'NOVENO D'},
            {value:'905' , label:'NOVENO E'},
            {value:'906' , label:'NOVENO F'},
            {value:'907' , label:'NOVENO G'},
            {value:'908' , label:'NOVENO H'},
            {value:'1001' , label:'DÉCIMO A'},
            {value:'1002' , label:'DÉCIMO B'},
            {value:'1003' , label:'DÉCIMO C'},
            {value:'1004' , label:'DÉCIMO D'},
            {value:'1005' , label:'DÉCIMO E'},
            {value:'1006' , label:'DÉCIMO F'},
            {value:'1007' , label:'DÉCIMO G'},
            {value:'1008' , label:'DÉCIMO H'},
            {value:'1101' , label:'ONCE A'},
            {value:'1102' , label:'ONCE B'},
            {value:'1103' , label:'ONCE C'},
            {value:'1104' , label:'ONCE D'},
            {value:'1105' , label:'ONCE E'},
            {value:'1106' , label:'ONCE F'},
            {value:'1107' , label:'ONCE G'},
            {value:'1108' , label:'ONCE H'},

        ],
        candidate: [],
        candidatoEnEdicion: '',
        editando: false,
        holdthis: ""

    },
    methods: {
        onFileChange(e) {

            var files = e.target.files || e.dataTransfer.files;
            let nombre = e.target.files.name;
            if (!files.length)
                return;
            this.createImage(files[0]);
            app.nombresArchivos.push(nombre);

        },
        createImage(file) {
            // app.picture = app.$refs.imageCandidato.file;
            var image = new Image();
            var reader = new FileReader();
            var vm = this;

            reader.onload = (e) => {
                vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },

        add(){
            let datos = new FormData();
            if (this.candidato.cargo.value === 3)
            {
                datos.append('imagen', this.image);
                datos.append('tipoDocumento', this.candidato.tipoDocumento.value);
                datos.append('documento', this.candidato.documento);
                datos.append('cargo', this.candidato.cargo.value);
                datos.append('nombre', this.candidato.nombre);
                datos.append('grado', this.candidato.grado.value);
                datos.append('jornada', this.candidato.jornada.value);
            }
            else {
                datos.append('imagen', this.image);
                datos.append('tipoDocumento', this.candidato.tipoDocumento.value);
                datos.append('documento', this.candidato.documento);
                datos.append('cargo', this.candidato.cargo.value);
                datos.append('nombre', this.candidato.nombre);
                datos.append('grado', this.candidato.grado.value);
                datos.append('jornada', this.candidato.jornada.value);
            }



            fetch('./fun/candidate.php',{
                'method': 'POST',
                'body': datos
            }).then((response)=>{
                return response.json()
            }).then((data)=>{
                alert(data.mensaje);
                if (data.estado === 'ok'){
                    if(app.editando){
                        //
                        const index = app.candidate.indexOf(app.candidatoEnEdicion);
                        app.candidate.splice(index, 1, app.candidato)
                    }
                    else{
                        app.candidate.push(app.candidato);
                    }

                    location.reload(true);
                    app.editando = false;


                }
            }).catch((err) =>{
                alert(err);
            })
        },

        eliminar(candidato){
            if(confirm('Esta seguro?')){
                fetch('./fun/candidate.php?doc='+candidato.documento+'&tipo=2')
                    .then((response) => {
                        return response.json()
                    })
                    .then((data) => {
                        alert(data.mensaje);
                        app.candidate.splice(app.candidate.indexOf(candidato),1)
                    })
                    .catch((err) => {
                        alert(err)
                    })
            }
        },
        clean(){
            this.image = '';
            this.candidato.tipoDocumento = '';
            this.candidato.documento = '';
            this.candidato.cargo = '';
            this.candidato.nombre = '';
            this.candidato.grado = '';
            this.candidato.jornada = '';
        },
        editar(candidato){
            this.candidatoEnEdicion = candidato
            this.candidato = JSON.parse(JSON.stringify(candidato))
            this.editando = true
        }




    },
    mounted(){

        fetch('./fun/candidate.php?tipo=1', {
            'method': 'GET'
        }).then((response) => {
            return response.json()
        }).then((data) => {
            app.candidate = data.data
        })
    },
});