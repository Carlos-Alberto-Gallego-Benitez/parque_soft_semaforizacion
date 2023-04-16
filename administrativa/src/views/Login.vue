
<template>
  
   <!-- <NavBarLogo></NavBarLogo>-->

  <div class="container">
  
      <!-- <div class="img">
            <img src="../assets/img/undraw_in_sync_xwsa.svg">
        </div>-->
       
        <div class="login-container">
          <h1></h1>
            <form class="auth-form login-form" @submit.prevent="login()" novalidate>
                <img class="avatar" src="../assets/img/avatar_male.svg">
                <h2>Bienvenido</h2>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        
                        <input  id="signin-email"
                          name="signin-email"
                          type="email"
                          class="form-control signin-email"
                          placeholder="Correo Electrónico"
                          required="required"
                          v-model="form.email"
                          :class="{
                            'is-invalid' : v$.email.$error,
                            'is-valid' :  !v$.email.$error && v$.email.$dirty
                          }">
                          <form-text-error v-for="(error, i) in v$.email.$errors" :key="i">{{error.$message}}</form-text-error>
                    </div>
                </div>

                <div class="input-div two">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                       
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
                         }">
                         <form-text-error v-for="(error, i) in v$.password.$errors" :key="i">{{error.$message}}</form-text-error>
                    </div>
                </div>
                <a href="#">¿Olvidaste la contraseña?</a>
                <input type="submit" class="btn" value="Login">
            </form>
        </div>
    </div>
</template>

<script>
import ('../../src/assets/css/style.css')
import ('../../src/assets/css/style1.css')
import Swal from 'sweetalert2';
import useVuelidate from '@vuelidate/core';
import {required, email, helpers} from '@vuelidate/validators';
import {ref} from 'vue';
import FormTextError from "../components/shared/validation/forms/FormTextError";
import {useStore} from "vuex";
import {useRouter} from "vue-router";
//import NavBarLogo from "../components/NavBarLogo.vue"


export default {
  name: "Login",
  components: {FormTextError, /*NavBarLogo*/},
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
