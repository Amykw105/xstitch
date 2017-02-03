
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

var Vue = require('vue');
Vue.use(require('vue-resource'));
/**

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

import projects from './components/projects/projects.vue';
import projectinfo from './components/projects/projectinfo.vue';
import followers from './components/profiles/followers.vue';
import userinfo from './components/profiles/userinfo.vue';

const app = new Vue({
    el: '#app',

    components: {
      projects,
      projectinfo,
      followers,
      userinfo
    }
});
