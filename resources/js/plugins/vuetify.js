/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


import Vue from 'vue'
import Vuetify from 'vuetify'

Vue.use(Vuetify)
import 'vuetify/dist/vuetify.min.css'
import colors from 'vuetify/lib/util/colors'

export default new Vuetify({
  theme: {
    themes: {
      light: {
        primary: colors.red.darken3
      }
    }
  }
});