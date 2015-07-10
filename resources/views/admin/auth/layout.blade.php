<!DOCTYPE html>
<!--[if lte IE 6 ]>
<html class="ie ie6 lte-ie7 lte-ie8" lang="zh-CN">
<![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7 lte-ie7 lte-ie8" lang="zh-CN">
<![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8 lte-ie8" lang="zh-CN">
<![endif]-->
<!--[if IE 9 ]>
<html class="ie ie9" lang="zh-CN">
<![endif]-->
<!--[if (gt IE 9)|!(IE)]>
<!-->
<html lang="zh-CN">
  <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>登录 - 后台管理</title>
  <meta name="keywords" content="overtrue,bootstrap, bootstrap theme" />
  <meta name="description" content="a bootstrap theme made by overtrue." />
  <link rel="stylesheet" href="{{ asset('/css/bootstrap.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('/css/ionicons.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('/js/plugins/switchery/dist/switchery.min.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('/js/plugins/sweetalert/lib/sweet-alert.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('/css/app.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('/css/login.css') }}" media="screen">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="{{ asset('/plugin/html5shiv/dist/html5shiv.js') }}"></script>
  <script src="{{ asset('/plugin/respond/dest/respond.min.js') }}></script>
  <![endif]-->
</head>
<body>
  <div id="background">
    <div class="img img1"></div>
  </div>
  <div class="container full-height">
    @yield('content')
  </div>
  <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
  <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('/js/plugins/sweetalert/lib/sweet-alert.min.js') }}"></script>
  <script src="{{ asset('/js/plugins/switchery/dist/switchery.min.js') }}"></script>
  <script src="{{ asset('/js/sweetalert.util.js') }}"></script>
</body>
</html>