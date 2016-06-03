(function(global, undefined){
    var metric = "sml.power-consumed";
    global.getReport = function(entity, date, interval) {
    location.href = "CsvGenerator.php?entity=" + entity + "&endDate=" + date + "&period=" + interval + "&metric=" + metric;
};

global.generateWidgets = function(entity){
    if(entity == "") {
        return;
    }
    var cEntity = entity;
    var configName = "entity.config";
    loadWidgets('conf/' + configName + '?cache=' + Date.now(), function (widgetConfigs) {
        var daily = widgetConfigs[0];
        var current = widgetConfigs[1];
        var monthly = widgetConfigs[2];


        for(var j = 0; j < daily.series.length; j++) {
            daily.series[j].entity = cEntity;
            daily.series[j].metric = metric;
        }
        for(var j = 0; j < current.series.length; j++) {
            current.series[j].entity = cEntity;
            current.series[j].metric = metric;
        }
        for(var j = 0; j < monthly.series.length; j++) {
            monthly.series[j].entity = cEntity;
            monthly.series[j].metric = metric;
        }

        updateWidget(daily, 'daily-usage');
        updateWidget(current, 'current-usage');
        updateWidget(monthly, 'monthly-usage');
    });










};

})(window);
