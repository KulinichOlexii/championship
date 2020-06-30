require('./bootstrap');

window.Vue = require('vue');
Vue.component('championship', require('./components/Championship.vue').default);

const app = new Vue({
    el: '#app',
});
