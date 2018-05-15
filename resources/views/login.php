<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="/css/main.css">
    <style>
      /*debug*/
      /*.content {
        border: 1px solid blue;
      }
      .image {
        border: 1px solid green;
      }
      .wish {
        border: 1px solid red;
      }*/
    </style>
  </head>
  <body>
    <div id="app" class="container">

      <form id="login-form" v-on:submit="login" action="/api/auth" method="post">
        <input id="email" type="text" name="email" value="">
        <input id="password" type="password" name="password" value="">
        <button type="submit" name="button">
          Submit
        </button>
      </form>

    </div>
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
    <script type="text/javascript">

      var app = new Vue({
        el: "#app",
        data: {
          wishes: []
        },
        methods: {
          login: function(e) {
            e.preventDefault();
            var email = document.getElementById('email')
            var password = document.getElementById('password')
            axios.post('/api/auth', {
              email: email.value,
              password: password.value,
            }).then( (data) => {
              if(data.token != undefined) {
                //store user token to use for further logged operationss
                
              }
            })
          }
        }
      })
    </script>
  </body>
</html>
