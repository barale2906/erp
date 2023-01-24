const app = new Vue({

    el: '#externoform',
    created: function() {
		this.cargarCiudad();
    },

    data:{

        solicita: '',
        name: '',
        empresa_id: '',
        sucursal: '',
        nombresucursal: '',
        area: '',
        nombrearea: '',
        nombredestinatario: '',
        nombresede: '',
        nombreubicacion: '',
        horario: '',
        descripcion:'',
        detalle: '',
        mensaje: '',
        clase: '',
        ciudads: [],
        clases: [],

    },
    methods: {

        cargarbasicos(){
            axios.get('remitente'). then((response) => {
                this.solicita = response.data.user_id;
                this.name = response.data.name;
                this.empresa_id = response.data.empresa_id;
                this.sucursal = response.data.sucursal_id;
                this.nombresucursal = response.data.sucursal;
                this.area = response.data.area_id;
                this.nombrearea = response.data.area;
            });
        },

        cargarCiudad(){
            axios.get('listaciudad'). then((response) => {
                this.ciudads = response.data;
            });
        },
        cargarclase(){
            axios.get('clases'). then((response) => {
                this.clases = response.data;
            });
        },


        crearenvio() {
            const params = {
                nombredestinatario: this.nombredestinatario,
                nombresede:         this.nombresede,
                nombreubicacion:    this.nombreubicacion,
                horario:            this.horario,
                descripcion:        this.descripcion,
                detalle:            this.detalle,
                clase:              this.clase,
                solicita:           this.solicita,
                name:               this.name,
                empresa_id:         this.empresa_id,
                sucursal:           this.sucursal,
                nombresucursal:     this.nombresucursal,
                area:               this.area,
                nombrearea:         this.nombrearea,
            };

            axios.post('corres', params)
            .then(response => {
				// this.getKeeps(); recargar los envíos
				this.nombredestinatario= '';
                this.nombresede = '';
                this.nombreubicacion = '';
                this.horario = '';
                this.descripcion = '';
                this.detalle = '';
                this.clase = '';
                this.mensaje = response.data.nombre;
                //this.misenvios.cargarenvios();
                $('#externo').modal('hide');

                alert(this.mensaje)
				//toastr.success('Nueva tarea creada con éxito');
			}).catch(error => {
                //this.errors = 'Corrija para poder crear con éxito'
                alert('No se genero el envío, Revise los datos por favor')
			});
        }
    }


});
