<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Document</title>
    <script defer="defer" src="./static/app.js"></script>
    <link href="./static/app.css" rel="stylesheet">
    <script>
      localStorage['EVO.HOST'] = location.href.replace(location.hash, '').replace('/manager/', '/')
      localStorage['EVO.TOKEN'] = '{{ session('_token') }}'
    </script>
</head>
<body>
<div id="app"></div>
</body>
</html>
