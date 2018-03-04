import Vue from 'vue'
import VueRouter from 'vue-router'

import AuthService from './services/auth'

 //Book 4 Cook Layouts////////////////////////////////////
 /*MAIN*/
 import Book4cookFront from './views/book4cookLayouts/Book4cookFront.vue'
 import Book4cookLogin from './views/book4cookLayouts/Book4cookLogin.vue'
 import Book4cookRegister from './views/book4cookLayouts/Book4cookRegister.vue'
 /*CONTENT - HOME*/
 import Book4cookHome from './views/book4cookLayouts/front/Book4cookHome.vue'
 import EditRecepie from './views/book4cookLayouts/front/EditRecepie.vue'
 import Recepie from './views/book4cookLayouts/front/Recepie.vue'
 /*CONTENT - LOGIN*/
 import Login from './views/book4cookLayouts/auth/Login.vue'
 /*CONTENT - REGISTER*/
 import Register from './views/book4cookLayouts/auth/Register.vue'
 ////////////////////////////////////////////////////////
 import NotFoundPage from './views/book4cookLayouts/errors/404.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '/', component: Book4cookFront,
        children: [
            {
                path: '/',
                component: Book4cookHome,
                name: 'home'
            },
            {
                path: '/edit-recepie',
                component: EditRecepie,
                name: 'EditRecepie'
            },
            {
                path: '/recepie',
                component: Recepie,
                name: 'Recepie'
            },
        ]
    },
    {
        path: '/', component: Book4cookLogin,
        children: [
            {
                path: 'login',
                component: Login,
                name: 'login'
            },
        ]
    },

    {
        path: '/', component: Book4cookRegister,
        children: [
            {
                path: 'register',
                component: Register,
                name: 'register'
            },
        ]
    },
    {   path: '*', component : NotFoundPage }
]

const router = new VueRouter({
    routes,
    mode: 'history',
    linkActiveClass: 'active'
})
/*
router.beforeEach((to, from, next) => {

    // If the next route is requires user to be Logged IN
    if (to.matched.some(m => m.meta.requiresAuth)){

        return AuthService.check().then(authenticated => {
            if(!authenticated){
                return next({ path : '/login'})
            }

            return next()
        })
    }

    return next()
});
*/
export default router
