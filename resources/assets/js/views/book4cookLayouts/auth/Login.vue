<template>
    <form id="loginForm" method="post">
        <div class="form-group"
             :class="{'has-danger' : errors.has('email')}">
            <input-text
                   v-model="loginData.email"
                   name="email"
                   placeholder="Email"
                   type="text"
                   rules="required"
                   v-validate="'required|email'">
            </input-text>
            <div v-show="errors.has('email')"
                  class="help form-control-feedback">
                  {{ errors.first('email') }}
            </div>
        </div>
        <div class="form-group"
             :class="{'has-danger' : errors.has('password')}">
            <input-text
                   v-model="loginData.password"
                   name="password"
                   placeholder="Hasło"
                   type="password"
                   rules="required"
                   v-validate="'required'">
            </input-text>
            <div v-show="errors.has('password')"
                  class="help form-control-feedback">
                  {{ errors.first('password') }}
            </div>
        </div>
        <div class="other-actions row">
             <div class="col-sm-6">
                <div class="checkbox">
                    <label class="c-input c-checkbox">
                        <input type="checkbox"
                               name="remember"
                               v-model="loginData.remember">
                        <span class="c-indicator">
                               Zapamiętaj mnie
                        </span>
                    </label>
                </div>
            </div>
            <div class="col-sm-6">
                <router-link class="forgot-link link-to-register"
                             to="/register">
                             Nie masz konta?
                </router-link>
            </div>
        </div>
        <button class="btn btn-theme btn-full"
                type="button"
                @click="validateBeforeSubmit">
                Zaloguj
        </button>
        <router-link class="btn btn-theme btn-full"
                     to="/#">
                     Strona głowna
        </router-link>
    </form>
</template>

<script type="text/babel">
    import Auth from '../../../services/auth'
    import InputText from '../inputs/InputText.vue'

    export default {
        components:{
            InputText
        },
        data() {
            return {
                loginData: {
                    email: '',
                    password: '',
                    remember: ''
                },
            }
        },
        methods: {
            validateBeforeSubmit(e){
                this.$validator.validateAll().then(result => {
                    if (!result){
                        toastr['error']('Popraw błędy!', 'Błąd logowania');
                    }
                    else {
                        Auth.login(this.loginData, this.$router).then(() => {
                            this.loginData.email = "";
                            this.loginData.password = "";
                        });
                    }
               });
            },
        },
    }
</script>
<style scoped>
    .form-control-feedback {
        text-align: center;
    }

</style>
