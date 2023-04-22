<template>
  <section>
  <div id="app-sidepanel" class="app-sidepanel">
    <div id="sidepanel-drop" class="sidepanel-drop"></div>
    <div class="sidepanel-inner d-flex flex-column">
      <a id="sidepanel-close" class="sidepanel-close d-xl-none" href="#">&times;</a>
      <div class="app-branding">
        <a class="app-logo" href="/">
          <img alt="logo"  src="./../assets/images/logo.png" width="200">
          <span class="logo-text"></span>
        </a>
      </div><!--//app-branding-->

      <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
        <ul id="menu-accordion" class="app-menu list-unstyled accordion">
          <li class="nav-item">
            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
            <router-link class="nav-link active" to="/" >
                <span class="nav-icon">
                  <i class="fas fa-home"></i>
                </span>
              <span class="nav-link-text">Inicio</span>
            </router-link><!--//nav-link-->
          </li><!--//nav-item-->
          <li class="nav-item">
            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
            <router-link class="nav-link " :to="{ name: 'sector.empresa' }">
                <span class="nav-icon">
                  <i class="fas fa-building"></i>
                </span>
              <span class="nav-link-text">Sectores Empresas</span>
            </router-link><!--//nav-link-->
          </li><!--//nav-item-->
          <!-- <li class="nav-item">
            <router-link class="nav-link " to="/etapas">
                <span class="nav-icon">
                  <i class="fas fa-layer-group"></i>
                </span>
              <span class="nav-link-text">Etapas</span>
            </router-link>
          </li> --><!--//nav-item-->
         <!--  <li class="nav-item">
            <router-link class="nav-link " to="/configuracion-formularios">
                <span class="nav-icon">
                  <i class="fas fa-newspaper"></i>
                </span>
              <span class="nav-link-text">Formularios</span>
            </router-link>
          </li> --><!--//nav-item-->
          <li class="nav-item">
            <router-link class="nav-link " to="/config-formularios">
                <span class="nav-icon">
                  <i class="fas fa-newspaper"></i>
                </span>
              <span class="nav-link-text">Formularios</span>
            </router-link>
          </li>
          <li class="nav-item has-submenu">
            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
            <a aria-controls="submenu-1" aria-expanded="false" class="nav-link submenu-toggle" data-bs-target="#submenu-1"
               data-bs-toggle="collapse" href="#">
                  <span class="nav-icon">
                    <i class="far fa-file"></i>
                  </span>
              <span class="nav-link-text">Resultados</span>
              <span class="submenu-arrow">
                <i class="fas fa-chevron-down fa-fw"></i>
              </span><!--//submenu-arrow-->
            </a><!--//nav-link-->
            <div id="submenu-1" class="collapse submenu submenu-1" data-bs-parent="#menu-accordion">
              <ul class="submenu-list list-unstyled">
                <li class="submenu-item"><router-link class="submenu-link" to="/listado-empresas">Por Empresa</router-link></li>
                 <li class="submenu-item"><router-link class="submenu-link" to="/listado-formularios">General</router-link></li>
              </ul>
            </div>
          </li><!--//nav-item-->
          <li class="nav-item" v-if="user.tipo=1">
            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
            <router-link class="nav-link " to="/usuarios">
                <span class="nav-icon">
                  <i class="fas fa-user"></i>
                </span>
              <span class="nav-link-text">Usuarios</span>
            </router-link><!--//nav-link-->
          </li><!--//nav-item-->
        </ul><!--//app-menu-->
      </nav><!--//app-nav-->
      <div class="app-sidepanel-footer">
        <nav class="app-nav app-nav-footer">
          <ul class="app-menu footer-menu list-unstyled">
            <li class="nav-item">
              <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
              <a class="nav-link " >
                <span class="nav-icon">
                  <i class="fas fa-user fa-fw text-orange"></i>
                </span>
                <span class="nav-link-text text-success">{{user.name}}</span>
              </a><!--//nav-link-->
            </li><!--//nav-item-->
          </ul><!--//footer-menu-->
        </nav>
      </div><!--//app-sidepanel-footer-->

    </div><!--//sidepanel-inner-->
  </div><!--//app-sidepanel-->
</section>
</template>

<script>

import {mapState} from "vuex";
export default {
  computed : mapState(['is_logged', 'user']),
  name: "SideBar"
}
</script>

<style scoped>

</style>
