import 'alpinejs'
import axios from 'axios';
import i18next from 'i18next';

window.$ = window.jQuery = require('jquery');
window.Swal = require('sweetalert2');


/**
 * CoreUI at:
 * https://coreui.io/
 */
window.Coreui = require('@coreui/coreui');

/**
 * Plugins at:
 * /resources/js/plugins.js
 */
require('../plugins');

/**
 * Frontend translation using i18next
 */
const lang = document.documentElement.lang;
axios.get(`/api/lang/${lang}.json`).then(function (res) {
  if (res.status === 404) {
    return;
  }

  i18next.init({
    lng: "i18n",
    resources: {
      "i18n": {
        translation: res.data
      }
    },
    // debug: true // TODO: detect .env and toggle automatically
  })
})