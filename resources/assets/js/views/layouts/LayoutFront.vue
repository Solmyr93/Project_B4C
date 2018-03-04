<template>
    <div class="template-container">
        <book4cook-header :isLogged="isLogged"></book4cook-header>
        <transition name="fade" mode="out-in">
            <router-view :kategorie="kategorie" :isLogged="isLogged"></router-view>
        </transition>
        <book4cook-footer></book4cook-footer>
    </div>
</template>

<script type="text/babel">

    import Book4cookHeader from './partials/Book4CookHeader.vue'
    import Book4cookFooter from './partials/Book4CookFooter.vue'
    import Layout from '../../helpers/layout'

    export default {
        data() {
            return {
                'header': 'header',
                kategorie: [],
                isLogged: false,
            }
        },
        components: {
            Book4cookHeader, Book4cookFooter
        },
        mounted() {
            var self = this;

            axios.get('/api/auth/check').then(response =>  {
                self.isLogged = response.data.authenticated;
                console.log(response.data.authenticated);
            })

            axios.get('/api/v1/categories').then(response =>  {
                var categories = response.data;

                for(var i = 0; i < categories.length; i++) {
                    self.kategorie.push(categories[i].name);
                }
            }).catch(error => {
                console.log('Error', error.message);
            });

            Layout.set('layout-default');

        }
    }
</script>
