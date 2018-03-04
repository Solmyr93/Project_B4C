<template>
    <form id="registerForm" method="post" @submit.prevent="validateBeforeSubmit">
     <div class="row">
      <div class="col-lg-3">
        <div class="input-image">
            <p class="input-image-text"><i class="fa fa-file-image-o"></i></p>
            <input ref="myFiles" class="custom-file-input file-input" type="file" name="avatar" @change="imageChanged" multiple>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="col-lg-8">
          <h4><u>Informacje podstawowe:</u></h4>
          <div :class="{'form-group' : true , 'has-danger': errors.has('first_name') }">
              <input type="text" class="form-control form-control-danger" placeholder="Imię" name="first_name" v-model="registerData.first_name" v-validate data-vv-rules="required">
          </div>
          <div :class="{'form-group' : true , 'has-danger': errors.has('last_name') }">
              <input type="text" class="form-control form-control-danger" placeholder="Nazwisko" name="last_name" v-model="registerData.last_name" v-validate data-vv-rules="required">
          </div>
          <div :class="{'form-group' : true , 'has-danger': errors.has('email') }">
              <input type="email" class="form-control form-control-danger" placeholder="e-mail" name="email" v-model="registerData.email" v-validate data-vv-rules="required|email">
          </div>
          <div :class="{'form-group' : true , 'has-danger': errors.has('password') }">
              <input type="password" class="form-control form-control-danger" placeholder="Hasło" name="password" id="password" v-model="registerData.password" v-validate data-vv-rules="required">
          </div>
          <div :class="{'form-group' : true , 'has-danger': errors.has('password_confirmation') }">
              <input type="password" class="form-control form-control-danger" placeholder="Powtórz hasło" name="password_confirmation" v-model="registerData.password_confirmation" v-validate data-vv-rules="required">
          </div>
      </div>
      <div class="col-lg-8">
          <button class="btn btn-theme btn-full">Zarejestruj</button>
          <router-link class="btn btn-theme btn-full" to="/#">Strona głowna</router-link>
      </div>
      </div>
    </div>
  </form>
</template>
<script type="text/javascript">
import Auth from '../../services/auth'

export default {
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
            this.$validator.validateAll();

            var validate = true;
            $('.form-control').each(function(index, el) {
              if($(this).val() == "") {
                validate = false;
              }
            });

            if (!this.errors.any() && validate) {
              Auth.register(this.registerData).then(() => {
                  this.$router.push('/login')
              })
            }
        },

        imageChanged(e) {
          var fileReader = new FileReader();

          fileReader.readAsDataURL(e.target.files[0]);
          fileReader.onload = (e) => {
            this.registerData.avatar = e.target.result;
          }
        }
    },
  }
</script>
