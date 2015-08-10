<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
    <head>
        @section('description', trans('layouts.meta_description'))
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta property="og:title" content="" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="" />
        <meta property="og:image" content="" />
        <meta property="og:site_name" content="" />
        <meta property="og:description" content="@yield('description')" />
        <meta name="keywords" content="@yield('keywords', trans('layouts.meta_keywords'))">
        <meta name="description" content="@yield('description')">
        <meta name="author" content="{{ trans('layouts.meta_author') }}">
        <meta name="google-site-verification" content="e2Aj3BCstJLN5LImLRFGVMC0CiDz0FpLL05xDvrOEdw" />
        <meta name="baidu_union_verify" content="a18b9ce01c21e05e1c6da22902081f79">
        <title> @yield('title') | {{ trim(trans('layouts.site_title')) }} </title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        @yield('styles')
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.2.0/respond.js"></script>
        <![endif]-->
    </head>

    <body>
        <div id="wrap">
            @include('partials.navigation')
            @yield('content')
        </div>

        @include('partials.footer')

        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', '{{ config("services.google.analytics_property_id") }}', 'auto');
        ga('send', 'pageview');

        </script>

        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        @yield('scripts')
        <script>
            $(function(){
                var $threads = [];

                $('[data-duoshuo-thread-id]').each(function($item){
                    $threads.push($(this).data('duoshuoThreadId'));
                });

                if ($threads.length) {
                    $.ajax({
                        url: '/tricks/comment-counts',
                        type: 'GET',
                        dataType: 'json',
                        data: {threads: $threads},
                    })
                    .done(function($response) {
                        var $counts = $response;

                        for($thread in $counts){
                            $('[data-duoshuo-thread-id='+$thread+']').text($counts[$thread]);
                        }
                    });
                };

            });
        </script>
        <script>
        var _hmt = _hmt || [];
        (function() {
          var hm = document.createElement("script");
          hm.src = "//hm.baidu.com/hm.js?c991c4719704e5daa62d276d3ca04136";
          var s = document.getElementsByTagName("script")[0];
          s.parentNode.insertBefore(hm, s);
        })();
        </script>

    </body>
</html>
