<template>
  <component :is="layout"></component>
</template>
<script>

import 'bootstrap';
import '@fortawesome/fontawesome-free/js/all';
import AppLayout from "./layouts/AppLayout";
import BlankLayout from "./layouts/BlankLayout";
import Loading from "./components/Loading";
import {mapState} from "vuex"

export default {
  name: 'App',
  components: {
    AppLayout, BlankLayout, Loading
  },
  created() {
    this.$store.dispatch("currentUser");
  },
  watch : {
    is_logged : function(state){
      if(!state && this.$route.name !== 'login') this.$router.push({name:'login'});
    }
  },
  computed : mapState(['is_logged', 'user', 'layout'])
}
</script>
