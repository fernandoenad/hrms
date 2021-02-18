import Vue from 'vue'

require('./bootstrap');
require('.//components/person');
require('.//components/employee');
require('.//components/confirmdataprivacy');
require('.//components/applicationtype');
require('.//components/employeeshowhidecolums');
require('.//components/application');
require('.//components/register-modal');
require('.//components/apply-modal');
require('.//components/upload-image');
require('../../node_modules/admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js');


window.Vue = require('vue').default;

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
});
