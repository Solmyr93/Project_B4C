import Vue from 'vue'
import VueRouter from 'vue-router'

import AuthService from './services/auth'

/*
 |--------------------------------------------------------------------------
 | Admin Views
 |--------------------------------------------------------------------------|
 */

//Dashboard
import Basic from './views/admin/dashboard/Basic.vue'
import Ecommerce from './views/admin/dashboard/Ecommerce.vue'
import Finance from './views/admin/dashboard/Finance.vue'

//Layouts
import LayoutBasic from './views/layouts/LayoutBasic.vue'
import LayoutHorizontal from './views/layouts/LayoutHorizontal.vue'
import LayoutIconSidebar from './views/layouts/LayoutIconSidebar.vue'
import LayoutLogin from './views/layouts/LayoutLogin.vue'
import LayoutRegister from './views/layouts/LayoutRegister.vue'
import LayoutFront from './views/layouts/LayoutFront.vue'

//Basic UI
import Buttons from './views/admin/basic-ui/Buttons.vue'
import Cards from './views/admin/basic-ui/Cards.vue'
import Tabs from './views/admin/basic-ui/Tabs.vue'
import Typography from './views/admin/basic-ui/Typography.vue'
import Tables from './views/admin/basic-ui/Tables.vue'

//Components
import Datatables from './views/admin/components/Datatables.vue'
import Notifications from './views/admin/components/Notifications.vue'
import Graphs from './views/admin/components/Graphs.vue'

//Forms
import General from './views/admin/forms/General.vue'
import Advanced from './views/admin/forms/Advanced.vue'
import Layouts from './views/admin/forms/FormLayouts.vue'
import Validation from './views/admin/forms/FormValidation.vue'
import Editors from './views/admin/forms/Editors.vue'
import VeeValidate from './views/admin/forms/VeeValidate.vue'

//Settings
import Settings from './views/admin/Settings.vue'

/*
 |--------------------------------------------------------------------------
 | Other
 |--------------------------------------------------------------------------|
 */

//Auth
import Login from './views/auth/Login.vue'
import Register from './views/auth/Register.vue'

import NotFoundPage from './views/errors/404.vue'

/*
 |--------------------------------------------------------------------------
 | Frontend Views
 |--------------------------------------------------------------------------|
 */

 //Book 4 Cook Layouts////////////////////////////////////
 /*MAIN*/
 import Book4cookFront from './views/book4cookLayouts/Book4cookFront.vue'
 /*CONTENT*/

 ////////////////////////////////////////////////////////


Vue.use(VueRouter)

const routes = [

    /*
     |--------------------------------------------------------------------------
     | Layout Routes for DEMO
     |--------------------------------------------------------------------------|
     */

    {
        path: '/admin/layouts', component: LayoutBasic,
        children: [
            {
                path: 'sidebar',
                component: Basic
            },
        ]
    },
    {
        path: '/admin/layouts', component: LayoutHorizontal,
        children: [
            {
                path: 'horizontal',
                component: Basic
            },
        ]
    },
    {
        path: '/admin/layouts', component: LayoutIconSidebar,
        children: [
            {
                path: 'icon-sidebar',
                component: Basic
            },
        ]
    },

    /*
     |--------------------------------------------------------------------------
     | Frontend Routes
     |--------------------------------------------------------------------------|
     */

    {
        path: '/', component: Book4cookFront,
        children: [
            {
                path: '/',
                component: Book4cookHome,
                name: 'book4cookHome'
            },
          
        ]
    },

    /*
     |--------------------------------------------------------------------------
     | Admin Backend Routes
     |--------------------------------------------------------------------------|
     */
    {
        path: '/admin', component: LayoutBasic,  // Change the desired Layout here
        meta: { requiresAuth: true },
        children: [

            //Dashboard
            {
                path: 'dashboard/basic',
                component: Basic,
                name: 'dashboard',
            },
            {
                path: 'dashboard/ecommerce',
                component: Ecommerce
            },
            {
                path: 'dashboard/finance',
                component: Finance
            },

            //Basic UI
            {
                path: 'basic-ui/buttons',
                component: Buttons
            },
            {
                path: 'basic-ui/cards',
                component: Cards
            },
            {
                path: 'basic-ui/tabs',
                component: Tabs
            },
            {
                path: 'basic-ui/typography',
                component: Typography
            },
            {
                path: 'basic-ui/tables',
                component: Tables
            },

            //Components
            {
                path: 'components/datatables',
                component: Datatables
            },
            {
                path: 'components/notifications',
                component: Notifications
            },
            {
                path: 'components/graphs',
                component: Graphs
            },

            //Forms
            {
                path: 'forms/general',
                component: General
            },
            {
                path: 'forms/advanced',
                component: Advanced
            },
            {
                path: 'forms/layouts',
                component: Layouts
            },
            {
                path: 'forms/validation',
                component: Validation
            },
            {
                path: 'forms/editors',
                component: Editors
            },
            {
                path: 'forms/vee',
                component: VeeValidate
            },

            //Settings
            {
                path: 'settings',
                component: Settings
            },
        ]
    },

    /*
     |--------------------------------------------------------------------------
     | Auth & Registration Routes
     |--------------------------------------------------------------------------|
     */

    {
        path: '/', component: LayoutLogin,
        children: [
            {
                path: 'login',
                component: Login,
                name: 'login'
            },
        ]
    },

    {
        path: '/', component: LayoutRegister,
        children: [
            {
                path: 'register',
                component: Register,
                name: 'register'
            },
        ]
    },
    // DEFAULT ROUTE
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
