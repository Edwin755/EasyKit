  <form class="sign-up" ng-controller="register" ng-submit="create()">
    <h1 class="sign-up-title">Register</h1>
    <ul class="social_button">
        <?= $login ?>
    </ul>

    <div class="divider"></div>

    <input type="email" class="sign-up-input" name="email" ng-model="formData.email" placeholder="Email" ng-change="chrono()" autofocus required="">
    
    <input type="password" class="sign-up-input" name="password" ng-model="formData.password" placeholder="Password" required>

    <label>
      <input type="checkbox" name="tc" ng-model="formData.tc" required>
      I agree with the terms and conditions.
    </label>
    <div class="notif"></div>
    <input type="submit" value="Register now!" class="sign-up-button">
  </form>