<template>
  <div id="app">
    <div class="ui labeled icon menu">
      <router-link to="home" tag="a" class="item">
        <i class="home icon"></i>
        Home
      </router-link>
      <router-link to="events" tag="a" class="item">
        <i class="users icon"></i>
        Events
      </router-link>
      <router-link to="contact" tag="a" class="item">
        <i class="talk icon"></i>
        Contacts
      </router-link>
      <router-link to="profile" tag="a" class="item">
        <i class="user icon"></i>
        Profile
      </router-link>
      <router-link to="register" tag="a" class="item"><i class="sign in icon"></i>Sign Up</router-link>
      <router-link to="login" tag="a" class="item"><i class="unlock alternate icon"></i>Login</router-link>
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

