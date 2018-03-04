<template>
    <form id="loginForm" method="post" @submit.prevent="validateBeforeSubmit">
        <div class="form-group">
            <input type="email" class="form-control form-control-danger" placeholder="e-mail" name="email"
                   v-model="loginData.email" v-validate data-vv-rules="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control form-control-danger" placeholder="Hasło" name="password"
                   v-model="loginData.password" v-validate data-vv-rules="required">
        </div>
        <div class="other-actions row">
            <div class="col-sm-6">
                <router-link class="forgot-link" to="/register" >Nie masz konta?</router-link>
            </div>
        </div>
        <button class="btn btn-theme btn-full">Zaloguj</button>
        <router-link class="btn btn-theme btn-full" to="/#">Strona głowna</router-link>
    </form>
</template>

<script type="text/babel">
    import Auth from '../../services/auth'

    export default {
        data() {
            return {
                loginData: {
                    email: null,
                    password: null,
                    remember: ''
                }
            }
        },
        methods: {
            validateBeforeSubmit(e){
                this.$validator.validateAll();

                if (!this.errors.any()) {
                    Auth.login(this.loginData).then(() => {
                        this.loginData.email = null;
                        this.loginData.password = null;
                    });
                }
            }
        },
    }
</script>
