<template>
    <header class="site-header">
      <router-link to="/#" class="brand-main">
          <img src="/assets/img/book4cook-logo.png" id="logo-desk" alt="Book 4 cook logo" class="hidden-sm-down">
      </router-link>
      <ul class="action-list" v-if="isLogged">
          <li>
              <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="avatar"><img src="/assets/img/avatars/avatar2.png" alt="Avatar"></a>
              <div class="dropdown-menu dropdown-menu-right notification-dropdown">
                  <router-link class="dropdown-item" to="/addNewRecepie"><i class="fa fa-plus"></i> Nowy przepis</router-link>
                  <a href="#" class="dropdown-item" @click.prevent="logout"><i class="fa fa-sign-out"></i> Wyloguj</a>
              </div>
          </li>
      </ul>
      <ul class="action-list" v-else>
          <li>
              <router-link to="/register"><i class="fa fa-edit"></i> Rejestracja</router-link>
          </li>
          <li>
              <router-link to="/login"><i class="fa fa-sign-in"></i> Logowanie</router-link>
          </li>
      </ul>
    </header>
</template>


<script type="text/babel">

    import Layout from '../../../helpers/layout'
    import Auth from '../../../services/auth'

    export default {
        props:['isLogged'],
        data() {
            return {
                'header' : 'header',
            }
        },
        methods : {
            onNavToggle(){
                Layout.toggleSidebar()
            },
            logout(){
                Auth.logout().then(() => {
                    this.$router.replace('/login')
                })
            }
        }

    }
</script>
