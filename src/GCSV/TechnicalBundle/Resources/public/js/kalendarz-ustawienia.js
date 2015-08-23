$(function () {
    var users = 0;

    var $formularzContainer = $('#formularz-container');
    var $formularz = $formularzContainer.find('form[name="zdt"]');
    var $tabLokalizacjaLink = $('a[href="#tab-zdt-lokalizacja"]');
    var $iptAdresSearch = $('#address-search-input');
    var $btnCodeAddress = $('#code-address');
    var $selTechnik = $('#fm-technik');
    var $iptOpis = $('#fm-opis');
    var $iptRozpoczecieWizyty = $('#fm-termin-rozpoczecie');
    var $iptZakonczenieWizyty = $('#fm-termin-zakonczenie');
    var $iptDlugoscGeo = $('#fm-dlugoscGeo');
    var $iptSzerokoscGeo = $('#fm-szerokoscGeo');
    var $iptKlient = $('#zdt_oddzialFirmy');
    var $iptRodzaj = $('#fm-rodzaj');
    var $iptZlecajacy = $('#fm-zlecajacy');
    var $radioState = $('input[name="zdt[status]"]');

    var geocoder;
    var map;
    var destinationMarker;
    var technikMarker;

    function initialize() {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(51.918, 19.134);
        var mapOptions = {
            zoom: 6,
            center: latlng
        };

        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        google.maps.event.addListener(map, 'click', function(event) {
            placeMarker(event.latLng);
        });
    }

    function placeMarker(location)
    {
        if(destinationMarker)
        {
            destinationMarker.setAnimation(google.maps.Animation.DROP);
            destinationMarker.setPosition(location);
        }else{
            destinationMarker = new google.maps.Marker({
                map: map,
                draggable: false,
                position: location,
                animation: google.maps.Animation.DROP
            });
        }

        map.setCenter(location);
        $('#fm-dlugoscGeo').val(location.lng());
        $('#fm-szerokoscGeo').val(location.lat());
        //map.setZoom(12);
    }

    function placeTechnikMarker(location)
    {
        if(technikMarker)
        {
            technikMarker.setAnimation(google.maps.Animation.DROP);
            technikMarker.setPosition(location);
        }else{
            technikMarker = new google.maps.Marker({
                map: map,
                draggable: false,
                position: location,
                icon: '/images/man.png',
                animation: google.maps.Animation.DROP
            });
        }
    }

    function codeAddress(address)
    {
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK)
            {
                var location = results[0].geometry.location;
                map.setCenter(location);
                placeMarker(location);
                $('#fm-dlugoscGeo').val(location.lng());
                $('#fm-szerokoscGeo').val(location.lat());
            } else {
                alert('Usługa geolokacji zakończyła się niepowodzeniem z powodu: ' + status);
            }
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);

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
        weekends: true,
        allDayDefault: false,
        selectable: true,
        selectHelper: true,
        editable: true,
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
            if(event.typZdarzenia == "zdarzenie-dt")
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
            }
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
            if(event.typZdarzenia == "zdarzenie-dt")
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
            }
        },
        select: function(start,koniec)
        {
            var tmpDataOd = $.fullCalendar.moment(start);
            var tmpDataDo = $.fullCalendar.moment(koniec);

            $formularz.attr('method','POST');
            $formularz.attr('action',Routing.generate('zaplecze_zdarzenie_techniczne_create_modal'));
            $formularzContainer.modal('show');

            $('#fm-termin-rozpoczecie').val(tmpDataOd.format());
            $('#fm-termin-zakonczenie').val(tmpDataDo.format());

            return false;
        },
        eventRender: function(zdarzenie, element)
        {
            if(zdarzenie.typZdarzenia == "zdarzenie-dt")
            {
                element.qtip({
                    content:
                    {
                        text: '<div class="container-fluid">\n    <div class="row">\n        <div class="col-sm-6">\n            <span class="label label-danger" style="display: block; height: 14px; width: 26px;">42</span>\n        </div>\n        <div class="col-sm-6">\n</div>\n    </div>\n</div> <table class="table table-condensed table-striped table-bordered">\n    <tr>\n        <th>ID</th>\n        <td>' + zdarzenie.termin_id + '</td>\n    </tr>\n    <tr>\n        <th>Klient</th>\n        <td>' + zdarzenie.klient + '</td>\n    </tr>\n    <tr>\n        <th>Adres</th>        <td>' + zdarzenie.lokalizacja + '</td>\n    </tr>\n    <tr>\n        <th>Technik</th>\n        <td>' + zdarzenie.technik + '</td>\n    </tr>\n    <tr>\n        <th>Zlecający</th>\n        <td>' + zdarzenie.zlecajacy + '</td>\n    </tr>\n</table>\n<div class="containter-fluid">\n    <div class="row">\n        <div class="col-sm-4">\n            <button type="button" class="btn btn-warning btn-xs pull-left btn-edytuj">Edytuj</button>\n        </div>\n        <div class="col-sm-4">\n             <div class="dropdown"><button type="button" data-toggle="dropdown" class="btn btn-primary btn-xs">Decyzja <span class="caret"></span></button><ul class="dropdown-menu"><li><a href="javascript: void(0);" class="btn-akceptuj">Akceptuj</a></li><li><a href="javascript: void(0);" class="btn-rezerwuj">Rezerwuj</a></li><li><a href="javascript: void(0);" class="btn-anuluj">Anuluj</a></li><li><a href="javascript: void(0);" class="btn-odrzuc">Odrzuć</a></li></ul></div>\n        </div>\n        <div class="col-sm-4">\n            <button type="button" class="btn btn-danger btn-xs btn-usun pull-right">Usuń</button>\n        </div>\n    </div>\n</div>',
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
//                        event: false,
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
                            var akceptuj = render_api.elements.content.find('.btn-akceptuj');
                            var rezerwuj = render_api.elements.content.find('.btn-rezerwuj');
                            var odrzuc = render_api.elements.content.find('.btn-odrzuc');
                            var anuluj = render_api.elements.content.find('.btn-anuluj');

                            akceptuj.on('click', function()
                            {
                                $.ajax({
                                    url: Routing.generate('ajax_decyzja_zdarzenie_techniczne', { id: zdarzenie.termin_id, status: 2 }),
                                    type: 'PUT',
                                    success: function() {
                                        $('#kalendarz-container').fullCalendar('refetchEvents');
                                    }
                                })
                            });

                            rezerwuj.on('click', function()
                            {
                                $.ajax({
                                    url: Routing.generate('ajax_decyzja_zdarzenie_techniczne', { id: zdarzenie.termin_id, status: 1 }),
                                    type: 'PUT',
                                    success: function() {
                                        $('#kalendarz-container').fullCalendar('refetchEvents');
                                    }
                                })
                            });

                            odrzuc.on('click', function()
                            {
                                $.ajax({
                                    url: Routing.generate('ajax_decyzja_zdarzenie_techniczne', { id: zdarzenie.termin_id, status: -1 }),
                                    type: 'PUT',
                                    success: function() {
                                        $('#kalendarz-container').fullCalendar('refetchEvents');
                                    }
                                })
                            });

                            anuluj.on('click', function()
                            {
                                $.ajax({
                                    url: Routing.generate('ajax_decyzja_zdarzenie_techniczne', { id: zdarzenie.termin_id, status: -2 }),
                                    type: 'PUT',
                                    success: function() {
                                        $('#kalendarz-container').fullCalendar('refetchEvents');
                                    }
                                })
                            });

                            edycja.bind('click', function()
                            {
                                $.ajax({
                                    url: Routing.generate('zaplecze_zdarzenie_techniczne_get_data_ajax', { id: zdarzenie.id }),
                                    success: function(resp) {
                                        $iptOpis.val(resp.opis);
                                        $iptRozpoczecieWizyty.val(resp.rozpoczecie);
                                        $iptZakonczenieWizyty.val(resp.zakonczenie);
                                        $iptDlugoscGeo.val(resp.dlugosc);
                                        $iptSzerokoscGeo.val(resp.szerokosc);
                                        $iptKlient.val(resp.klient);
                                        $selTechnik.val(resp.technik).trigger('change');
                                        $iptRodzaj.val(resp.rodzaj).trigger('change');
                                        $iptZlecajacy.val(resp.zlecajacy).trigger('change');
                                        $radioState.filter('[value = '+resp.status+']')
                                            .attr('checked',true)
                                            .closest('label')
                                            .button('toggle');

                                        var location = new google.maps.LatLng(resp.szerokosc,resp.dlugosc);
                                        placeMarker(location);
                                    }
                                });
                                $formularz.attr('method','PUT');
                                $formularz.attr('action',Routing.generate('zaplecze_zdarzenie_techniczne_update_modal', { id: zdarzenie.id }));
                                $formularzContainer.modal('show');
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

    //$formularzContainer.on('load.bs.modal', function(e) {
        $('#formularz-container select').select2();
        $iptKlient.gcsv_autocomplete({
            url_list: Routing.generate('ajax_search_oddzial'),
            url_get: Routing.generate('ajax_get_oddzial')
        })
            .on('typeahead:selected',function($e,datum){
                if(datum.lat == null || datum.lng == null)
                {
                    geocoder.geocode( { 'address': datum.adres}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK)
                        {
                            var location = results[0].geometry.location;
                            $('#fm-dlugoscGeo').val(location.lng());
                            $('#fm-szerokoscGeo').val(location.lat());
                            map.setCenter(location);
                            placeMarker(location);
                        }
                    });
                }else{
                    var location = new google.maps.LatLng(datum.lat,datum.lng);
                    placeMarker(location);
                    $('#fm-dlugoscGeo').val(location.lng());
                    $('#fm-szerokoscGeo').val(location.lat());
                }
            })
            .on('typeahead:autocompleted',function($e,datum){
                if(datum.lat == null || datum.lng == null)
                {
                    geocoder.geocode( { 'address': datum.adres}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK)
                        {
                            var location = results[0].geometry.location;
                            $('#fm-dlugoscGeo').val(location.lng());
                            $('#fm-szerokoscGeo').val(location.lat());
                            map.setCenter(location);
                            placeMarker(location);
                        }
                    });
                }else{
                    var location = new google.maps.LatLng(datum.lat,datum.lng);
                    placeMarker(location);
                    $('#fm-dlugoscGeo').val(location.lng());
                    $('#fm-szerokoscGeo').val(location.lat());
                }
            })
    //});

    $formularzContainer.on('hidden.bs.modal', function() {
        $(this).removeData('bs.modal');
    });

    $tabLokalizacjaLink.on('shown.bs.tab', function() {
        google.maps.event.trigger(map, 'resize');
        map.setCenter(new google.maps.LatLng(51.918, 19.134));
    });

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
        }).done(function(){
            $('#formularz-container').modal('hide');
            $('#kalendarz-container').fullCalendar('refetchEvents');
        })
    });

    $btnCodeAddress.on('click',function(e)
    {
        e.preventDefault();
        codeAddress($iptAdresSearch.val());
    });

/*    $selTechnik.on('change',function()
    {
        var $idTechnika = $selTechnik.val();
        $.ajax({
            url: Routing.generate('ajax_get_lat_lang_uzytkownika', { 'id' : $idTechnika }),
            success: function(response)
            {
                var latlng = new google.maps.LatLng(response.lat, response.lng);
                placeTechnikMarker(latlng);
            }
        });
    });*/
});
