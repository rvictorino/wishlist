<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="/css/main.css">
  </head>
  <body>
    <div id="app" class="container">
      
      <div class="wishlist">
        <card v-for="wish in wishes"
          v-bind:wish="wish"
          v-on:delete="deleteWish(wish)"/></card>
      </div>

      <form v-on:submit="createWish" action="/api/wishes" method="post">
        <input id="title" type="text" name="title" value="">
        <input id="url" type="text" name="url" value="">
        <button type="submit" name="button">
          Submit
        </button>
      </form>

    </div>
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
    <script type="text/javascript">

      Vue.component('card', {
        props: ['wish'],
        template: `
          <div class="wish">
            <div class="image">
              <img v-bind:src="wish.url" v-bind:alt="wish.title">
            </div>
            <div class="title">
              <p>{{ wish.title }}</p>
              <button class="delete" v-on:click="$emit('delete')">
                <i class="fa fa-times" aria-hidden="true"></i>
              </button>
            </div>
          </div>`
      })

      var app = new Vue({
        el: "#app",
        data: {
          wishes: []
        },
        methods: {
          listWishes: function() {
              axios.get('/api/wishes')
              .then(response => this.wishes = response.data)
          },
          deleteWish: function(wish) {
            axios.delete(`/api/wishes/${wish.id}`)
              .then( () => this.listWishes())
          },
          createWish: function(e) {
            e.preventDefault();
            var title = document.getElementById('title')
            var url = document.getElementById('url')
            axios.post('/api/wishes', {
              title: title.value,
              url: url.value,
            }).then( () => this.listWishes())
          }
        },
        created() { this.listWishes() }
      })
    </script>
  </body>
</html>
