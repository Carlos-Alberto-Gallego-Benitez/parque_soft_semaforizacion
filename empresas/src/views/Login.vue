<template>
<div class="container-fluid " style="margin-top:0px" data-aos="fade-right">
            <div class="" style="margin-top:50px">
                <div class="rounded d-flex justify-content-center">
                    <div class="col-md-6 col-sm-12 shadow-lg p-3 bg-light">
                        <div class="text-center">
                          <div class="col-md-12" data-aos="fade-right" >
                                <img src="../assets/img/dashboard/login.gif" class="img-fluid" alt="" width="200">
                            </div>
                            <h3 class="text-orange">Iniciar Sesion</h3>
                        </div>
                        <form @submit.prevent="login()" novalidate>
                            <div class="p-4">
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-success"><i
                                            class="bi bi-person-plus-fill text-white"></i></span>
                                    <input id="signin-email"
          name="signin-email"
          type="email"
          class="form-control signin-email"
          placeholder="Correo Electrónico"
          required="required"
          v-model="form.email"
          :class="{
                      'is-invalid' : v$.email.$error,
                      'is-valid' :  !v$.email.$error && v$.email.$dirty
                    }" >
                    <form-text-error v-for="(error, i) in v$.email.$errors" :key="i">{{error.$message}}</form-text-error>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-success"><i
                                            class="bi bi-key-fill text-white"></i></span>
                                    <input  v-model="form.password"
             name="signin-password"
             type="password"
             class="form-control "
             placeholder="Contraseña"
             required="required"
             :class="{
                         'is-invalid' : v$.password.$error,
                         'is-valid' : !v$.password.$error && v$.password.$dirty
                       }"
      >
      <form-text-error v-for="(error, i) in v$.password.$errors" :key="i">{{error.$message}}</form-text-error>
      
                                </div>
                                
                               <div class="text-center">
                                  <button class="btn btn-success text-center w-50 mt-2" type="submit">
                                    Acceder
                                </button>
                               </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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

    store.commit('SET_LAYOUT', 'AppLayout');

    const login = async () => {
      try{

        if(! await v.value.$validate()) return;

        Swal.fire({
          title : 'Estamos validando sus credenciales',
          text : 'Por favor espere',
          didOpen: () => {
            Swal.showLoading()
          },
          allowOutsideClick : false,
        });

        await store.dispatch("login", form.value);

        await Swal.fire({
          icon : "success",
          title : 'Exito!',
          text : 'Inicio de sesion correcto',
        });

        await router.push({ path : '/home' });

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
