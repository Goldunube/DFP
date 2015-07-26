$(function () {
    var users = 0;

    function priorytet(stopien)
    {
        if(stopien < 0) {
            return '<span style="color: green;" class="glyphicon glyphicon-download pull-right"></span>';
        } else if (stopien > 0) {
            return '<span style="color: red;" class="glyphicon glyphicon-upload pull-right"></span>';
        } else {
            return '<span class="glyphicon glyphicon-record pull-right"></span>';
        }
    }

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

    users = $('#lista-kalendarzy .tab-content input:checked').map(function(){
        return $(this).val();
    }).get();

    $('#kalendarz-container').fullCalendar({
        googleCalendarApiKey: 'AIzaSyBqwNzZKdSkhbBAiX0xIf-dyYDeetbt7QY',
        firstDay: 1,
        weekends: false,
        allDayDefault: false,
        selectable: true,
        selectHelper: true,
        editable: false,
        theme: false,
        lang: 'pl',
        lazyFetching: true,
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
                    return { users: $('#lista-kalendarzy .tab-content input:checked').map(function(){ return $(this).val();}).get() };
                },
                error: function() {
                    //alert('There was an error while fetching Google Calendar!');
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
            var terminId    = event.termin_id;
            var dataOd      = event.start.format();
            var dataDo      = event.end.format();

            $.ajax({
                url: Routing.generate('ajax_resize_move_zdarzenie_techniczne', { terminId: terminId, dataOd: dataOd, dataDo: dataDo }),
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
            var dataOd      = event.start.format();
            var dataDo      = event.end.format();

            $.ajax({
                url: Routing.generate('ajax_resize_move_zdarzenie_techniczne', { terminId: terminId, dataOd: dataOd, dataDo: dataDo }),
                type: 'PUT',
                success: function() {
                    //$('#kalendarz-container').fullCalendar('refetchEvents');
                }
            });
        },
        select: function(start,koniec)
        {
            var tmpDataOd = $.fullCalendar.moment(start);
            var tmpDataDo = $.fullCalendar.moment(koniec);


            $('#formularz-container').modal({
                remote: Routing.generate('zaplecze_zdarzenie_techniczne_new_modal', { dataOd: tmpDataOd.format(), dataDo: tmpDataDo.format() })
            });

            $('#zdt_uczestnikZdarzeniaTechnicznego_0_terminy_0_rozpoczecieWizyty').val(tmpDataOd.format('L'));
            $('#zdt_uczestnikZdarzeniaTechnicznego_0_terminy_0_zakonczenieWizyty').val(tmpDataDo.format('L'));

            return false;
        },
        eventRender: function(zdarzenie, element)
        {
            if(element.hasClass('qtip-render'))
            {
                element.qtip({
                    content:
                    {
                        text: '<div class="container-fluid">\n    <div class="row">\n        <div class="col-sm-6">\n            <span class="label label-danger" style="display: block; height: 14px; width: 26px;">42</span>\n        </div>\n        <div class="col-sm-6">\n            ' + priorytet(zdarzenie.priorytet) + '\n        </div>\n    </div>\n</div> <table class="table table-condensed table-striped table-bordered">\n    <tr>\n        <th>ID</th>\n        <td>' + zdarzenie.termin_id + '</td>\n    </tr>\n    <tr>\n        <th>Klient</th>\n        <td>' + zdarzenie.klient + '</td>\n    </tr>\n    <tr>\n        <th>Adres</th>        <td>' + zdarzenie.lokalizacja + '</td>\n    </tr>\n    <tr>\n        <th>Technik</th>\n        <td>' + zdarzenie.technik + '</td>\n    </tr>\n    <tr>\n        <th>Zlecający</th>\n        <td>' + zdarzenie.zlecajacy + '</td>\n    </tr>\n</table>\n',
                        title:
                            zdarzenie.rodzaj
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
                            var edycja = render_api.elements.content.find('.btn-edytuj');
                            var usunwanie = render_api.elements.content.find('.btn-usun');

                            edycja.bind('click', function()
                            {
                                render_api.hide();
                                $('#formularz-container').modal({
                                    remote: Routing.generate('zaplecze_zdarzenie_techniczne_edit_modal', { id: zdarzenie.id })
                                });
                            });

                            usunwanie.bind('click', function()
                            {
                                $.ajax({
                                    url: Routing.generate('ajax_delete_zdarzenie_techniczne', { id: zdarzenie.id }),
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

                element.bind('dblclick', function()
                {
                    window.open(Routing.generate('zdarzenie_techniczne_show', { id: zdarzenie.id }));
                });
            }
        }
    });
});
