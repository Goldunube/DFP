(function($)
{
    $.fn.obslugaFormularzy = function()
    {
        var $collectionHolder;

        var $addLink = $('<a href="#" class="add-link">Dodaj</a>');
        var $newLinkLi = $('<li></li>').append($addLink);

        var $this = $(this);

        $collectionHolder = $this.find('ul');

        $collectionHolder.find('li').each(function() {
            addFormDeleteLink($(this));
        });

        $collectionHolder.append($newLinkLi);

        $collectionHolder.data('index', $collectionHolder.find(':input').length);

        $addLink.on('click',function(e) {
            e.preventDefault();

            addForm($collectionHolder, $newLinkLi);
        });

        $this.on('focusin','input[type=datetime]', function()
        {
            $(this).datetimepicker({dateFormat: "yy-mm-dd"});
        });

        function addForm($collectionHolder, $newLinkLi)
        {
            var prototype = $collectionHolder.data('prototype');

            var index = $collectionHolder.data('index');

            var newForm = prototype.replace(/__name__/g, index);

            $collectionHolder.data('index', index + 1);

            var $newFormLi = $('<li></li>').append(newForm);
            $newLinkLi.before($newFormLi);

            addFormDeleteLink($newFormLi);
        }

        function addFormDeleteLink($FormLi)
        {
            var $removeForm = $('<a href="#">Usuń</a> ');

            $FormLi.append($removeForm);

            $removeForm.on('click', function(e)
            {
                e.preventDefault();

                $FormLi.remove();
            })
        }

    }
})(jQuery);