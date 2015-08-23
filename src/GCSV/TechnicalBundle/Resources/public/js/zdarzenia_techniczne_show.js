$(document).ready(function()
{
    var $btnUsunRecepture = $('.btn-usun-recepture');
    var $btnUsunRaport = $('.btn-usun-raport');
    var $btnUsunRaportZuzycia = $('.btn-usun');

    $('[data-toggle="tooltip"]').tooltip( { delay : { "show":1000,"hide":300 } } );

    $btnUsunRecepture.click(function()
    {
        var $row = $(this).closest('.row');
        var $rodzajDokumentuHolder = $row.find('.rodzaj-dokumentu');
        var $identyfikatorHolder = $row.find('.identyfikator span');
        var $btnContainerHolder = $row.find('.btn-container');
        var id = $row.attr('id');
        if(id.match(/rec-\d+$/))
        {
            var recId = id.substr(4);
            $.ajax({
                url: Routing.generate('receptury_soft_delete_ajax', { id: recId }),
                type: 'DELETE',
                success: function(ressponse)
                {
                    var alertClass = "";
                    if(ressponse.type == 'success')
                    {
                        alertClass = 'alert-success';
                    }else{
                        alertClass = 'alert-warning';
                    }
                    var $alertContainer = $("<div class='alert' style='display: none;'></div>");
                    $rodzajDokumentuHolder.addClass('deleted');
                    $identyfikatorHolder.addClass('deleted');
                    $btnContainerHolder.html('<span class="text-danger"><i>dokument usunięty</i></span>');
                    $alertContainer.addClass(alertClass);
                    $alertContainer.append(ressponse.msg);
                    $('#system-messages').append($alertContainer);
                    $alertContainer.slideDown(300).delay(3000).slideUp({
                        duration:   500,
                        complete:   function()
                        {
                            $alertContainer.remove();
                        }
                    });
                }
            })
        }
    });

    $btnUsunRaport.click(function()
    {
        var $row = $(this).closest('.row');
        var $rodzajDokumentuHolder = $row.find('.rodzaj-dokumentu');
        var $identyfikatorHolder = $row.find('.identyfikator span');
        var $btnContainerHolder = $row.find('.btn-container');
        var id = $row.attr('id');
        if(id.match(/rap-\d+$/))
        {
            var rapId = id.substr(4);
            $.ajax({
                url: Routing.generate('raport_techniczny_soft_delete_ajax', { id: rapId }),
                type: 'DELETE',
                success: function(ressponse)
                {
                    var alertClass = "";
                    if(ressponse.type == 'success')
                    {
                        alertClass = 'alert-success';
                    }else{
                        alertClass = 'alert-warning';
                    }
                    var $alertContainer = $("<div class='alert' style='display: none;'></div>");
                    $rodzajDokumentuHolder.addClass('deleted');
                    $identyfikatorHolder.addClass('deleted');
                    $btnContainerHolder.html('<span class="text-danger"><i>dokument usunięty</i></span>');
                    $alertContainer.addClass(alertClass);
                    $alertContainer.append(ressponse.msg);
                    $('#system-messages').append($alertContainer);
                    $alertContainer.slideDown(300).delay(3000).slideUp({
                        duration:   500,
                        complete:   function()
                        {
                            $alertContainer.remove();
                        }
                    });
                }
            })
        }
    });

    $btnUsunRaportZuzycia.click(function(e){
        e.preventDefault();
        $btnUsunRaportZuzycia.data('url', $(this).attr('href'))
        $("#usun-dialog-confirm").dialog('open');
    });

    $( "#usun-dialog-confirm" ).dialog({
        autoOpen: false,
        resizable: false,
        width:  500,
        height: 180,
        modal: true,
        buttons: {
            "Tak, usuń": function() {
                url = $btnUsunRaportZuzycia.data('url');
                $.ajax({
                    url:    url,
                    type:   "DELETE"
                }).done(function(response){
                    var $alertContainer = $("<div class='alert' style='display: none;'></div>");
                    $alertContainer.addClass('alert-success');
                    $alertContainer.append(response.message);
                    $('#system-messages').append($alertContainer);
                    $alertContainer.slideDown(300).delay(3000).slideUp({
                        duration:   500,
                        complete:   function()
                        {
                            $alertContainer.remove();
                        }
                    });
                });
                $( this ).dialog( "close" );
            },
            "Nie, rezygnuję": function() {
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

/*    uploader.on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $("#system-messages");
        if(file.error)
        {
            node.append('<div class="alert alert-danger"><span class="text-danger">'+file.error+'</span></div>');
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css('width',progress + '%');
        $('#progress').addClass('in');
    }).on('fileuploaddone', function (e, data)
    {
        $('#progress .progress-bar').css('width',0);
        $('#progress').delay( 2000 ).removeClass('in');
        //location.reload();
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            node.append('<div class="alert alert-danger"><span class="text-danger">Przesyłanie pliku zakończone niepowodzeniem.</span></div>');
        });
    });*/
});