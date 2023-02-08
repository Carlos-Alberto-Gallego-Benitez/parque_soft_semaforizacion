<template>
  <header id="header" class="fixed-top d-flex align-items-center">
  <div class="container d-flex align-items-center justify-content-between">

    <div class="logo">
      <img src="../assets/img/logoblanco.png" alt="">
      <h1><a href="index.html"><span></span></a></h1>
    </div>

    <nav id="navbar" class="navbar">
      <ul>
        <!-- <li><a class="nav-link scrollto " href="#hero">Inicio</a></li>
        <li><a class="nav-link scrollto" href="#about">Nosotros</a></li>
        <li><a class="nav-link scrollto" href="#features">Servicios</a></li>
        <li><a class="nav-link scrollto" href="#gallery">Equipo</a></li>
        <li><a class="nav-link scrollto" href="#team">Contacto</a></li> -->
        <li>
          <router-link class="nav-link scrollto" to="/login">Iniciar Sesion
          </router-link> 
        </li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->
  </div>
  </header>
</template>

<script>
import {useStore} from 'vuex';

export default {
  name: "NavBar",
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
