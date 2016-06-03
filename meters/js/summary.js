(function (global, undefined) {

    global.generateSummary = function () {
        var colors = [ 'steelblue', 'orange', 'green', 'magenta', 'silver'];
        var metricValue = "sml.power-consumed";
        var configName = "summary.config";
        loadWidgets('conf/' + configName + '?cache=' + Date.now(), function (widgetConfigs) {
            var widget = widgetConfigs[0];
            var entities = document.getElementsByName('entity');
            var color;
            var entity;
            for (var i = 0; i < entities.length; i++) {
                if (i >= colors.length) {
                    color = 'black';
                }
                color = colors[i]
                entity = entities[i];
                var serie = getSeriesConfig({
                    metric: metricValue,
                    entity: entity.getAttribute('value'),
                    label: entity.getAttribute('value'),
                    period: '1 day',
                    serveraggregate: true,
                    statistic: 'sum',
                    color: color,
                    display: false
                });
                widget.series.push(serie);
            }
            serie = {
                value: "series.reduce(function(sum, s) {return sum + value(s.data); }, 0)",
                color: "green",
                label: "Summary Usage"
            };
            widget.series.push(serie);
            updateWidget(widget, 'summary-chart');
        });
    }
})(window);
