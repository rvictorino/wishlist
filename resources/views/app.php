<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-router"></script>
    <script src="https://unpkg.com/vuex"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/main.css">
  </head>
  <body>
    <div id="app" class="container">

      <section>
        <router-link to="/login" v-if="!isLoggedIn">Login</router-link>
        <a href="#" v-if="isLoggedIn" @click="logout">Logout</a>
      </section>
      <router-view></router-view>

    </div>
    <script type="text/javascript">
      const LOGIN = "LOGIN";
      const LOGIN_SUCCESS = "LOGIN_SUCCESS";
      const LOGOUT = "LOGOUT";

      const store = new Vuex.Store({
        state: {
          isLoggedIn: !!localStorage.getItem("token")
        },
        getters: {
          isLoggedIn: state => state.isLoggedIn
        },
        mutations: {
          [LOGIN] (state) {
            state.pending = true;
          },
          [LOGIN_SUCCESS] (state) {
            state.isLoggedIn = true;
            state.pending = false;
          },
          [LOGOUT](state) {
            state.isLoggedIn = false;
          }
        },
        actions: {
          login({ commit }, creds) {
            commit(LOGIN); // show spinner
            return axios.post('/api/auth', {
              email: creds.email,
              password: creds.password,
            }).then(response => new Promise((resolve, reject)  => {
                if(response.data.token) {
                  commit(LOGIN_SUCCESS);
                  resolve();
                } else {
                  rejet();
                }
            }));
          },
        }
      });

      Vue.use( VueRouter );

      const Login = Vue.component('login', {
        template: `
          <form id="login-form" @submit.prevent="login()">
            <input id="email" type="text" name="email" value="">
            <input id="password" type="password" name="password" value="">
            <button type="submit">
              Log In
            </button>
          </form>
        `,
        methods: {
          login: function() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            this.$store.dispatch("login", {
              email,
              password
            }).then((token) => {
              //store user token to use for further logged operations
              console.log(token);
              // redirect to home
              router.push({ name: 'home', params: { token: token }});
            });
          }
        }
      });

      const Card = Vue.component('card', {
        props: ['wish'],
        template: `
          <div class="wish">
            <div class="image">
              <picture>
                <img v-bind:src="wish.url" v-bind:alt="wish.title">
                <source media="(min-width: 100px)" srcset="wish.url">
              </picture>
            </div>
            <div class="content">
              <p>{{ wish.title }}</p>
              <button class="delete" v-on:click="$emit('delete')">
                <i class="fa fa-times" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        `
      });

      const Home = Vue.component('home', {
        components: {
          Card
        },
        template: `
          <div>
            <form @submit.prevent="createWish()" v-if="isLoggedIn">
              <input id="url" type="text" name="url" value="">
              <input id="title" type="text" name="title" value="">
              <button type="submit">
                Submit
              </button>
            </form>
            <div class="wishlist">
              <card v-for="wish in wishes"
                v-bind:wish="wish"
                v-on:delete="deleteWish(wish)"></card>
            </div>
          </div>
        `,
        data: () => ({
          wishes: [],
          isLoggedIn: store.getters.isLoggedIn
        }),
        methods: {
          listWishes: function() {
              axios.get('/api/wishes')
                .then(response => this.wishes = /*response.data*/[{title: 'a', url: 'a.com'}]);
          },
          deleteWish: function(wish) {
            axios.delete(`/api/wishes/${wish.id}`)
              .then( () => this.listWishes());
          },
          createWish: function() {
            const title = document.getElementById('title');
            const url = document.getElementById('url');
            axios.post('/api/wishes', {
              title: title.value,
              url: url.value,
            }).then( () => this.listWishes());
          }
        },
        created() { console.log(this.isLoggedIn);this.listWishes() }
      });

      const Main = Vue.component('main', {

      }

      const router = new VueRouter({
        routes: [
          {
            path: '/',
            name: 'home',
            component: Home
          },
          {
            path: '/login',
            name: 'login',
            component: Login
          }
        ]
      });

      const app = new Vue({
        router,
        store,
        computed: {
          isLoggedIn() {
            return this.$store.getters.isLoggedIn;
          }
        }
      }).$mount('#app');
    </script>
  </body>
</html>
