<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <script>
      localStorage['EVO.HOST'] = location.href.replace(location.hash, '').replace('/manager/', '/')
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container p-5">
    <form>
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <input type="hidden" name="method" value="Auth@login">

        <h1 class="h3 mb-3 fw-bold">Login</h1>

        <div class="form-group form-floating mb-3">
            <input type="text" id="floatingName" class="form-control" name="username" value="{{ old('username') }}"
                   placeholder="Username" required="required" autofocus>
            <label for="floatingName">Username</label>
            @if ($errors->has('username'))
                <span class="text-danger text-left">{{ $errors->first('username') }}</span>
            @endif
        </div>

        <div class="form-group form-floating mb-3">
            <input type="password" id="floatingPassword" class="form-control" name="password"
                   value="{{ old('password') }}" placeholder="Password" required="required">
            <label for="floatingPassword">Password</label>
            @if ($errors->has('password'))
                <span class="text-danger text-left">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <button class="w-100 btn btn-lg btn-primary py-2" type="submit">
            <span class="d-inline-block p-1">Login</span>
        </button>
    </form>
</div>

<script>
  document.querySelector('form').addEventListener('submit', e => {
    e.preventDefault()

    console.log(e.target.querySelectorAll('.text-danger'))

    e.target.querySelectorAll('.text-danger').forEach(el => {
      el.parentElement.removeChild(el)
    })

    fetch(e.target.action, {
      method: 'put',
      body: JSON.stringify({
        method: 'Auth@login',
        username: e.target.username.value,
        password: e.target.password.value,
        remember: e.target?.remember?.value || true,
      }),
      headers: {
        'Cache': 'no-cache',
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      credentials: 'same-origin'
    }).then(response => response.json()).then(data => {
      if (data.success) {
        if (data.redirect) {
          return location.href = '.' + data.redirect
        }

        return location.reload()
      }

      if (data.errors) {
        for (let i in data.errors) {
          let el = e.target.querySelector('[name="' + i + '"]')
          if (el) {
            el.parentElement.insertAdjacentHTML('beforeend',
              '<span class="text-danger text-left">' + data.errors[i] + '</span>')
          }
        }
      }
    })
  })
</script>
</body>
</html>
