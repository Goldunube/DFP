    var $holderOfertyProdukty;

    var $addTableLink = $('<a href="#" class="add-table-link art-button maly zielony">Dodaj produkt</a>');
    var $newTableLinkLi = $('<span></span>').append($addTableLink);

$(document).ready(function()
{
    $holderOfertyProdukty = $('#oferty-produkty-container');

    $addTableLink.on('click',function(e) {
        e.preventDefault();
        $newTableLinkLi = $(this);
        $holderOfertyProdukty.data('index', $holderOfertyProdukty.find('tr.produkt').length);
        addTableForm($holderOfertyProdukty, $newTableLinkLi);
        $('.selectpicker').selectpicker();
    });

    $('#oferty-systemy-container').append($addTableLink);

    $holderOfertyProdukty.on('click','.produkt-del',function(e)
    {
        e.preventDefault();
        $holderProdukt = $(this).closest('tr.produkt');
        $holderProduktInfo = $holderProdukt.next('tr');
        $holderProduktInfo.remove();
        $holderProdukt.remove();
    });

    $holderOfertyProdukty.on('click','.cena-add',function(e)
    {
        e.preventDefault();
        $holderCeny = $(this).closest('tbody');
        var prototype = $holderCeny.data('prototype');
        $holderCeny.data('index',$holderCeny.find('tr.cena').length);
        var indeks = $holderCeny.data('index');
        var nowaCena = prototype.replace(/__cena_name__/g, indeks);
        $holderCeny.data('index', indeks + 1);
        $holderCeny.append(nowaCena);
//        alert($holderCeny.data('index'));
    });

    $holderOfertyProdukty.on('click','.cena-del',function(e) {
        e.preventDefault();

        $formLi = $(this).closest('tr.cena');
        $formLi.remove();
    });

    function addTableForm($collectionHolder)
    {
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index');
        var newForm = prototype.replace(/__name__/g, index);
        $collectionHolder.data('index', index + 1);
        $collectionHolder.append(newForm);
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