$(function () {

    // 过滤空搜索
    $('#search-form').submit(function () {
        if($('input[name="keywords"]', $(this)).val().trim() == ''){
            return false;
        }
        return true;
    });


    // 滚动条滚动时间
    var scrollTime = 600;

    // Contact Me 按钮事件：去到底部
    $('#contact-me').click(function () {
        var $obj = $('html, body');
        $obj.animate({ scrollTop: $obj.height() }, scrollTime);
        return false;
    });

    // 返回顶部
    $('<div class="back-to-top" title="返回顶部"></div>').appendTo('body').css({
            display: 'none',
            position: 'fixed',
            left: ($('body').width() - 80) + 'px',
            top: ($(window).height() - 100 ) + 'px'

        // 添加点击事件
        }).click(function () {
            $('html, body').animate({ scrollTop: 0 }, scrollTime);
        });

        // 添加窗口滚动事件
        $(window).scroll(function () {
            var scrollTop = $(this).scrollTop();

            //IE6定位
            if (window.ActiveXObject && !window.XMLHttpRequest) {
                var top = scrollTop + ($(window).height() * 0.9);
                $('.back-to-top').css('top', top + 'px');
            }

            if(scrollTop > 100){
                $('.back-to-top').show();
            }
            else{
                $('.back-to-top').hide();
            }
        });
})
