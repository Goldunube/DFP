(function($)
{
    var $collectionHolder;

    var $addFiliaUzytkownikLink = $('<a href="#" class="add-filiauzytkownik-link">Dodaj</a>');
    var $newLinkLi = $('<li></li>').append($addFiliaUzytkownikLink);

    $.fn.obslugaFormularzy = function()
    {
        var $this = $(this);

        $collectionHolder = $('ul.filia-uzytkownicy');

        $collectionHolder.append($newLinkLi);

        $collectionHolder.data('index', $collectionHolder.find(':input').length);

        $addFiliaUzytkownikLink.on('click',function(e){
            e.preventDefault();

            addFiliaUzytkownikForm($collectionHolder, $newLinkLi);
        });

        $collectionHolder.find('li').each(function() {
            addFiliaUzytkownikFormDeleteLink($(this));
        });

        $this.on('focusin','input[type=datetime]', function()
        {
            $(this).datetimepicker({dateFormat: "yy-mm-dd"});
        });

        function addFiliaUzytkownikForm($collectionHolder, $newLinkLi)
        {
            var prototype = $collectionHolder.data('prototype');

            var index = $collectionHolder.data('index');

            var newForm = prototype.replace(/__name__/g, index);

            $collectionHolder.data('index', index + 1);

            var $newFormLi = $('<li></li>').append(newForm);
            $newLinkLi.before($newFormLi);

            addFiliaUzytkownikFormDeleteLink($newFormLi);
        }

        function addFiliaUzytkownikFormDeleteLink($fuFormLi)
        {
            var $removeFormA = $('<a href="#">Usuń</a> ');

            $fuFormLi.append($removeFormA);

            $removeFormA.on('click', function(e)
            {
                e.preventDefault();

                $fuFormLi.remove();
            })
        }

    }
})(jQuery);