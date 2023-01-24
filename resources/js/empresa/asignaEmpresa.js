const app = new Vue({

    el: '#asignaempresa',
    data:{
        empresaSeleccionada: '',
        sucursalSeleccionada:'',
        areaSeleccionada:'',
        sucursales: [],
        areas: [],


    },
    methods: {

        cargarSucursales(){
            axios.get('../../listasucursal', {params: {empresa_id: this.empresaSeleccionada} }). then((response) => {
                this.sucursales = response.data;
            });
        },
        cargarAreas(){
            axios.get('../../listarea', {params: {empresa_id: this.empresaSeleccionada} }). then((response) => {
                this.areas = response.data;
            });
        }
    }
});
