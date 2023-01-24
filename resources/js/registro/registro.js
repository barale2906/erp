

const registro = new Vue({
    el: '#registro',
    data: {
        nit: '',
        username: '',
        email: '',
        div_mensajeregistro:'NIT Correcto',
        div_mensajeusername:'Usuario Disponible',
        div_mensajemail:'Email Disponible',
        div_clase_registro: 'badge badge-danger',
        div_clase_username: 'badge badge-danger',
        div_clase_email: 'badge badge-danger',
        div_aparecer: false,
        div_apauser: false,
        div_apaemail: false,
        deshabilitar_username:1,
        deshabilitar_name:1,
        deshabilitar_email:1,
        deshabilitar_password:1,
        deshabilitar_password_confirmation:1,
        deshabilitar_boton:1

    },
    computed: {
        generarnit : function(){


            this.nit =  this.nit,
            this.username = this.username,
            this.email = this.email

           //return this.nit;

        }
    },
    methods: {
        getRegistro() {

            if (this.nit) {
                let url = '/api/registro/'+this.nit;
                axios.get(url).then(response => {
                this.div_mensajeregistro = response.data;
                    if (this.div_mensajeregistro==="NIT Correcto") {
                        this.div_clase_registro = 'badge badge-success';
                        this.deshabilitar_username=0;

                    } else {
                        this.div_clase_registro = 'badge badge-danger';
                        this.deshabilitar_username=1;
                        this.deshabilitar_email=1;
                        this.deshabilitar_boton=1;
                    }
                    this.div_aparecer = true;

                })

            }else{
                this.div_clase_slug = 'badge badge-danger';
                this.div_mensajeregistro="Debes escribir un NIT";
                this.deshabilitar_boton=1;
                this.div_aparecer = true;


            }




        },

        getUsername() {

            if (this.nit) {
                let url = '/api/username/'+this.username;
                axios.get(url).then(response => {
                this.div_mensajeusername = response.data;
                    if (this.div_mensajeusername==="Documento No Registrado") {
                        this.div_clase_username = 'badge badge-success';
                        //this.deshabilitar_username=1;
                        this.deshabilitar_name=0;
                        this.deshabilitar_email=0;

                    } else {
                        this.div_clase_username = 'badge badge-danger';
                        this.deshabilitar_email=1;
                    }
                    this.div_apauser = true;

                })

            }else{
                this.div_clase_slug = 'badge badge-danger';
                this.div_mensajeusername="Debes registrar tu documento";
                this.deshabilitar_email=1;
                this.div_apauser = true;


            }




        },

        getEmail() {

            if (this.nit) {
                let url = '/api/email/'+this.email;
                axios.get(url).then(response => {
                this.div_mensajemail = response.data;
                    if (this.div_mensajemail==="Email No Registrado") {
                        this.div_clase_email = 'badge badge-success';
                        //this.deshabilitar_email=1;
                        this.deshabilitar_password=0;
                        this.deshabilitar_password_confirmation=0;
                        this.deshabilitar_boton=0;

                    } else {
                        this.div_clase_email = 'badge badge-danger';
                        this.deshabilitar_boton=1;
                    }
                    this.div_apaemail = true;

                })

            }else{
                this.div_clase_slug = 'badge badge-danger';
                this.div_mensajemail="Debes registrar tu email";
                this.deshabilitar_boton=1;
                this.div_apaemail = true;


            }




        }

    },


});
