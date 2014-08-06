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

    };

    $.fn.qTipHelper = function(options)
    {
        var $this = $(this);

        var settings = $.extend({
            ajax: false,
            przypisz_do: '',
            url: ''
        },options);

        var qTipOptionsDefaults = {
            prerender: true,
            style: {
                widget: true,
                def: false
            },
            position: {
                my: 'bottom center',
                at: 'top center',
                adjust: {
                    y: -10
                },
                effect: false
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
            var qTipOptions = $.extend( {},qTipOptionsDefaults,{
                overwrite: false,
                content: {
                    text: function(event, api)
                    {
                        api.tooltip.css('visibility', 'hidden');

                        return $.ajax({
                            url: settings.url,
                            type: 'GET',
                            dataType: 'json',
                            data: {
                                id: $(this).val()
                            }
                        })
                        .then(function(content)
                        {
                            return content.opis === null ? api.hide() : content.opis ;
                        },function(xhr, status, error){
                            api.set('content.text', status + ': ' + error)
                        })
                        .done(function() {
                            api.tooltip.css('visibility', '');
                        });
                    }
                },
                show: {
                    ready: true
                },
                position: {
                }
            });

            var $helperContainer = $this.find('.'+settings.przypisz_do);

            $helperContainer.on('mouseover','select', function(event){
                $(this).qtip(qTipOptions, event);
            });

            $helperContainer.on('change','select',function(event){
                $(this).qtip('destroy', true);
                var tooltip = $(this).qtip(qTipOptions, event);
                var api = tooltip.qtip('api');
                api.show();
            })
            .each(function() {
                $.attr(this, 'oldtitle', $.attr(this, 'title'));
                this.removeAttribute('title');
            });

        }

    }

    $.fn.collectionManager = function()
    {
        var $collectionHolder;

        var $addBtn = $('<button class="btn btn-success">Dodaj</button>');
        var $newRow = $('<div class="row"><div class="col-sm-3"></div><div class="col-sm-3"></div><div class="col-sm-3"></div><div class="col-sm-3"></div></div>');
        $newRow.children().last().append($addBtn);

        var $this = $(this);
//        var $addBtn = $this.find('button.btn-success');
//        var $newRow = $this.children()[0];

        $collectionHolder = $this;

        $collectionHolder.find('div.row').each(function() {
            addFormDeleteBtn($(this));
        });

        $collectionHolder.append($newRow);

        $collectionHolder.data('index', $collectionHolder.children().length);

        $addBtn.on('click',function(e) {
            e.preventDefault();

            addForm($collectionHolder, $newRow);
            $('.selectpicker').selectpicker();
        });

        function addForm($collectionHolder, $addBtn)
        {
            var prototype = $collectionHolder.data('prototype');

            var index = $collectionHolder.data('index');

            var newForm = prototype.replace(/__name__/g, index);

            $collectionHolder.data('index', index + 1);

            var $newForm = $collectionHolder.append(newForm);
//            $newForm.children().children().last().append($addBtn);
            addFormDeleteBtn($newForm.find('div.row').last());
            $newForm.after($addBtn);


        }

        function addFormDeleteBtn($Form)
        {
            var $delBtn = $('<button class="btn btn-danger">Usuń</button>');

            $Form.children().last().append($delBtn);

            $delBtn.on('click', function(e)
            {
                e.preventDefault();

                $Form.remove();
            })
        }
    };

})(jQuery);