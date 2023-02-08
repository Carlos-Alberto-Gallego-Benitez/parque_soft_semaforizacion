<template>
  <div class="app app-login p-0">
  <div class="row g-0 app-auth-wrapper">
    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5 mt-5">
      <div class=" d-flex flex-column align-content-end">
        <div class="app-auth-body mx-auto">
          <div class="app-auth-branding mb-4"><a class="app-logo" href="/">
            <img width="250" src="../assets/images/logo.png" alt="logo"></a>
          </div>
          <!-- <h2 class="auth-heading text-center mb-5">Iniciar Sesión</h2>  -->
          <div class="auth-form-container text-start">
            <form class="auth-form login-form" @submit.prevent="login()" novalidate>
              <div class="email mb-3">
                <label class="sr-only" for="signin-email">Correo Electrónico</label>
                <input
                    id="signin-email"
                    name="signin-email"
                    type="email"
                    class="form-control signin-email"
                    placeholder="Correo Electrónico"
                    required="required"
                    v-model="form.email"
                    :class="{
                      'is-invalid' : v$.email.$error,
                      'is-valid' :  !v$.email.$error && v$.email.$dirty
                    }"
                >
                <form-text-error v-for="(error, i) in v$.email.$errors" :key="i">{{error.$message}}</form-text-error>
              </div><!--//form-group-->
              <div class="password mb-3">
                <label class="sr-only" for="signin-password">Contraseña</label>
                <input id="signin-password"
                       v-model="form.password"
                       name="signin-password"
                       type="password"
                       class="form-control signin-password"
                       placeholder="Contraseña"
                       required="required"
                       :class="{
                         'is-invalid' : v$.password.$error,
                         'is-valid' : !v$.password.$error && v$.password.$dirty
                       }"
                >
                <form-text-error v-for="(error, i) in v$.password.$errors" :key="i">{{error.$message}}</form-text-error>
                <div class="extra mt-3 row justify-content-between">
                  <!-- <div class="col-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="RememberPassword">
                      <label class="form-check-label" for="RememberPassword">
                        Recuerdame
                      </label>
                    </div>
                  </div> --><!--//col-6-->
                  <!-- <div class="col-6">
                    <div class="forgot-password text-end">
                      <a href="reset-password.html"> ¿ No recuerda la contraseña ?</a>
                    </div>
                  </div> --><!--//col-6-->
                </div><!--//extra-->
              </div><!--//form-group-->
              <div class="text-center">
                <button type="submit"  class="btn app-btn-primary w-100 theme-btn mx-auto">Iniciar Sesión</button>
              </div>
            </form>

            <!-- <div class="auth-option text-center pt-5"> ¿ No tienes una cuenta ? Registrate <router-link class="text-link" to="signup">aquí</router-link>.</div> -->
          </div><!--//auth-form-container-->

        </div><!--//auth-body-->

        <footer class="app-auth-footer">
          <div class="container text-center py-3">
            <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
            <small class="copyright">
              Powered by
              <a class="app-link" href="#" target="_blank">
                Parquesoft | Sucre
              </a>
              <i class="fas fa-rocket"></i>
            </small>

          </div>
        </footer><!--//app-auth-footer-->
      </div><!--//flex-column-->
    </div><!--//auth-main-col-->
    <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
      <div class="auth-background-holder">
      </div>
      <div class="auth-background-mask"></div>
      <div class="auth-background-overlay p-3 p-lg-5">
        <div class="d-flex flex-column align-content-end h-100">
          <div class="h-100"></div>
        <!--   <div class="overlay-content p-3 p-lg-4 rounded">
            <h5 class="mb-3 overlay-title">Bienvenido...!</h5>
            <div>Plataforma administrativa para la semaforización de Empresas</div>
          </div> -->
        </div>
      </div><!--//auth-background-overlay-->
    </div><!--//auth-background-col-->

  </div><!--//row-->


  </div>
</template>

<script>
import Swal from 'sweetalert2';
import useVuelidate from '@vuelidate/core';
import {required, email, helpers} from '@vuelidate/validators';
import {ref} from 'vue';
import FormTextError from "../components/shared/validation/forms/FormTextError";
import {useStore} from "vuex";
import {useRouter} from "vue-router";

export default {
  name: "Login",
  components: {FormTextError},
  setup () {

    const form  = ref({
      email : '',
      password : ''
    });

    const rules = {
      email : {
        required : helpers.withMessage('Este campo es requerido', required),
        email : helpers.withMessage('El formato de email es incorrecto', email)
      },
      password : {
        required : helpers.withMessage('Este campo es requerido', required)
      }
    };

    const v = useVuelidate(rules, form);
    const store = useStore();
    const router = useRouter();

    const login = async () => {
      try{

        if(! await v.value.$validate()) return;

        Swal.fire({
          title : 'Estamos validando sus credenciales',
          text : 'Por favor espere...',
          didOpen: () => {
            Swal.showLoading()
          },
          allowOutsideClick : false,
        });

        await store.dispatch("login", form.value);

        Swal.fire({
          icon : "success",
          title : 'Exito!',
          text : 'Inicio de sesion correcto',
        });

        await router.push({ path : '/' });

      }catch (e) {
        console.error(e);
        switch (e.status){
          case 401 :
            Swal.fire("Ups!", "Usuario o contraseña incorrectos", 'error');
            break;
          case 500 :
            Swal.fire('Ups!', "Ocurrio un error en el servidor", 'error');
        }
      }
    }

    return {
      form,
      login,
      v$ : v
    }
  },
}
</script>

<style scoped>

</style>
