import Ls from './ls';
import Ss from './ss';


export default {

  login(loginData, $router) {

    return axios.post('/api/auth/login', loginData).then(response => {
      Ss.set('auth.avatar', response.data.avatar);
      Ss.set('auth.favorite_recipes', response.data.favorite_recipes);
      Ss.set('auth.my_recipes', response.data.my_recipes);
      Ls.set('auth.token', response.data.token);
      toastr['success']('Zalogowano!', 'Success');
      $router.push('/#');
    }).catch(error => {
      if (error.response.status == 401) {
        toastr['error']('Nie poprawny e-mail lub hasło', 'Błąd logowania');
      } else {
        // Something happened in setting up the request that triggered an Error
        console.log('Error', error.message);
      }
    });

  },

  logout() {
    return axios.get('/api/auth/logout').then(response => {
      Ss.remove('auth.avatar', response.data.avatar);
      Ss.remove('auth.favorite_recipes', response.data.favorite_recipes);
      Ss.remove('auth.my_recipes', response.data.my_recipes);
      Ls.remove('auth.token');
      toastr['success']('Wylogowano!', 'Success');
    }).catch(error => {
      console.log('Error', error.message);
    });
  },

  check() {
    return axios.get('/api/auth/check').then(response => {
      return !!response.data.authenticated;
    }).catch(error => {
      console.log('Error', error.message);
    });
  },

  register(registerData) {

    return axios.post('/api/auth/register', registerData).then(response => {
      toastr['success']('Zarejestrowano!', 'Success');
    }).catch(error => {
      if (error.response.status == 422) {
        toastr['error']('Użytkownik o podanym adresie email już istnieje', 'Błąd rejestracj');
      } else {
        // Something happened in setting up the request that triggered an Error
        console.log('Error', error.message);
      }
    });

  },
}