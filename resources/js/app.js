/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/*var Turbolinks = require("turbolinks")
Turbolinks.start();*/

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('app-component', require('./components/AppComponent.vue').default);
//Vue.component('ejemplo', require('./components/ExampleComponent.vue').default);
//Vue.component('envioshoy', require('./correspondencia/Envioshoy.vue').default);
//Vue.component('navegacion-component', require('./components/navegacion/Navegacion.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/* const app = new Vue({
    el: '#app',
}); */

if (document.getElementById('registro')) {
    require('./registro/registro');
}

if (document.getElementById('navegacion')) {
    require('./navegacion/navega');
}


if (document.getElementById('asignaempresa')) {
    require('./empresa/asignaEmpresa');
}

if (document.getElementById('externoform')) {
    require('./correspondencia/externo');
}

if (document.getElementById('frecuenteform')) {
    require('./correspondencia/frecuente');
}

if (document.getElementById('internoform')) {
    require('./correspondencia/interno');
}



