<template>
  <base-layout>
    <template #navbarapp>
      <nav-bar-app></nav-bar-app>
    </template>
    <template #main>
      <router-view></router-view>
    </template>
  </base-layout>
</template>

<script>

import BaseLayout from "./BaseLayout";
import NavBarApp from "../components/NavBarApp";

export default {
  name: "HomePageLayout",
  components: {NavBarApp, BaseLayout}
}
</script>

