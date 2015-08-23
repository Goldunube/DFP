(function($)
{
    'use strict';
    $.fn.gcsv_autocomplete = function(options)
    {
        var settings =
        {
            url_list: '',
            url_get: '',
            nazwa: 'firma'
        };

        return this.each(function()
        {
            if(options)
            {
                $.extend(settings, options);
            }

            var $this = $(this);

            var engine = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: settings.url_list + '?term=%QUERY'
            });

            engine.initialize();

            $this.typeahead({
                minLength: 2,
                highlight: true
            },
            {
                name: settings.nazwa,
                displayKey: 'value',
                source: engine.ttAdapter(),
                templates: {
                    suggestion: function (datum) {
                        return '<p style="white-space: normal;">' + datum.value + ' <span class="text-muted small">Kod MAX: ' + datum.kodMax + '</span></p>'
                    }
                }
            });
        });
    };
})(jQuery);
