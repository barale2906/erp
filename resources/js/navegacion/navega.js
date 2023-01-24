const navegacion = new Vue ({
    el: '#navegacion',
    data(){


        return{
            navegar: [],

        }
    },
    mounted() {
        let url = 'navegacion';
        let vue = this;
        axios.get(url)
        .then(function(response){

            vue.navegar = response.data;
            //console.log(vue.navegar)

        })
    }

});
