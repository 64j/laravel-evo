<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Document</title>
    <meta name="X-SRF-TOKEN" content="{{ csrf_token() }}">
    <script defer="defer" src="./static/app.js"></script>
    <link href="./static/app.css" rel="stylesheet">
    <script>
      localStorage['EVO.TOKEN'] = '{{ session('access_token') }}'
    </script>
</head>
<body>
<div id="app"></div>
</body>
</html>
