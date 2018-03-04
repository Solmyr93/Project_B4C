<template>
    <form id="registerForm" method="post">
     <div class="row">
      <div class="col-lg-3">
        <div class="input-image">
            <p class="input-image-text">
              <i class="fa fa-file-image-o"></i>
            </p>
            <input ref="myFiles"
                   class="custom-file-input file-input"
                   type="file"
                   name="avatar"
                   @change="imageChanged"
                   multiple>
        </div>
      </div>
      <div class="col-lg-9 register-form-center">
        <div class="col-lg-8">
          <div :class="{'form-group' : true , 'has-danger': errors.has('first_name') }">
              <input-text type="text"
                          class="form-control form-control-danger"
                          placeholder="Imię"
                          name="first_name"
                          v-model="registerData.first_name"
                          v-validate="'required|alpha'">
              </input-text>
              <span class="form-control-feedback"
                    v-show="errors.has('first_name')">
                    {{ errors.first('first_name') }}
              </span>
          </div>
          <div :class="{'form-group' : true , 'has-danger': errors.has('last_name') }">
              <input-text type="text"
                          class="form-control form-control-danger"
                          placeholder="Nazwisko"
                          name="last_name|alpha"
                          v-model="registerData.last_name"
                          v-validate="'required'">
              </input-text>
              <span class="form-control-feedback"
                    v-show="errors.has('last_name')">
                    {{ errors.first('last_name') }}
              </span>
          </div>
          <div :class="{'form-group' : true , 'has-danger': errors.has('email') }">
              <input-text type="email"
                          class="form-control form-control-danger"
                          placeholder="e-mail"
                          name="email"
                          v-model="registerData.email"
                          v-validate="'required|email'">
              </input-text>
              <span class="form-control-feedback"
                    v-show="errors.has('email')">
                    {{ errors.first('email') }}
              </span>
          </div>
          <div :class="{'form-group' : true , 'has-danger': errors.has('password') }">
              <input-text type="password"
                          class="form-control form-control-danger"
                          placeholder="Hasło"
                          name="password"
                          v-model="registerData.password"
                          v-validate="{ required: true, min: 8}">
              </input-text>
              <span class="form-control-feedback"
                    v-show="errors.has('password')">
                    {{ errors.first('password') }}
              </span>
          </div>
          <div :class="{'form-group' : true, 'has-danger': errors.has('password_confirmation') }">
              <input-text type="password"
                          class="form-control form-control-danger"
                          placeholder="Powtórz hasło"
                          name="password_confirmation"
                          v-model="registerData.password_confirmation"
                          v-validate="'required|confirmed:password'">
              </input-text>
              <span class="form-control-feedback"
                    v-show="errors.has('password_confirmation')">
                    {{ errors.first('password_confirmation') }}
              </span>
          </div>
      </div>
      <div class="col-lg-8">
          <button class="btn btn-theme btn-full"
                  type="button"
                  @click="validateBeforeSubmit">
                  Zarejestruj
          </button>
          <router-link class="btn btn-theme btn-full"
                       to="/#">
                       Strona głowna
          </router-link>
      </div>
     </div>
    </div>
  </form>
</template>
<script type="text/javascript">
import Auth from '../../../services/auth';
import InputText from '../inputs/InputText.vue';

export default {
    components:{
        InputText,
    },
    data() {
        return {
            registerData: {
                avatar: '',
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                password_confirmation: '',
            }
        }
    },
    methods: {
        validateBeforeSubmit(e){
          this.$validator.validateAll().then(result => {
              if (!result){
                  toastr['error']('Popraw błędy', 'Błąd rejestracji');
              }
              else{
                 Auth.register(this.registerData).then(() => {
                     this.registerData = null;
                     this.$router.push('/login');
                 })
               }
            });
        },
        imageChanged(e){
          const fileReader = new FileReader();
          fileReader.readAsDataURL(e.target.files[0]);
          fileReader.onload = (e) => {
              this.registerData.avatar = e.target.result;
          }
        },
    },
  }
</script>
