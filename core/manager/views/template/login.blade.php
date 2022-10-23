<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body { height: 100%; }
        html { font-size: 0.7777rem; }
        body { font-size: 13px; }
        .main { background: url("https://picsum.photos/1600/900") 50% 50% no-repeat; background-size: cover }
        .sidebar { width: 30rem; max-width: 100%; }
        .active .input-list { display: block; }
        .input-list { display: none; z-index: 10; }
        .input-list > div:hover { background: var(--bs-primary); color: var(--bs-light); }
        .input-list-remove { cursor: pointer }
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 2rem black inset !important;
            -webkit-text-fill-color: #fff !important;
        }
    </style>
</head>
<body>

<div class="main w-100 h-100 d-flex flex-nowrap bg-dark">

    <div class="col-auto sidebar p-5 bg-dark bg-opacity-75 text-white text-opacity-75">
        <form>

            <div class="form-group form-floating mb-3">
                <input name="host"
                       type="text"
                       id="floatingHost"
                       class="form-control form-control-lg rounded-0 border-light bg-transparent text-white"
                       onfocus="listOpen(event)"
                       onblur="listClose(event)"
                       value="{{ old('host') }}"
                       placeholder="Hostname">
                <label for="floatingHost">Valid hostnames</label>
            </div>

            <div class="form-group form-floating mb-3">
                <input name="username"
                       type="text"
                       id="floatingName"
                       class="form-control form-control-lg rounded-0 border-light bg-transparent text-white {{ $errors->has('username') ? 'border-danger' : '' }}"
                       value="{{ old('username') }}"
                       placeholder="Username"
                       autofocus>
                <label for="floatingName">Username</label>
                @if ($errors->has('username'))
                    <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                @endif
            </div>

            <div class="form-group form-floating mb-3">
                <input name="password"
                       type="password"
                       id="floatingPassword"
                       class="form-control form-control-lg rounded-0 border-light bg-transparent text-white {{ $errors->has('password') ? 'border-danger' : '' }}"
                       value="{{ old('password') }}"
                       placeholder="Password">
                <label for="floatingPassword">Password</label>
                @if ($errors->has('password'))
                    <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-check">
                        <input name="remember"
                               type="checkbox"
                               id="rememberme"
                               class="form-check-input rounded-0 border-light bg-transparent" >
                        <label class="form-check-label" for="rememberme">Remember me</label>
                    </div>
                </div>
                <div class="col-auto">
                    <button class="btn btn-success rounded-0" type="submit">Login</button>
                </div>
            </div>

            @if ($errors->has('username') || $errors->has('password'))
                <div class="errors text-danger py-3 text-center">Incorrect username or password entered!</div>
            @endif

        </form>
    </div>
</div>

<script>
  function listInit () {
    let listEl = host.parentElement.querySelector('.input-list')

    if (listEl) {
      listEl.parentElement.removeChild(listEl)
    }

    if (Object.values(hosts).length) {
      let list = `<div class="input-list position-absolute w-100 bg-light text-dark">`;
      for (let i in hosts) {
        list += `
            <div class="px-3 py-2 d-flex align-items-center justify-content-between" onmousedown="listSelect(event)">
                <span>${hosts[i]}</span>
                <span class="input-list-remove text-danger float-end" onmousedown="listRemoveItem(event)">&times;</span>
            </div>`
      }
      list += `</div>`;

      host.insertAdjacentHTML('afterend', list)
    }
  }

  function listOpen (event) {
    event.currentTarget.parentElement.classList.add('active')
  }

  function listClose (event) {
    event.currentTarget.parentElement.classList.remove('active')
  }

  function listSelect(event) {
    host.value = event.target.firstElementChild.innerText
  }

  function listRemoveItem(event) {
    event.stopPropagation()
    let hostName = event.target.parentElement.firstElementChild.innerText
    for (let i in hosts) {
      if (hosts[i] === hostName) {
        delete hosts[i]
      }
    }
    if (host.value === hostName) {
      host.value = ''
    }
    if (localStorage['EVO.HOST'] === hostName) {
      localStorage['EVO.HOST'] = ''
    }
    localStorage['EVO.HOSTS'] = JSON.stringify(hosts)
    listInit()
  }

  let host = document.querySelector('[name="host"]');
  let hosts = localStorage['EVO.HOSTS'] && JSON.parse(localStorage['EVO.HOSTS']) || {}

  host.value = localStorage['EVO.HOST'] || location.origin + '/'

  listInit()

  document.querySelector('form').addEventListener('submit', e => {
    e.preventDefault()

    console.log(e.target.querySelectorAll('.text-danger'))

    e.target.querySelectorAll('.text-danger').forEach(el => {
      el.parentElement.removeChild(el)
    })

    host.value = (new URL(host.value)).origin + '/'

    fetch(host.value + 'manager/', {
      method: 'put',
      body: JSON.stringify({
        method: 'Auth@login',
        username: e.target.username.value,
        password: e.target.password.value,
        remember: e.target.remember.value || true,
        host: e.target?.host?.value || '',
        _token: '{{ csrf_token() }}'
      }),
      headers: {
        'Cache': 'no-cache',
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      credentials: 'same-origin'
    }).then(response => response.json()).then(data => {

      if (data.success) {
        localStorage['EVO.TOKEN'] = data.token || ''

        if (e.target.remember.value) {
          if (!hosts[host.value]) {
            hosts[host.value] = host.value
          }
          localStorage['EVO.HOSTS'] = JSON.stringify(hosts)
          localStorage['EVO.HOST'] = host.value
        }

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
    }).catch(() => {
      host.parentElement.insertAdjacentHTML('beforeend',
        '<span class="text-danger text-left">Host not valid</span>')
    })
  })
</script>
</body>
</html>
