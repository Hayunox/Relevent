<template>
  <div id="app">
    <div class="ui huge menu">
      <a class="active item">
        Home
      </a>
      <div class="ui dropdown item">
        Events <i class="dropdown icon"></i>
        <div class="menu">
          <a class="item">My Events</a>
        </div>
      </div>
      <div class="ui dropdown item">
        Friends <i class="dropdown icon"></i>
        <div class="menu">
          <a class="item">English</a>
          <a class="item">Russian</a>
          <a class="item">Spanish</a>
        </div>
      </div>
      <div class="right menu">
        <div class="item">
          <router-link to="register"><div class="ui primary button">Sign Up</div></router-link>
        </div>
        <div class="item">
          <router-link to="login"><div class="ui primary button">Login</div></router-link>
        </div>
      </div>
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'app'
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>

