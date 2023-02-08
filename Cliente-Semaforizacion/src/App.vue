<template>
  <component :is="layout"></component>
</template>
<script>

import AppLayout from "./layouts/AppLayout";
import Loading from "./components/Loading";
import LandingPageLayout from "./layouts/LandingPageLayout";
import {mapState} from "vuex"

export default {
  name: 'App',
  components: {
    AppLayout,Loading, LandingPageLayout
  },
  created() {
    this.$store.dispatch("currentUser");
  },
  watch : {
    is_logged : function(state){
      const nonLoginRoutes = ['login', 'signup', 'base'];
      if(!state && !nonLoginRoutes.includes(this.$route.name)) this.$router.push({name:'base'});
    }
  },
  computed : mapState(['is_logged', 'user', 'layout'])
}
</script>
