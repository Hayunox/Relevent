<template>
  <form class="ui form">
    <div class="field">
      <label>First Name</label>
      <input name="first-name" placeholder="First Name" type="text">
    </div>
    <div class="field">
      <label>Last Name</label>
      <input name="last-name" placeholder="Last Name" type="text">
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
