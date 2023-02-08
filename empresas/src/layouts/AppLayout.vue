<template>
  <base-layout>
    <template #navbar>
      <nav-bar-app></nav-bar-app>
    </template>
    <template #main>
      <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="inner-page">
          <div class="container">
            <router-view></router-view>
          </div>
        </section>
      </main><!-- End #main -->
    </template>
  </base-layout>
</template>

<script>

import BaseLayout from "./BaseLayout";
import NavBarApp from "../components/NavBarApp";

export default {
  name: "AppLayout",
  components: {NavBarApp, BaseLayout}
}
</script>

