require('./bootstrap');
window.Vue = require('vue');

Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('paginator', require('./components/Paginator').default);
Vue.component('thread-view', require('./pages/Thread').default);

const app = new Vue({
    el: '#app',
});
