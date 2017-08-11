<template>
  <form class="ui form">
    <div class="field">
      <label>Nickname</label>
      <input name="nickname" value="" type="text">
    </div>
    <div class="field">
      <label>E-mail</label>
      <input name="email" value="" type="text">
    </div>

    <div class="two fields">
      <div class="field">
        <label>Password</label>
        <input name="password" value="" type="password">
      </div>
      <div class="field">
        <label>Password confirm</label>
        <input name="password-confirm" value="" type="password">
      </div>
    </div>

    <div class="ui submit button">Submit</div>
    <div class="ui error message"></div>
  </form>
</template>
