const app = new Vue({

    el: '#misenviostabla',

    created: function() {
		this.cargarenvios();
    },

    data:{

        mios: [],
    },

    methods: {

        cargarenvios: function(){
            axios.get('miashoy'). then((response) => {
                this.mios = response.data;
            });
        }

    }
});
