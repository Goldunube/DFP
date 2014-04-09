(function($)
{
    $.fn.obslugaFormularzy = function()
    {
        var $collectionHolder;

        var $addLink = $('<a href="#" class="add-link art-button maly zielony">Dodaj</a>');
        var $newLinkLi = $('<li style="margin-top: 10px;"></li>').append($addLink);

        var $this = $(this);

        $collectionHolder = $this.find('ul');

        $collectionHolder.find('li').each(function() {
            addFormDeleteLink($(this));
        });

        $collectionHolder.append($newLinkLi);

        $collectionHolder.data('index', $collectionHolder.find(':input').length);

        $addLink.on('click',function(e) {
            e.preventDefault();

            addForm($collectionHolder, $newLinkLi);
        });

        $this.on('focusin','input[type=datetime]', function()
        {
            $(this).datetimepicker({dateFormat: "yy-mm-dd"});
        });

        function addForm($collectionHolder, $newLinkLi)
        {
            var prototype = $collectionHolder.data('prototype');

            var index = $collectionHolder.data('index');

            var newForm = prototype.replace(/__name__/g, index);

            $collectionHolder.data('index', index + 1);

            var $newFormLi = $('<li class="parametr-container"></li>').append(newForm);
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

    }

    $.fn.qTipHelper = function(options)
    {
        var $this = $(this);

        var settings = $.extend({
            ajax: false,
            przypisz_do: '',
            url: ''
        },options);

        var qTipOptionsDefaults = {
            style: {
                widget: true,
                def: false
            },
            position: {
                my: 'bottom right',
                at: 'top center',
                adjust: {
                    y: -10
                }
            },
            show: {
                event: 'click mouseover',
                solo: true
            },
            hide: {
                event: 'unfocus'
            }
        };

        if(settings.ajax == false)
        {
            $this.qtip(qTipOptionsDefaults);
        }else{
            var qTipOptions = $.extend({
                overwrite: false, // Make sure the tooltip won't be overridden once created
                content: 'Wybierz parametr!',
                show: {
                    ready: true // Show the tooltip as soon as it's bound, vital so it shows up the first time you hover!
                }
            }, qTipOptionsDefaults);

            var $helperContainer = $this.find('.'+settings.przypisz_do);
            $helperContainer.on('mouseover','select', function(event){
                $(this).qtip(qTipOptions, event);
            })
            .each(function(i) {
                $.attr(this, 'oldtitle', $.attr(this, 'title'));
                this.removeAttribute('title');
            });

            $helperContainer.on('change','select',function(){
                var idParametru = this.value;
                $(this).qtip('api').set('content.text', function(event, api){
                    $.get(settings.url,
                    {
                        id: idParametru
                    },
                    function(response)
                    {
                        if(response.code == 100 && response.success)
                        {
                            if(response.opis != null)
                            {
                                api.set('content.text', response.opis)
                            }
                        }
                    }
                    );
                });
            })

        }

    }
})(jQuery);