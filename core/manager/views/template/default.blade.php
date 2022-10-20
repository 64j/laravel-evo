<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Document</title>
    <meta name="X-SRF-TOKEN" content="{{ csrf_token() }}">
    <script defer="defer" src="../core/manager/dist/app.js"></script>
    <link href="../core/manager/dist/app.css" rel="stylesheet">
    <script>
        localStorage['EVO.TOKEN'] = '{{ csrf_token() }}'
    </script>
</head>
<body>
<div id="app"></div>
</body>
</html>
