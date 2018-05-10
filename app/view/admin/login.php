{{include "header-clean"}}

<div class="overlay-header">
  <a href="{{config.directory}}" class="header-item">Back to main site</a>
</div>

<div class="container pt-5">
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="text-center">
        <h3 class="text-center">Log in</h3>
        <small class="text-muted">Access the administrator panel using your login credentials.</small>
      </div>
      <div class="text-danger pb-2">
        {{message}}
      </div>
      <form method="POST" class="form">
        <div class="form-group">
          <input class="form-control" name="name" type="text" placeholder="Admin user name">
        </div>
        <div class="form-group">
          <input class="form-control" name="password" type="password" placeholder="Password">
        </div>
        <div class="form-group text-center">
          <input class="btn btn-default" type="submit" value="Login">
        </div>
      </form>
    </div>
  </div>
</div>

{{include "footer-clean"}}
