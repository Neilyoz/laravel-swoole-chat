<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>怀旧聊天室</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
  <div id="app">
    @yield('content')
  </div>

  <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
