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
  <title>Laravel.so 后台管理</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="keywords" content="overtrue,bootstrap, bootstrap theme" />
  <meta name="description" content="a bootstrap theme made by overtrue." />
  <link rel="stylesheet" href="{{ asset('/css/style.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('/css/ionicons.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('/js/vendor/switchery/dist/switchery.min.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('/js/vendor/sweetalert/lib/sweet-alert.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('/js/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('/js/vendor/magnific-popup/dist/magnific-popup.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('/js/vendor/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/js/vendor/select2/dist/css/select2-bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/app.css') }}" media="screen">
  @yield('css')
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="{{ asset('js/vendor/html5shiv/dist/html5shiv.js') }}"></script>
  <script src="{{ asset('js/vendor/respond/dest/respond.min.js') }}></script>
  <![endif]-->
  <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
  <script src="{{ asset('/js/vendor/underscore-min.js') }}"></script>
  <script src="{{ asset('/js/vendor/underscore.string.min.js') }}"></script>
  <script src="{{ asset('/js/admin/util.js') }}"></script>
  <script src="{{ asset('/js/vendor/validator.js/i18n/zh_CN.js') }}"></script>
  <script src="{{ asset('/js/vendor/validator.js/lib/validator.js') }}"></script>
</head>
<body>
  <header class="console-header">
    <div class="container">
      <div class="header-inner table-box">
        <div class="table-row">
          <div class="left table-cell">
            <div class="logo">
              <a href="{{ admin_url('/') }}"><h1>Laravel.so | <small>管理中心</small></h1></a>
            </div>
          </div>
          <div class="right table-cell">
            <div class="top-nav">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                          Admin
                          <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu">
                          <li>
                              <a href="{{ admin_url('user/edit/' . $global->user->id) }}">账号设置</a>
                          </li>
                          <li class="divider"></li>
                          <li>
                              <a href="{{ admin_url('auth/logout') }}">注销</a>
                          </li>
                      </ul>
                  </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <div class="container">
    <div class="console-wrapper table-box">
      <section class="console-container table-row">
        <aside class="console-sidebar-wrapper table-cell">
        @include('admin.partials.sidebar')
        </aside>
        <section class="console-content-wrapper table-cell">
          @yield('content')
        </section>
      </section>
    </div>
    <div class="console-footer">
      <div class="clearfix text-center">
        <ul class="list-unstyled list-inline">
          <li>overtrue © 2015</li>
        </ul>
        <button class="pull-right hidden-print  back-to-top" onclick="window.scrollTo(0,0)"> <i class="ion-android-arrow-dropup"></i>
        </button>
      </div>
    </div>
  </div>
  <div class="loading text-center" style="display:none">
      <div class="plus-loader">Loading...</div>
  </div>
  <script src="{{ asset('/js/vendor/bootstrap.min.js') }}"></script>
  <script src="{{ asset('/js/vendor/sweetalert/lib/sweet-alert.min.js') }}"></script>
  <script src="{{ asset('/js/vendor/switchery/dist/switchery.min.js') }}"></script>
  <script src="{{ asset('/js/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
  <script src="{{ asset('/js/vendor/bootstrap-select/dist/js/i18n/defaults-zh_CN.js') }}"></script>
  <script src="{{ asset('/js/vendor/magnific-popup/dist/jquery.magnific-popup.min.js') }}"></script>
  <script src="{{ asset('/js/vendor/select2/dist/js/select2.min.js') }}"></script>
  <script src="{{ asset('/js/vendor/select2/dist/js/i18n/zh-CN.js') }}"></script>
  <script src="{{ asset('/js/vendor/sweetalert.util.js') }}"></script>
  <script src="{{ asset('/js/admin/app.js') }}"></script>
  @yield('js')
</body>
</html>