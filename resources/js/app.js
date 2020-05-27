require('./bootstrap');

window.Vue = require('vue');



Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('asesors', require('./components/AsesoresComponent.vue').default);



const app = new Vue({
    el: '#app',
});
