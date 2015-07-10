$(document).ready(function () {
    //初始化bootstrap tools
    $("body").tooltip({
        selector: '[data-toggle="tooltip"]',
        container: "body"
        }),
        $("body").popover({
        selector: '[data-toggle="popover"]',
        container: "body"
    });

    // 图片弹窗
    $('.popup-layer').magnificPopup({delegate: 'a.popup', type:'image'});

    // tabs
    $('.nav-tabs a').click(function (e) {
      e.preventDefault()
      $(this).tab('show');
    });

    // 滚动条
    $(window).scroll(function(event) {
        if($(window).scrollTop() >= 400){
            return $('.back-to-top').stop().fadeIn();
        }

        $('.back-to-top').stop().fadeOut();
    });

    // .popover自动关闭
    // TODO:有bug
    $(document).on('click', ':not(".popover, .popover *")', function(event){
        setTimeout(function(){ $('.popover').popover('hide'); }, 1);
    });

    // 左侧菜单点击
    $(document).on('click', '#sidebar-nav a', function (e) {
        var $this = $(e.target), $active;
        $this.is('a') || ($this = $this.closest('a'));

        // 折叠同伴
        // $active = $this.parent().siblings(".active");
        // $active && $active.toggleClass('active').find('> ul:visible').slideUp(200);

        if ($this.parent().hasClass('active')) {
            $this.next().slideUp(200);
            $this.find('span i').addClass('ion-ios-arrow-right').removeClass('ion-ios-arrow-down');
        } else {
            $this.next().slideDown(200);
            $this.find('span i').addClass('ion-ios-arrow-down').removeClass('ion-ios-arrow-right');
        }
        $this.parent().toggleClass('active');

        $this.next().is('ul') && e.preventDefault();

        var currentUrl = window.location.origin + window.location.pathname;
    });

    // switchery
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
      var switchery = new Switchery(html, { size: html.getAttribute('data-size') || 'default' });
    });

    /**
     * 展示左菜单
     */
    $('#sidebar-nav a').each(function(){
        var href = $(this).attr('href').replace(' ', '');
        if (href.length > 5 && window.location.href.indexOf(href) >= 0) {
            $('#sidebar-nav a').removeClass('active');

            return $(this).addClass('active');
        };
    });

    setTimeout(function(){
        $('.alert-dismissible').slideUp(300);
    }, 2500);


    // ajax 请求
    $('a[method]').each(function(){
        $(this).on('click', function(event){
            event.preventDefault();
            var $method = $(this).attr('method');
            var $url = $(this).attr('href');
            var $data = $(this).data();
            var $currentUrl = window.location.href;
            var $message = $(this).text() + '成功';

            Util.request($method, $url, $data, function(){
                success($message);
                window.location.href = $currentUrl;
            });
        });
    });
});


