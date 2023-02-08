<template>
  <div class="app app-signup p-0">
  <div class="row g-0 app-auth-wrapper">
    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
      <div class="d-flex flex-column align-content-end">
        <div class="app-auth-body mx-auto">
          <div class="app-auth-branding mb-4"><a class="app-logo" href="/">
            <img class="logo-icon me-2" src="../assets/images/app-logo.svg" alt="logo"></a>
          </div>
          <h2 class="auth-heading text-center mb-4">Crear cuenta en Proyecto</h2>

          <div class="auth-form-container text-start mx-auto">
            <form class="auth-form auth-signup-form" novalidate @submit.prevent="signUp">
              <div class="email mb-3">
                <label class="sr-only" for="signup-email">Nombre</label>
                <input
                    id="signup-name"
                    name="signup-name"
                    type="text"
                    class="form-control signup-name"
                    placeholder="Nombre Completo"
                    required="required"
                    v-model="user.displayName"
                    :class="{
                      'is-invalid' :  v$.displayName.$error,
                      'is-valid' : !v$.displayName.$error && v$.displayName.$dirty
                    }"
                >
                <form-text-error v-for="(error, i) in v$.displayName.$errors" :key="i">{{error.$message}}</form-text-error>
              </div>
              <div class="email mb-3">
                <label class="sr-only" for="signup-email">Correo Electronico</label>
                <input
                    id="signup-email"
                    name="signup-email"
                    type="email"
                    class="form-control signup-email"
                    placeholder="Correo Electronico"
                    required="required"
                    v-model="user.email"
                    :class="{
                      'is-invalid' :  v$.email.$error,
                      'is-valid' : !v$.email.$error && v$.email.$dirty
                    }"
                >
                <form-text-error v-for="(error, i) in v$.email.$errors" :key="i">{{error.$message}}</form-text-error>
              </div>
              <div class="password mb-3">
                <label class="sr-only" for="signup-password">Contraseña</label>
                <input
                    id="signup-password"
                    name="signup-password"
                    type="password"
                    class="form-control signup-password"
                    placeholder="Contraseña"
                    required="required"
                    v-model="user.password"
                    :class="{
                      'is-invalid' :  v$.password.$error,
                      'is-valid' : !v$.password.$error && v$.password.$dirty
                    }"
                >
                <form-text-error v-for="(error, i) in v$.password.$errors" :key="i">{{error.$message}}</form-text-error>
              </div>
              <div class="password mb-3">
                <label class="sr-only" for="signup-password">Confirmar Contraseña</label>
                <input
                    id="signup-password-confirm"
                    name="signup-password-confirm"
                    type="password"
                    class="form-control signup-password"
                    placeholder="Confirmar Contraseña"
                    required="required"
                    v-model="user.repeatPassword"
                    :class="{
                      'is-invalid' :  v$.repeatPassword.$error,
                      'is-valid' : !v$.repeatPassword.$error && v$.repeatPassword.$dirty
                    }"
                >
                <form-text-error v-for="(error, i) in v$.repeatPassword.$errors" :key="i">{{error.$message}}</form-text-error>
              </div>
              <div class="extra mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="RememberPassword">
                  <label class="form-check-label" for="RememberPassword">
                    Acepto los <a href="#" class="app-link">Terminos y Condiciones</a> y la <a href="#" class="app-link">Politica de Privacidad</a>.
                  </label>
                </div>
              </div><!--//extra-->

              <div class="text-center">
                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Registrarse</button>
              </div>
            </form><!--//auth-form-->
            <div class="auth-option text-center pt-5">Ya estas registrado ? <router-link class="text-link" to="login">Iniciar Sesión</router-link></div>
          </div><!--//auth-form-container-->
        </div><!--//auth-body-->
        <footer class="app-auth-footer">
          <div class="container text-center py-3">
            <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
            <small class="copyright">
              Powered by
              <a class="app-link" href="https://geekcorp.co" target="_blank">
                Geek Corporapption S.A.S
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
          <div class="overlay-content p-3 p-lg-4 rounded">
            <h5 class="mb-3 overlay-title">Explore Portal Admin Template</h5>
            <div>Portal is a free Bootstrap 5 admin dashboard template. You can download and view the template license <a href="https://themes.3rdwavemedia.com/bootstrap-templates/admin-dashboard/portal-free-bootstrap-admin-dashboard-template-for-developers/">here</a>.</div>
          </div>
        </div>
      </div><!--//auth-background-overlay-->
    </div><!--//auth-background-col-->

  </div><!--//row-->


  </div>
</template>

<script>

import {ref, computed} from 'vue';
import {useVuelidate} from '@vuelidate/core';
import {required, email, sameAs, helpers} from '@vuelidate/validators';
import {createUser} from "../services/AuthService";
import FormTextError from "../components/shared/validation/forms/FormTextError";
import Swal from "sweetalert2";
import {useRouter} from 'vue-router';

export default {
  name: "Register.vue",
  components: {FormTextError},
  setup () {

    const user = ref({
      displayName : '',
      email : '',
      password : '',
      repeatPassword : ''
    });

    const pass = computed(() => user.value.password);

    const requiredValidator = helpers.withMessage('Este campo es requerido', required);

    const validationRules = {
      displayName : {required : requiredValidator},
      email : {
        required : requiredValidator,
        email : helpers.withMessage('El formato de correo electronico es invalido', email)},
      password : {required : requiredValidator},
      repeatPassword : {
        required : requiredValidator,
        sameAsPassword : helpers.withMessage('Las contraseñas no coinciden', sameAs(pass))
      }
    };

    const v$ = useVuelidate(validationRules, user);

    const signUp = async () => {
      try{
        if(! await v$.value.$validate()) return;

        Swal.fire({
          title : 'Creando usuario',
          text : 'Por favor espere',
          didOpen: () => {
            Swal.showLoading()
          },
          allowOutsideClick : false,
        });

        await createUser(user.value.email, user.value.password);

        await Swal.fire({
          icon : "success",
          title : 'Exito!',
          text : 'Usuario registrado con exito',
        });

        const router = useRouter();

        await router.push({
          path : '/'
        });

      }catch (e) {
        const errors = {
          'auth/too-many-requests' : 'Demasiados intentos incorrectos',
          'auth/weak-password' : 'La contrasena, debe tener al menos 8 caracteres',
          'auth/email-already-in-use' : 'El correo electronico ya se encuentra registrado',
          'auth/invalid-email' : 'Correo electronico invalido',
          'auth/operation-not-allowed' : 'Correo electronico y/o contrasena no habilitada'
        };

        await Swal.fire({
          icon : "error",
          title : 'Ups!',
          text : errors[e.error],
        });

        console.error(e);
      }
    }

    return {
      user,
      v$,
      signUp
    }
  }
}
</script>

<style scoped>

</style>
