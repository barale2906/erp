const app = new Vue({

    el: '#internoform',
     created: function() {
		this.cargarbasicosi();
    },
    data:{
        solicitai: '',
        namei: '',
        empresai: '',
        sucursali: '',
        nombresucursali: '',
        areai: '',
        nombreareai: '',
        destinatarioi: '',
        nombredestinatarioi: '',
        sedei: '',
        nombresedei: '',
        ubicacioni: '',
        nombreubicacioni: '',
        horarioi: '',
        descripcioni:'',
        detallei: '',
        mensajei: '',
        clasei: '',
        clasesi: [],
        errors: '',

    },
    methods: {

        cargarbasicosi(){
            axios.get('remitente'). then((response) => {
                this.solicitai = response.data.user_id;
                this.namei = response.data.name;
                this.empresai = response.data.empresa_id;
                this.sucursali = response.data.sucursal_id;
                this.nombresucursali = response.data.sucursal;
                this.areai = response.data.area_id;
                this.nombreareai = response.data.area;
                this.descripcion = '';
                this.detalle = '';


            });

        },
        destinatario(){
            let destinatario        = sessionStorage.getItem('destinatario');
            let nombredestinatario  = sessionStorage.getItem('nombredestinatario');
            let sede                = sessionStorage.getItem('sede');
            let nombresede          = sessionStorage.getItem('nombresede');
            let ubicacion           = sessionStorage.getItem('ubicacion');
            let nombreubicacion     = sessionStorage.getItem('nombreubicacion');
            let horario             = sessionStorage.getItem('horario');

                this.destinatarioi          = destinatario;
                this.nombredestinatarioi    = nombredestinatario;
                this.sedei                  = sede;
                this.nombresedei            = nombresede;
                this.ubicacioni             = ubicacion;
                this.nombreubicacioni       = nombreubicacion;
                this.horarioi               = horario;



        },
        cargarclasei(){
            axios.get('clases'). then((response) => {
                this.clasesi = response.data;

            });
        },
        crearenvioi() {
            const params = {
                destinatario:       this.destinatarioi,
                nombredestinatario: this.nombredestinatarioi,
                sede:               this.sedei,
                nombresede:         this.nombresedei,
                ubicacion:          this.ubicacioni,
                nombreubicacion:    this.nombreubicacioni,
                horario:            this.horarioi,
                descripcion:        this.descripcioni,
                detalle:            this.detallei,
                clase:              this.clasei,

                solicita:           this.solicitai,
                name:               this.namei,
                empresa_id:         this.empresai,
                sucursal:           this.sucursali,
                nombresucursal:     this.nombresucursali,
                area:               this.areai,
                nombrearea:         this.nombreareai,
            };

            axios.post('corres', params)
            .then(response => {


                this.descripcioni = '';
                this.detallei = '';
                this.clasei = '';
                this.mensaje = response.data.nombre;


                $('#interno').modal('hide');

                alert(this.mensaje)
				//toastr.success('Nueva tarea creada con éxito');
			}).catch(error => {
                alert('No se genero el envío, Revise los datos por favor')

			});
        }
    }


});
