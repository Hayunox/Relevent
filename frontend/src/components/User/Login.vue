<template>
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
</template>
