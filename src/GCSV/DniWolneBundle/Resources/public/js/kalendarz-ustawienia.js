$(function () {

    var $formularzContainer = $('#formularz-container');
    var $formularz = $formularzContainer.find('form[name="zdt"]');
    var $ipStart = $('#gcsv_termin_urlopu_start');
    var $iptKoniec = $('#gcsv_termin_urlopu_koniec');
    var $iptDataZgloszenia = $('#gcsv_termin_urlopu_dataZgloszenia');
    var dateTimeOptions = {
        locale: 'pl',
        useCurrent: true,
        defaultDate: moment(),
        showTodayButton: true,
        showClear: true,
        format: 'YYYY-MM-DD'
    };

    $('#lista-kalendarzy .tab-content input:not(:checked)').next().addClass('inactive');

    $('#lista-kalendarzy .tab-content').on('click','input',function() {
        $('#lista-kalendarzy .tab-content input:checked').each(function(){
            $('#lista-kalendarzy .tab-content input:checked').next().removeClass('inactive');
        });
        $('#lista-kalendarzy .tab-content input:not(:checked)').each(function(){
            $('#lista-kalendarzy .tab-content input:not(:checked)').next().addClass('inactive');
        });

        $('#kalendarz-container').fullCalendar('refetchEvents');
    });

    $('#lista-kalendarzy').on('click','.listek',function() {
        var dystans = $('#lista-kalendarzy').css('left');

        if(dystans == "auto" || dystans == "0px")
        {
            $('#lista-kalendarzy').animate({
                    left: "-280px"
                }, 1000, 'easeInQuint'
            )
        } else {
            $('#lista-kalendarzy').animate({
                    left: "0px"
                }, 1000, 'easeOutQuint'
            )
        }

    });

    $('#kalendarz-container').fullCalendar({
        googleCalendarApiKey: 'AIzaSyBqwNzZKdSkhbBAiX0xIf-dyYDeetbt7QY',
        firstDay: 1,
        weekends: true,
        allDayDefault: false,
        selectable: true,
        selectHelper: true,
        editable: true,
        theme: false,
        lang: 'pl',
        lazyFetching: true,
        selectOverlap: false,
        eventSources: [
            {
                // Kalendarz świąt polskich
                googleCalendarId: 'pl.polish#holiday@group.v.calendar.google.com',
                color: 'black',
                textColor: 'white',
                allDayDefault: true
            },
            {
                url: Routing.generate('fullcalendar_loader'),
                type: 'POST',
                // A way to add custom filters to your event listeners
                data: function() {
                    return {
                        users:  $('#lista-kalendarzy .tab-content input:checked').map(function(){ return $(this).val();}).get(),
                        filter: 'only_urlopy'
                    };
                },
                error: function() {
                    alert('There was an error while fetching Google Calendar!');
                }
            }
        ],
        eventDragStart: function(event, jsEvent, ui, view) {
            $(this).qtip("hide");
            $(this).qtip("disable");
        },
        eventDragStop: function(event, jsEvent, ui, view) {
            $(this).qtip("enable");
        },
        eventDrop: function(event, delta, revertFunc, jsEvent, ui, view)
        {
            if(event.start.hasTime() == false && event.end.hasTime() == false)
            {
                var dataOd  = $.fullCalendar.moment(event.start);
                var dataDo = $.fullCalendar.moment(event.end).subtract(1,'days');
            }else{
                var dataOd = $.fullCalendar.moment(event.start);
                var dataDo = $.fullCalendar.moment(event.end);
            }

            var terminId    = event.termin_id;

            $.ajax({
                url: Routing.generate('termin_urlopu_update', { id: terminId, dataOd: dataOd, dataDo: dataDo }),
                type: 'PUT',
                success: function() {
                    //$('#kalendarz-container').fullCalendar('refetchEvents');
                }
            });
        },
        eventResizeStart: function(event, jsEvent, ui, view) {
            $(this).qtip("hide");
            $(this).qtip("disable");
        },
        eventResizeStop: function(event, jsEvent, ui, view) {
            $(this).qtip("enable");
        },
        eventResize: function(event, delta, revertFunc, jsEvent, ui, view)
        {
            var terminId    = event.termin_id;
            if(event.start.hasTime() == false && event.end.hasTime() == false)
            {
                var dataOd  = $.fullCalendar.moment(event.start);
                var dataDo = $.fullCalendar.moment(event.end).subtract(1,'days');
            }else{
                var dataOd = $.fullCalendar.moment(event.start);
                var dataDo = $.fullCalendar.moment(event.end);
            }
            $.ajax({
                url: Routing.generate('termin_urlopu_update', { id: terminId, dataOd: dataOd, dataDo: dataDo }),
                type: 'PUT',
                success: function() {
                    //$('#kalendarz-container').fullCalendar('refetchEvents');
                }
            });
        },
        select: function(start,koniec)
        {
            if(start.hasTime() == false && koniec.hasTime() == false)
            {
                var tmpDataOd = $.fullCalendar.moment(start);
                var tmpDataDo = $.fullCalendar.moment(koniec).subtract(1,'days');
            }else{
                var tmpDataOd = $.fullCalendar.moment(start);
                var tmpDataDo = $.fullCalendar.moment(koniec);
            }

            $formularz.attr('method','POST');
            $formularz.attr('action',Routing.generate('termin_urlopu_create'));
            $formularzContainer.modal('show');

            $ipStart.val(tmpDataOd.format());
            $iptKoniec.val(tmpDataDo.format());

            return false;
        },
        eventRender: function(zdarzenie, element)
        {
            element.qtip({
                content:
                {
//                    text: '<div class="container-fluid">\n    <div class="row">\n        <div class="col-sm-6">\n            <span class="label label-danger" style="display: block; height: 14px; width: 26px;">42</span>\n        </div>\n        <div class="col-sm-6">\n            ' + priorytet(zdarzenie.priorytet) + '\n        </div>\n    </div>\n</div> <table class="table table-condensed table-striped table-bordered">\n    <tr>\n        <th>ID</th>\n        <td>' + zdarzenie.id + '</td>\n    </tr>\n    <tr>\n        <th>Klient</th>\n        <td>' + zdarzenie.klient + '</td>\n    </tr>\n    <tr>\n        <th>Adres</th>        <td>' + zdarzenie.lokalizacja + '</td>\n    </tr>\n    <tr>\n        <th>Technik</th>\n        <td>' + zdarzenie.technik + '</td>\n    </tr>\n    <tr>\n        <th>Zlecający</th>\n        <td>' + zdarzenie.zlecajacy + '</td>\n    </tr>\n</table>\n<div class="containter-fluid">\n    <div class="row">\n        <div class="col-sm-4">\n            <button type="button" class="btn btn-warning btn-xs pull-left btn-edytuj">Edytuj</button>\n        </div>\n        <div class="col-sm-4">\n             <div class="dropdown"><button type="button" data-toggle="dropdown" class="btn btn-primary btn-xs">Decyzja <span class="caret"></span></button><ul class="dropdown-menu"><li><a href="javascript: void(0);" class="btn-akceptuj">Akceptuj</a></li><li><a href="javascript: void(0);" class="btn-rezerwuj">Rezerwuj</a></li><li><a href="javascript: void(0);" class="btn-anuluj">Anuluj</a></li><li><a href="javascript: void(0);" class="btn-odrzuc">Odrzuć</a></li></ul></div>\n        </div>\n        <div class="col-sm-4">\n            <button type="button" class="btn btn-danger btn-xs btn-usun pull-right">Usuń</button>\n        </div>\n    </div>\n</div>',
                    text: qTipContentGenerator(zdarzenie.termin_id, zdarzenie.technik, zdarzenie.csrfToken),
                    title:
                        zdarzenie.title
                },
                position:
                {
                    my: 'bottom center',
                    at: 'top center'
                },
                show:
                {
                    when: 'mouseover',
                    solo: true
                },
                hide:
                {
                    fixed: true,
                    delay: 100,
                    effect: true,
                    when: 'mouseout'
                },
                style:
                {
                    tip:
                    {
                        width: 15,
                        height: 12
                    },
                    classes: 'qtip-bootstrap qtip-shadow qtip-rounded'
                },
                events:
                {
                    render: function(render_event, render_api)
                    {
                        var usunwanie = render_api.elements.content.find('.btn-usun');
                        usunwanie.bind('click', function(e)
                        {
                            var href = usunwanie.attr('href');
                            e.preventDefault();
                            $.ajax({
                                url: href,
                                type: 'DELETE',
                                success: function() {
                                    render_api.destroy();
                                    $('#kalendarz-container').fullCalendar('refetchEvents');
                                }
                            })
                        });
                    }
                }
            });
        }
    });

    function qTipContentGenerator($id,$osoba,$token)
    {
        //var $qTipContent = "<div class=\"container-fluid\"></div>\n<hr>\n<div class=\"containter-fluid\">\n    <div class=\"row\">\n        <input type=\"submit\" class=\"btn btn-danger btn-xs col-xs-2 col-xs-offset-9\" value=\"Usuń\" />\n    </div>\n</div>";
        var $qTipContent = $("<div></div>");
        var $row = "<div class=\"row\"><div class=\"col-xs-4\">__name__</div><div class=\"col-xs-8\">__value__</div></div>";
        var deleteLink = Routing.generate('zaplecze_ajax_delete_urlop', { urlopId : $id, token : $token} );
        var $deleteForm = "<hr>\n<div class=\"containter-fluid\">\n    <div class=\"row\">\n        <a href='"+deleteLink+"' class=\"btn btn-danger btn-usun btn-xs col-xs-2 col-xs-offset-9\">Usuń</a>\n    </div>\n</div>";
        var $idRow = $row
            .replace('__name__','Id')
            .replace('__value__',$id);
        var $osobaRow = $row
            .replace('__name__','Osoba')
            .replace('__value__',$osoba);
        $qTipContent
            .append($idRow)
            .append($osobaRow)
            .append($deleteForm);

        return $qTipContent;
    }

    $('#formularz-container select').select2();

    $formularzContainer.draggable({
        handle: ".modal-header"
    });

    $formularzContainer.on('submit','form[name="zdt"]',function(e) {
        e.preventDefault();

        var $form = $( this );
        var url = $form.attr('action');
        var method = $form.attr('method');
        $.ajax({
            url:    url,
            type:   method,
            data:   $form.serialize()
        }).done(function(e){
            if(e.status == 'ok')
            {
                $('#formularz-container').modal('hide');
                $('#kalendarz-container').fullCalendar('refetchEvents');
                alert(e.message);
            }else{
                alert(e.message);
            }
        })
    });

    $('.datepicker').datetimepicker(dateTimeOptions);
    $ipStart.on("dp.change", function (e) {
        if($iptKoniec.data("DateTimePicker").date() < e.date)
        {
            $iptKoniec.data("DateTimePicker")
                .minDate(e.date)
                .date(e.date);
        }else{
            $iptKoniec.data("DateTimePicker")
                .minDate(e.date);
        }
    });
    $iptDataZgloszenia.data("DateTimePicker").format('DD.MM.YYYY');
});
