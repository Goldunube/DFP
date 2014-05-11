$(document).ready(function()
{
    var $collectionHolder;

    var $addLink = $('<a href="#" class="add-link art-button maly zielony">Dodaj</a>');
    var $newLinkLi = $('<span style="margin-top: 10px;"></span>').append($addLink);

    var $this = $('.test');

    $collectionHolder = $this.find('div div');

    $collectionHolder.find('li').each(function() {
        addFormDeleteLink($(this));
    });

    $collectionHolder.append($newLinkLi);

    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addLink.on('click',function(e) {
        e.preventDefault();

        addForm($collectionHolder, $newLinkLi);
    });

    function addForm($collectionHolder, $newLinkLi)
    {
        var prototype = $collectionHolder.data('prototype');

        var index = $collectionHolder.data('index');

        var newForm = prototype.replace(/__name__/g, index);

        $collectionHolder.data('index', index + 1);

        var $newFormLi = $('<li class="parametr-container"></li>').append(newForm);
        $newLinkLi.before($newFormLi);

        addFormDeleteLink($newFormLi);
    }

    function addFormDeleteLink($FormLi)
    {
        var $removeForm = $('<a href="#" class="art-button maly czerwony">Usuń</a> ');

        $FormLi.append($removeForm);

        $removeForm.on('click', function(e)
        {
            e.preventDefault();

            $FormLi.remove();
        })
    }
});