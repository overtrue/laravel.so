$('#search_type li').bind('click', function(){
    $(this).addClass('curr').siblings().removeClass('curr');
});