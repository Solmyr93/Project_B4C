<template>
    <div class="template-container">
        <book4cook-header :isLogged="isLogged"
                          :avatar="user.avatar"></book4cook-header>
        <transition name="fade"
                    mode="out-in">
            <router-view :categories="categories"
                         :tags="tags"
                         :isLogged="isLogged"
                         :user="user">
            </router-view>
        </transition>
        <book4cook-footer></book4cook-footer>
    </div>
</template>

<script>

    import Book4cookHeader from './partials/Book4cookHeader.vue';
    import Book4cookFooter from './partials/Book4cookFooter.vue';
    import Layout from '../../helpers/layout';
    import Ss from '../../services/ss';

    export default {
        data() {
            return {
                categories: [],
                tags: [],
                isLogged: false,
                user:{
                  avatar: null,
                  favorite_recipes: null,
                  my_recipes: null,
                },
            }
        },
        components: {
            Book4cookHeader,
            Book4cookFooter,
        },
        created() {
            var self = this;

            axios.get('/api/auth/check').then(response =>  {
                self.isLogged = response.data.authenticated;
                if(self.isLogged){
                    self.user.avatar = Ss.get('auth.avatar', response.data.avatar);
                    self.user.avatar = Ss.get('auth.favorite_recipes', response.data.favorite_recipes);
                    self.user.avatar = Ss.get('auth.my_recipes', response.data.my_recipes);
                }
            }).catch(error => {
                self.isLogged = false;
            });

            axios.get('/api/v1/home').then(response =>  {
                self.categories = response.data.categories;
                self.tags = response.data.tags;
            }).catch(error => {
                console.log('Error', error.message);
            });
            Layout.set('layout-default');

        },
    }
</script>
