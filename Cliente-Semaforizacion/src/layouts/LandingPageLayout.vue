<template>
  <base-layout>
    <template #navbar>
      <nav-bar></nav-bar>
    </template>
    <template #main>
      <router-view></router-view>
    </template>
  </base-layout>
</template>

<script>

import BaseLayout from "./BaseLayout";
import NavBar from "../components/NavBar";

export default {
  name: "LandingPageLayout",
  components: {NavBar, BaseLayout}
}
</script>

