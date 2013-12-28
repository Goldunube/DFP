(function($)
{
    $.fn.obslugaTabel = function()
    {
        var $this = $(this);

        $this.find('tbody tr').css('cursor','pointer');

        $this.on('click','tbody tr',function(e)
        {
            e.preventDefault();
            e.stopPropagation();

            var hrefShow = $(e.currentTarget).find("th:first a").attr("href");
            window.location.href=hrefShow;
        })
    }
})(jQuery);
