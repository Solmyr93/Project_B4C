<template>
    <div class="login-wrapper">
        <div class="register-box">
            <div class="brand-main">
                <a href="/#">
                    <img src="/assets/img/book4cook-logo.png"
                         alt="Book 4 cook logo">
                </a>
            </div>
            <router-view></router-view>
                <div class="page-copyright">
                <p>Projekt SGGW - ISI 2017 - 2018</p>
            </div>
       </div>
    </div>
</template>

<script>
    import Ls from '../../services/ls';

    export default {
        methods: {
            setLayoutClasses(){
                let body = $('body');
                body.removeClass();
                body.addClass('login-page')
            },
        },
        created(){
            if(!!Ls.get('auth.token')) {
               this.$router.push('/#');
            }
        },
        mounted() {
            this.setLayoutClasses()
        },
        destroyed(){
            $('body').removeClass('login-page')
        }
    }
</script>
