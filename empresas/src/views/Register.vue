<template>
  <section id="about" class="about">
    <div class="container-fluid "><br>
        <div class="card mt-4">
            <div class="card-header bg-light text-orange">
              Registro de Usuario 
            </div>
            <div class="card-body">
              <div class="row content">
                <div class="col-md-4" data-aos="fade-right">
                    <img src="../assets/img/dashboard/perfil1.png" class="img-fluid" alt="">
                </div>
                <div class="col-md-8 pt-4" data-aos="fade-left">
                  <form class="auth-form auth-signup-form" >
                    <div class="email mb-3">
                      <label class="form-label" for="signup-email">Nombre</label>
                      <input
                          type="text"
                          class="form-control"
                          placeholder="Nombre"
                          required="required"
                         v-model="name"
                      >
                      
                    </div>
                    <div class="email mb-3">
                      <label class="form-label" for="signup-email">Correo Electronico</label>
                      <input
                          type="email"
                          class="form-control"
                          placeholder="Correo Electronico"
                          required="required"
                         v-model="email"
                      >
                      
                    </div>
                    <div class="password mb-3">
                      <label class="form-label" for="signup-password">Contraseña</label>
                      <input
                          id="signup-password"
                          name="signup-password"
                          type="password"
                          class="form-control signup-password"
                          placeholder="Contraseña"
                          required="required"
                          v-model="password"
                      >
                    </div>
                    
                    

                    <div class="text-center">
                      <button type="button" class="btn btn-success w-25 theme-btn mx-auto" @click="registro();">Registrarse</button>
                    </div>
                  </form><!--//auth-form-->
                </div>
              </div>
            </div>
        </div>
    </div>
  </section>
</template>

<script>

import {useVuelidate} from '@vuelidate/core';
import {required} from '@vuelidate/validators';
import Swal from "sweetalert2";
//import {useRouter} from 'vue-router';
//import {useStore} from "vuex";
import usuarioService from '../services/usuarioService';

export default {
   data(){
        return{
            v$:useVuelidate(),
            name:'',
            email:'',
            password:'',
            tipo:'3',
        }
    },
     validations(){
        return{
            name:{required},
            email:{required},
            password:{required},
        }
    },
    methods: {
      async registro(){
        try{
          this.v$.$validate();

          if(this.v$.$error){
            Swal.fire('Hay campos vacios','', 'error');
          }else{

            let usuario={
              name:this.name,
              email:this.email,
              password:this.password,
              tipo:this.tipo
            }  
            
            this.$store.dispatch('showSpinner'); 
            await usuarioService.store(usuario);
            this.$store.dispatch('hideSpinner');
            Swal.fire('Datos guardados con exito','', 'success');
            this.$router.push({name:'login'});

            
            
          }
        }catch (e) {

          console.error(e);

          Swal.fire({
            icon : "error",
            title : 'Ups!',
            text : 'Ha ocurrido un error al procesar la solicitud'
          });
        }
      }
    }
}
</script>

<style scoped>

</style>
