<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/core/manager/resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="/core/manager/resources/css/fontawesome.min.css">
    <link rel="stylesheet" href="/core/manager/resources/css/main.css">
    <script src="/core/manager/resources/js/vue.global.js"></script>
    <script defer type="module" src="/core/manager/resources/js/main.js"></script>
</head>
<body>
<div id="app" class="app d-flex h-100 flex-column overflow-hidden">
    <div class="mainMenu position-relative col flex-grow-0 d-flex justify-content-between bg-dark">
        @include('manager::partials.main-menu', ['items' => $mainMenu])
    </div>
    <div class="col flex-grow-1">
        <div class="d-flex h-100">
            <div class="col-auto d-flex flex-column bg-dark">
                @include('manager::partials.tree')
            </div>
            <div class="col d-flex flex-column bg-light">
                @include('manager::partials.frame')
            </div>
        </div>
    </div>
</div>
</body>
</html>
