    var $holderOfertyProfileSystemy;

    var $addTableLink = $('<a href="#" class="add-table-link art-button maly zielony">Dodaj System</a>');
    var $newTableLinkLi = $('<span></span>').append($addTableLink);

    var $collectionHolder;

    var $addLink = $('<a href="#" class="add-link art-button maly zielony">Dodaj</a>');
    var $newLinkLi = $('<span></span>').append($addLink);

$(document).ready(function()
{
    $holderOfertyProfileSystemy = $('#oferty-systemy-container');

    $addTableLink.on('click',function(e) {
        e.preventDefault();
        $holderOfertyProfileSystemy = $(this).closest('#oferty-systemy-container');
        $newTableLinkLi = $(this);
        $holderOfertyProfileSystemy.data('index', $holderOfertyProfileSystemy.find('table').length);
        addTableForm($holderOfertyProfileSystemy, $newTableLinkLi);
        $('.selectpicker').selectpicker();
    });

    $holderOfertyProfileSystemy.append($addTableLink);

    $collectionHolder = $('td.produkty');

    $holderOfertyProfileSystemy.on('click','.add-link',function(e) {
        e.preventDefault();

        $collectionHolder = $(this).closest('td.produkty');

        $newLinkLi = $(this).closest('span');

        $collectionHolder.data('index', $collectionHolder.find(':input').length);

        addForm($collectionHolder, $newLinkLi);

    });

    $holderOfertyProfileSystemy.on('click','.delete-link',function(e) {
        e.preventDefault();

        $formLi = $(this).closest('span.parametr-container');
        $formLi.remove();
    });

    $collectionHolder.append($newLinkLi);

    function addTableForm($collectionHolder, $newLinkLi)
    {
        var prototype = $collectionHolder.data('prototype');

        var index = $collectionHolder.data('index');

        var newForm = prototype.replace(/__name__/g, index);

        var $dodajLink = $('<span><a href="#" class="add-link art-button maly zielony">Dodaj</a></span>');

        $collectionHolder.data('index', index + 1);

        var $newFormLi = $('<table class="table"></table>').append(newForm);
        $newLinkLi.before($newFormLi);

        addTableFormDeleteLink($newFormLi);

        $newFormLi.find('td.produkty').append($dodajLink);
    }

    function addTableFormDeleteLink($FormLi)
    {
        var $removeForm = $('<a href="#" class="art-button maly czerwony" style="float:right;color:#FFFFFF;">X</a> ');

        $FormLi.find('th.system-malarski').append($removeForm);

        $removeForm.on('click', function(e)
        {
            e.preventDefault();

            $FormLi.remove();
        })
    }

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
        var $removeForm = $('<a href="#" class="delete-link art-button maly czerwony">Usuń</a> ');

        $FormLi.append($removeForm);

 /*       $removeForm.on('click', function(e)
        {
            e.preventDefault();

            $FormLi.remove();
        })*/
    }

    $('.sidebar-listek').click(function() {
        var sidebar = $(".left-toggle-sidebar");
        var pozycja = sidebar.css("left");
        sidebar.animate({left: parseInt(pozycja,10) == -512 ? "-1px" : "-512px"}, 1500, "easeInOutQuart" );
    });

    //    Confirm-Dialog
    $('#btn-anuluj').click(function(e){
        e.preventDefault();
        $('#dialog-delete-confirm')
            .dialog("open");
    });

    $('#dialog-delete-confirm').dialog({
        autoOpen: false,
        resizable: false,
        height: 300,
        width: 500,
        modal: true,
        buttons: {
            "Tak, anuluj zamówienie": function() {
                $('#form_anuluj').click();
            },
            "Nie, rezygnuje": function(event) {
                $( this ).dialog( "close" );
            }
        },
        show: {
            effect: "blind",
            duration: 500
        },
        hide: {
            effect: "blind",
            duration: 500
        },
        closeOnEscape: true
    });
});