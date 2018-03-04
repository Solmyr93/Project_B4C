<template>
    <header class="site-header">
      <router-link to="/#"
                   class="brand-main">
          <img src="/assets/img/book4cook-logo.png"
               id="logo-desk"
               alt="Book 4 cook logo"
               class="hidden-sm-down">
      </router-link>
      <ul class="action-list"
          v-if="isLogged">
          <li>
              <a href="#"
                 data-toggle="dropdown"
                 aria-haspopup="true"
                 aria-expanded="false"
                 class="avatar">
                 <img :src="avatarUser" alt="Avatar">
              </a>
              <div class="dropdown-menu dropdown-menu-right notification-dropdown">
                  <router-link class="dropdown-item"
                               to="/edit-recepie">
                               <i class="fa fa-plus"></i>
                               <span> Nowy przepis</span>
                  </router-link>
                  <a href="#"
                     class="dropdown-item"
                     @click.prevent="logout">
                     <i class="fa fa-sign-out"></i>
                     <span> Wyloguj</span>
                  </a>
              </div>
          </li>
      </ul>
      <ul class="action-list" v-else>
          <li>
              <router-link to="/register">
                  <i class="fa fa-edit"></i>
                  </span> Rejestracja</span>
              </router-link>
          </li>
          <li>
              <router-link to="/login">
                  <i class="fa fa-sign-in"></i>
                  <span> Logowanie</span>
              </router-link>
          </li>
      </ul>
    </header>
</template>


<script>
    import Auth from '../../../services/auth';
    import Ss from '../../../services/ss';

    export default {
        props: {
          isLogged: {
            type: Boolean,
            required: true,
          },
        },
        data(){
          return{
              avatarUser: "",
          }
        },
        created() {
            this.avatarUser = Ss.get('auth.avatar');
            if(this.avatarUser){
                this.avatarUser = '/assets/img/avatars/' + this.avatarUser;;
            }else{
                this.avatarUser = "";
            }
        },
        methods: {
            logout(){
                Auth.logout().then(() => {
                    this.$router.replace('/login')
                })
            }
        }

    }
</script>
