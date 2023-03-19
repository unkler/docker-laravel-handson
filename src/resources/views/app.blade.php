
<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Devide Up')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    /* Custom style */
    .header-right {
        width: calc(100% - 3.5rem);
    }
    .sidebar:hover {
        width: 16rem;
    }
    @media only screen and (min-width: 768px) {
        .header-right {
            width: calc(100% - 16rem);
        }        
    }
  </style>
</head>
<body>
  <div id="app"></div>
</body>
</html>
