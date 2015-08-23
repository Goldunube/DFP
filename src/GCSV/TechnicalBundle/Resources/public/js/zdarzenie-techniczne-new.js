$(document).ready(function()
{
    var users = 0;
    var $klient = $('#zdt_klient');
    var $oddzial = $('#zdt_oddzial');
    var $szerokoscGeo = $('#zdt_szerokoscGeo');
    var $dlugoscGeo = $('#zdt_dlugoscGeo');
    var $iptRozpoczecieData = $("#zdt_uczestnikZdarzeniaTechnicznego_0_terminy_0_rozpoczecieWizyty");
    var $iptZakonczenieData = $("#zdt_uczestnikZdarzeniaTechnicznego_0_terminy_0_zakonczenieWizyty");
    var $iptRozpoczecieDataWidget = $('#datetimepicker-start');
    var $iptZakonczenieDataWidget = $('#datetimepicker-koniec');
    var $iptUczestnikZdarzeniaTechnicznego = $('#zdt_uczestnikZdarzeniaTechnicznego_0_osoba');
    var rozpoczecieData = moment();
    var zakonczenieData = moment().add(1,'d');
    var dateTimeOptions = {
        locale: 'pl',
        useCurrent: true,
        defaultDate: moment(),
        showTodayButton: true,
        showClear: true,
        format: 'DD.MM.YYYY'
    };

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

    $iptUczestnikZdarzeniaTechnicznego.on('change',function(e){
        $('#kalendarz-container').fullCalendar('refetchEvents');
    });

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
                data: function() {return { users: $iptUczestnikZdarzeniaTechnicznego.val() }; },
                error: function() {
                    //alert('There was an error while fetching Google Calendar!');
                }
            }
        ],
        select: function(start,koniec)
        {
            var tmpDataOd   = $.fullCalendar.moment(start);
            var tmpDataDo   = $.fullCalendar.moment(koniec);
            var tmpDataDo2  = $.fullCalendar.moment(koniec).add(-1,'day');

            $('#formularz-container').modal({
                remote: Routing.generate('zaplecze_zdarzenie_techniczne_new_modal', { dataOd: tmpDataOd.format(), dataDo: tmpDataDo.format() })
            });

            $iptRozpoczecieDataWidget.data("DateTimePicker").date(tmpDataOd);
            $iptZakonczenieDataWidget.data("DateTimePicker").date(tmpDataDo2);
            $iptRozpoczecieDataWidget.data("DateTimePicker").date(tmpDataOd);
            $iptRozpoczecieData.val(tmpDataOd.format('L'));
            $iptZakonczenieData.val(tmpDataDo.format('L'));

            return false;
        },
        eventRender: function(zdarzenie, element)
        {
            if(element.hasClass('qtip-render'))
            {
                element.qtip({
                    content:
                    {
                        text: '<div class="container-fluid">\n    <div class="row">\n        <div class="col-sm-6">\n            <span class="label label-danger" style="display: block; height: 14px; width: 26px;">42</span>\n        </div>\n        <div class="col-sm-6">\n            ' + priorytet(zdarzenie.priorytet) + '\n        </div>\n    </div>\n</div> <table class="table table-condensed table-striped table-bordered">\n    <tr>\n        <th>ID</th>\n        <td>' + zdarzenie.id + '</td>\n    </tr>\n    <tr>\n        <th>Klient</th>\n        <td>' + zdarzenie.klient + '</td>\n    </tr>\n    <tr>\n        <th>Adres</th>        <td>' + zdarzenie.lokalizacja + '</td>\n    </tr>\n    <tr>\n        <th>Technik</th>\n        <td>' + zdarzenie.technik + '</td>\n    </tr>\n    <tr>\n        <th>Zlecający</th>\n        <td>' + zdarzenie.zlecajacy + '</td>\n    </tr>\n</table>\n',
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
                    window.open(Routing.generate('zdarzenie_techniczne_show', { id: zdarzenie.id }),'_blank');
                });
            }
        }
    });

    $oddzial.change(function()
    {
        var adresy = pickupLokalizacje($(html).find('#zdt_oddzial').val()).responseJSON;
        for(key in adresy)
        {
            if(adresy.hasOwnProperty(key))
            {
                var HTML = '<option value="'+ key +'">'+ adresy[key]['placowka'] +' --> ('+ adresy[key]['lokalizacja'] +')</option>';
                $lokalizacja.append(HTML);
            }
        }
    });

    function pickupLokalizacje(idOddzialu)
    {
        return $.ajax({
            url : Routing.generate('ajax_get_lokalizacje_oddzialu', { id: idOddzialu } ),
            type: "GET",
            async: false
        })
            .done(function(data) {
                return data
            })
    }

    $('[data-toggle="tooltip"]').tooltip();

    $iptRozpoczecieData.val(rozpoczecieData.format('DD.MM.YYYY'));
    $iptZakonczenieData.val(zakonczenieData.format('DD.MM.YYYY'));
    $iptRozpoczecieDataWidget.datetimepicker(dateTimeOptions);
    $iptZakonczenieDataWidget.datetimepicker(dateTimeOptions);
    $iptRozpoczecieDataWidget.data("DateTimePicker").widgetPositioning({
        horizontal: 'left'
    });
    $iptZakonczenieDataWidget.data("DateTimePicker").minDate(moment());
    $iptRozpoczecieDataWidget.on("dp.change", function (e) {
        if($iptZakonczenieDataWidget.data("DateTimePicker").date() < e.date)
        {
            $iptZakonczenieDataWidget.data("DateTimePicker")
                .minDate(e.date)
                .date(e.date);
        }else{
            $iptZakonczenieDataWidget.data("DateTimePicker")
                .minDate(e.date);
        }
        $iptRozpoczecieData.val(e.date.format('DD.MM.YYYY'));
    });
    $iptZakonczenieDataWidget.on("dp.change", function (e) {
        $iptZakonczenieData.val(e.date.add(1,'d').format('DD.MM.YYYY'));
    });
    $('select').select2();
    $('#zdt_oddzialFirmy').gcsv_autocomplete({
        url_list: Routing.generate('ajax_search_oddzial'),
        url_get: Routing.generate('ajax_get_oddzial')
    })
        .on('typeahead:selected',function($e,datum){
            $dlugoscGeo.val(datum.lng);
            $szerokoscGeo.val(datum.lat);
        })
        .on('typeahead:autocompleted',function($e,datum){
            $dlugoscGeo.val(datum.lng);
            $szerokoscGeo.val(datum.lat);
        });

    if('webkitSpeechRecognition' in window)
    {
//        alert('Twoja przeglądarka obsługuje funkcję rozpoznawania mowy! :) ');
        var recognizing = false;
        var recognition = new webkitSpeechRecognition();
        recognition.continuous = true;
        recognition.interimResults = true;

        recognition.onstart = function() {
            recognizing = true;
            $('.speech-record-btn i')
                .removeClass('fa-microphone')
                .addClass('fa-microphone-slash record-on');
        };

        recognition.onend = function() {
            recognizing = false;

            $('.speech-record-btn i')
                .removeClass('fa-microphone-slash record-on')
                .addClass('fa-microphone');
        };

        recognition.onresult = function(event) {
            var interim_transcript = '';
            for (var i = event.resultIndex; i < event.results.length; ++i) {
                if (event.results[i].isFinal) {
                    final_transcript += event.results[i][0].transcript;
                } else {
                    interim_transcript += event.results[i][0].transcript;
                }
            }
            final_transcript = capitalize(final_transcript);
            zdt_opis.innerHTML = final_transcript;
        };

        var first_char = /\S/;
        function capitalize(s) {
            return s.replace(first_char, function(m) { return m.toUpperCase(); });
        }

        $('.speech-record-btn').click(function(e) {
            e.preventDefault();

            if (recognizing) {
                recognition.stop();
                return;
            }
            final_transcript = '';
            recognition.start();
            ignore_onend = false;
        });

    }else{
//        alert('Niestety Twoja przeglądarka nie obsługuje funkcji rozpoznawania mowy! :( ');
    }
});