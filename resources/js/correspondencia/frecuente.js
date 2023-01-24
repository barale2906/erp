const app = new Vue({

    el: '#frecuenteform',
    created: function() {
		this.cargarCiudadf();
    },

    data:{

        sucursalf: '',
        areaf: '',
        destinatario: '',
        direccion: '',
        ciudadf: '',
        horariof: '',
        observaciones:'',
        mensajef: '',
        ciudades: [],

    },
    methods: {

        cargarbasicosf(){
            axios.get('remitente'). then((response) => {

                this.sucursalf = response.data.sucursal_id;
                this.areaf = response.data.area_id;
            });
        },

        cargarCiudadf(){
            axios.get('listaciudad'). then((response) => {
                this.ciudades = response.data;
            });
        },

        creardestinatario() {
            const params = {
                area:               this.areaf,
                sucursal:           this.sucursalf,
                destinatario:       this.destinatario,
                direccion:          this.direccion,
                ciudad:             this.ciudadf,
                horario:            this.horariof,
                observaciones:      this.observaciones,
            };

            axios.post('frecuente', params)
            .then(response => {
				// this.getKeeps(); recargar los envíos
				this.nombredestinatario= '';
                this.nombresede = '';
                this.nombreubicacion = '';
                this.horario = '';
                this.descripcion = '';
                this.detalle = '';
                this.clase = '';
                this.mensajef = response.data.nombre;
                //this.misenvios.cargarenvios();
                $('#frecuente').modal('hide');

                alert(this.mensajef)
				//toastr.success('Nueva tarea creada con éxito');
			}).catch(error => {
                //this.errors = 'Corrija para poder crear con éxito'
                alert('No se genero el destinatario, Revise los datos por favor')
			});
        }
    }


});
