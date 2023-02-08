<template>
  <div class="app">
    <header class="app-header fixed-top">
      <NavBar></NavBar>
      <SideBar></SideBar>
    </header>
    <div class="app-wrapper">
      <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
          <router-view></router-view>
        </div>
      </div>
      <Footer></Footer>
    </div>
  </div>
</template>

<script>
import NavBar from "../components/NavBar";
import SideBar from "../components/SideBar";
import Footer from "../components/Footer";
export default {
  name: "AppLayout",
  components: {Footer, SideBar, NavBar}
}
</script>

<style>
@import "./../assets/css/portal.css";

</style>
