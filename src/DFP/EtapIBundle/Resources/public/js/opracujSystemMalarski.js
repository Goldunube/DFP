    var $collectionHolder;

    var $addLink = $('<a href="#" class="add-link art-button maly zielony">Dodaj</a>');
    var $newLinkLi = $('<span style="margin-top: 10px;"></span>').append($addLink);

$(document).ready(function()
{
    $collectionHolder = $('div.produkty');

    $addLink.on('click',function(e) {
        e.preventDefault();

        $collectionHolder = $(this).closest('div.produkty');

        $newLinkLi = $(this).closest('span');

        $collectionHolder.data('index', $collectionHolder.find(':input').length);

        addForm($collectionHolder, $newLinkLi);

    });

    $collectionHolder.append($newLinkLi);

    function addForm($collectionHolder, $newLinkLi)
    {
        var prototype = $collectionHolder.data('prototype');

        var index = $collectionHolder.data('index');

        var newForm = prototype.replace(/__name__/g, index);

        $collectionHolder.data('index', index + 1);

        var $newFormLi = $('<span class="parametr-container"></span>').append(newForm);
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