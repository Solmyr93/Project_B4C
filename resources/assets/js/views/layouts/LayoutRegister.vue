<template>
    <div class="login-wrapper">
        <div class="register-box">
            <div class="brand-main">
                <a href="/#"><img src="/assets/img/book4cook-logo.png" alt="Book 4 cook logo"></a>
            </div>
            <router-view></router-view>
            <book4cook-footer></book4cook-footer>
       </div>
    </div>
</template>

<script>
    import Book4CookFooter from './partials/Book4CookFooter.vue';

    export default {
        components: {
            Book4CookFooter
        },
        methods: {
            setLayoutClasses(){
                let body = $('body');
                body.removeClass();
                body.addClass('login-page')
            },
        },
        mounted() {
            this.setLayoutClasses()
        },
        destroyed(){
            $('body').removeClass('login-page')
        }
    }
</script>
