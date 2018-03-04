<template>
    <div class="login-wrapper">
        <div class="row">
            <div class="col-sm-12 text-sm-center login-box">
                <h1 class="forgot-link">404</h1>
                <h5>Nie znakeziono strony!</h5>
                <router-link class="btn btn-theme btn-full" to="/"><i class="fa fa-arrow-left"></i> Go Home </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            setLayoutClasses(){
                let body = $('body');
                body.addClass('page-error-404')
            }
        },
        mounted() {
            this.setLayoutClasses()
        },
        destroyed(){
            $('body').removeClass('page-error-404')
        }
    }
</script>
