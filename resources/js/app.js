/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import router from "./router";
import App from "../components/App";
import _ from "lodash";


import {
    Form,
    FormModel,
    message,
    notification,
    Input,
    Button,
    Layout,
    Menu,
    List,
	Table,
	PageHeader,
	Row,
	Pagination,
    Dropdown,
    Breadcrumb,
    Select,
    Modal,
    Icon,
} from "ant-design-vue";

Vue.use(Form);
Vue.use(FormModel);
Vue.use(Input);
Vue.use(Button);
Vue.use(Layout);
Vue.use(Menu);
Vue.use(List);
Vue.use(Table);
Vue.use(PageHeader);
Vue.use(Row);
Vue.use(Pagination);
Vue.use(Dropdown);
Vue.use(Breadcrumb);
Vue.use(Select);
Vue.use(Modal);
Vue.use(Icon);

Vue.prototype.$message = message;
Vue.prototype.$notification = notification;
Vue.prototype.$info = Modal.info;
Vue.prototype.$success = Modal.success;
Vue.prototype.$error = Modal.error;
Vue.prototype.$warning = Modal.warning;
Vue.prototype.$confirm = Modal.confirm;
Vue.prototype.$_ = _;

Vue.config.productionTip = false;


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('../components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


var app = new Vue({
    el: '#app',
    render: h => h(App),
    router,
  });
