<template>
  <div class="ui raised very padded text container segment">
    <div class="ui attached message">
      <div class="header">
        Welcome back !
      </div>
      <br>
      <form class="ui form">
        <div class="field">
          <label>Nickname</label>
          <input name="nickname" placeholder="Nickname" type="text">
        </div>
        <div class="field">
          <label>Password</label>
          <input name="password" placeholder="Password" type="password">
        </div>
        <div class="field">
          <div class="ui checkbox">
            <input tabindex="0" class="hidden" type="checkbox">
            <label>I agree to the Terms and Conditions</label>
          </div>
        </div>
        <button class="ui button" type="submit">Submit</button>
      </form>
  </div>
  </div>
</template>
