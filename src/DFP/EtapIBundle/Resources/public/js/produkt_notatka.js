$(document).ready(function(){
    var $produktyNotatkiCont = $('#produkty-notatki-container');
    $('#utwardzacze-collection').collectionManager('<div class="row"><div class="col-sm-3"></div><div class="col-sm-3"></div><div class="col-sm-3"></div><div class="col-sm-3"></div></div>');
    $('#rozcienczalniki-collection').collectionManager('<div class="row"><div class="col-sm-5"></div><div class="col-sm-4"></div><div class="col-sm-3"></div></div>');
    $('.selectpicker').selectpicker();

    $produktyNotatkiCont.on('click','.listek',function() {
        var dystans = $produktyNotatkiCont.css('left');

        if(dystans == "auto" || dystans == "0px")
        {
            $('#produkty-notatki-container').animate({
                    left: "-80%"
                }, 1000, 'easeInQuint'
            )
        } else {
            $('#produkty-notatki-container').animate({
                    left: "0px"
                }, 1000, 'easeOutQuint'
            )
        }
    });

    $('#nowa-notatka-toggle-btn').click(function(e){
        var $wrapper = $('.produkty-notatki-wrapper');
        e.preventDefault();
        $('.notatka-nowa').toggle();
        $wrapper.animate({scrollTop: $wrapper.offset().top},1500);
    });

    $('.notatka-nowa').on('submit','form[name="dfp_produktnotatka"]', function(e) {
        e.preventDefault(e);
        var $form = $(this);
        var url = $form.attr('action');
        var method = $form.attr('method');
        $.ajax({
            url:    url,
            type:   method,
            data:   $form.serialize()
        }).done(function(resp){
            var $notatkaContainer = $('<div/>',{class:'notatka',style:'display: none;'});
            var $notatkaHeader = $('<div/>',{class:'notatka-header'});
            var $notatkaContent = $('<div/>',{class:'notatka-content'});
            $notatkaHeader.html(resp.notatka.header);
            $notatkaContent.html(resp.notatka.content);
            $notatkaContainer
                .append($notatkaHeader)
                .append($notatkaContent);
            $('.notatki-stare-container').prepend($notatkaContainer);
            $('.notatka-nowa').hide();
            $('.produkty-notatki-wrapper').animate({scrollTop: 0},1000);
            $notatkaContainer.fadeIn('slow');
        }).error(function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.message);
        })
    });

    $('#dialog-delete-confirm').dialog({
        autoOpen: false,
        resizable: false,
        height: 180,
        modal: true,
        buttons: {
            Ok: {
                text: 'Usuń',
                class: 'btn btn-xs btn-danger',
                click: function() {
                    var $btn = $(this).data('btn');
                    var $usunUrl = $btn.attr('href');

                    $( this ).dialog( "close" );
                    $.ajax({
                        url: $usunUrl,
                        type: 'DELETE'
                    }).done(function(resp){
                        $btn.closest('.notatka').remove();
                        alert(resp.msg);
                    });
                },
            },
            Cancel: {
                text: 'Zrezygnuj',
                class: 'btn btn-xs btn-primary',
                click: function() {
                    $( this ).dialog( "close" );
                }
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

    $produktyNotatkiCont.on('click','.usun-notatke',function(e)
    {
        e.preventDefault();
        $('#dialog-delete-confirm')
            .data('btn', $(this))
            .dialog('open');
    });

    tinymce.init({
        selector:'.tinymce',
        plugins: 'paste,autosave,table,charmap',
        toolbar: "styleselect | table | bold italic underline removeformat | justifyleft justifycenter justifyright justifyfull | bullist numlist | outdent indent | cut copy paste | charmap | undo redo | restoredraft",
        toolbar_items_size : 'small',
        paste_as_text: true,
        paste_data_images: false,
        browser_spellcheck : true,
        keep_styles: false,
        schema: "html5",
        visual: true,
        menubar : false,
        table_default_border: 1,
        table_default_cellpadding: 3,
        table_default_cellspacing: 0,
        entity_encoding : "raw",
        language: 'pl',
        statusbar: false,

        style_formats : [
            {title: 'Nagłówki', items: [
                {title: 'Nagłówek 1', block: 'h1'},
                {title: 'Nagłówek 2', block: 'h2'},
                {title: 'Nagłówek 3', block: 'h3'},
                {title: 'Nagłówek 4', block: 'h4'},
                {title: 'Nagłówek 5', block: 'h5'},
                {title: 'Nagłówek 6', block: 'h6'}
            ]},
            {title: 'Alignment', items: [
                {title: 'Left', icon: 'alignleft', format: "alignleft"},
                {title: 'Center', icon: 'aligncenter', format: "aligncenter"},
                {title: 'Right', icon: 'alignright', format: "alignright"},
                {title: 'Justify', icon: 'alignjustify', format: "alignjustify"}
            ]},
            {title: 'Table', items: [
                {title: 'Wzór 1', selector: 'table', classes: 'table1'}
            ]},
            {title: 'Pogrubiony', inline: 'b', icon: 'bold'},
            {title: 'Kursywa', inline: 'i', icon: 'italic'},
            {title: 'Podkre¶lenie', inline: 'span', styles : {textDecoration : 'underline'}, icon: 'underline'},
            {title: 'Indeks górny', inline: 'sup', icon: 'superscript'},
            {title: 'Indeks dolny', inline: 'sub', icon: 'subscript'},
        ]
    });
});