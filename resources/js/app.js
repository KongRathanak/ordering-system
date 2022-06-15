/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./vue');
window.$ = require("jquery");

$(function() {
    $(window).scroll(function() {
        const btn = $('#back_to_top');
        if ($(window).scrollTop() > 300) {
            btn.removeClass('d-none');
        } else {
            btn.addClass('d-none');
        }
    });
});

Vue.mixin({
    data() {
        const app_url = $('meta[name="app-url"]').attr("content");
        return {
            app_url,
        };
    },
    methods: {
        getMakeRequest(url, params = {}) {
            return axios.get(url, { params });
        },
    },
    mounted() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    }
});
