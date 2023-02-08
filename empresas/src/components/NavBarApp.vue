<template>
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
         <img src="../assets/img/logoblanco.png" alt="">
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar">
        <ul v-if="is_logged">
          <!-- <li>
            <router-link  class="nav-link scrollto" to="/formularios">Formularios</router-link>
          </li> -->
           <li>
            <router-link  class="nav-link scrollto" to="/listado-formularios">Formularios</router-link>
          </li>
          <li>
            <router-link  class="nav-link scrollto" to="/perfil">Perfil</router-link>
          </li>
          <li class="dropdown"><a href="#"><span>{{user.name}}</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li  @click.prevent="logout()"><a >Salir</a></li>
              <router-link class="nav-link scrollto" to="/perfil">Perfil</router-link>
            </ul>
          </li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
</template>

<script>

import {mapState} from "vuex";
import {useStore} from 'vuex';

export default {
  name: "NavBarApp.vue",
  computed : mapState(['is_logged', 'user']),
  setup (){
    const store = useStore();
    const logout = async () => {
      try{
        await store.dispatch('logout')
      }catch (e) {
        console.error(e);
      }
    }

    return {
      logout
    }
  }
}
</script>

<style scoped>

</style>