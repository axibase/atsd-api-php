//Math.random();//to debug

$(function () {
    var usedMetricsSet = new Array();
    var widgetsStore = [];
    var entity = $('#menu select option:selected').val();
    var availableMetrics = $('#availableMetrics').data('metrics')|| "";

    var iterator = [0];
    var firstBlock = [true];

    window.history.pushState(null, null, window.location.search.replace('&refresh=true', ''));

    var configNames = [
        "operating_system.config",
        "scollector.windows.config",
        "scollector.linux.config",
        "collectd.config",
        "vmware_vm.config",
        "scollector_mssql.config"
    ];

    applyPerformanceWidgets();

    applyPropertiesWidgets();

    applyConfigurationWidget();

    setUpEvents();

    function applyPerformanceWidgets() {
        if (configNames[iterator[0]] == null) {
            return;
        }
        loadWidgets('conf/' + configNames[iterator[0]] + '?cache=' + Date.now(), function (widgetConfigs) {
            var headAdded = false;
            htmlToAppend = "";
            $.each(widgetConfigs, function (confIndex, configNode) {
                id = makeid();
                metricsSet = new Array();
                $.each(configNode.series, function (seriesIndex, serie) {
                    actualMetric = serie.metric == null ? configNode.metric : serie.metric;
                    serie.entity = entity;
                    if (availableMetrics.search(" " + actualMetric + " ") != -1) {
                        metricsSet.push(actualMetric);
                    }
                });
                if (metricsSet.length > 0 && !existInArray(metricsSet, usedMetricsSet, configNode.title)) {
                    if (!headAdded) {
                        html = '<div class="panel panel-default">' +
                        '<div class="panel-heading">' +
                        '<b>' + portalConfig.title + '</b>' +
                        '</div>' +
                        '<div class="panel-collapse" style="display: [[DISPLAY]]"></div>' +
                        '</div>';
                        if(firstBlock[0]) {
                            html = html.replace('[[DISPLAY]]', 'block');
                            firstBlock = [false];
                        } else {
                            html = html.replace('[[DISPLAY]]', 'none');
                        }
                        $('#performanceTab').append(html);
                        headAdded = true;
                    }
                    usedMetricsSet.push(metricsSet);
                    forkedConfig = jQuery.extend(true, {}, configNode);
                    widgetsStore[id] = forkedConfig;
                    $('#performanceTab .panel-collapse').last().append(
                            '<p class="widget-title"><b>' + configNode.title + '</b></p>' +
                            '<div id="' + id + '" class="widget"></div>'
                    );
                    updateWidget(forkedConfig, id);
                }
            });
            $('#performanceTab').append('</div></div>');
            iterator = [++iterator[0]];
            applyPerformanceWidgets();
        });
    }

    function applyPropertiesWidgets() {
        $.each($('#propertiesTab').find('.panel-default'), function(i, panelDefault) {
            type = $(panelDefault).find('.panel-heading').text().trim();
            id = $(panelDefault).find('.widget').attr('id');
            $.each(confWidgetConfig.properties, function (j, node) {
                node.entity = entity;
                node.type = type
            });
            forkedConfig = jQuery.extend(true, {}, confWidgetConfig);
            widgetsStore[id] = forkedConfig;
            updateWidget(forkedConfig, id);
        });
    }

    function applyConfigurationWidget() {
        id = 'confWidget';
        $.each(confWidgetConfig.properties, function (j, node) {
            node.entity = entity;
            node.type = '$entity_tags'
        });
        forkedConfig = jQuery.extend(true, {}, confWidgetConfig);
        widgetsStore[id] = forkedConfig;
        updateWidget(forkedConfig, id);
    }



    function setUpEvents() {

        $('#tabs a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
            $('#tabField').val($(this).data('tag'));
            window.history.pushState(null, null, window.location.search.replace(/tab=[^&]*/, "tab=" + $(this).data('tag'))); //modify url for actual tab.
            widgetUpdateTrigger();
        });

        $(document).on('click', '.panel-heading', function () {
            panelCollapse = $(this).parent().find('.panel-collapse');
            if (panelCollapse.is(':visible')) {
                panelCollapse.hide();
            } else {
                panelCollapse.show();
            }
            widgetUpdateTrigger();
        });

        $('#user').on('click', function() {
            $('#form').append('<input type="hidden" name="refresh" value="true" />');
            $('#form').submit();
        });

        $('#tabs li').filter('.active').children().first().trigger('click');
    }

    function widgetUpdateTrigger() {
        $.each($('.widget'), function (widgetIndex, widgetNode) {
            updateWidget(widgetsStore[widgetNode.id], widgetNode.id);
        });
    }


});

function existInArray(needly, haystack, title) {
    var founded = false;
    $.each(haystack, function (id, array) {
        if (needly.sort().toString().localeCompare(array.sort().toString()) === 0) {
            founded = true;
            return false;
        }
    });
    return founded;
}

function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for (var i = 0; i < 8; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
}





