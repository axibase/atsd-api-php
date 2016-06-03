<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js"></script>
    <script type="text/javascript" src="//apps.axibase.com/chartlab/portal/JavaScript/portal_init.js"></script>
    <script type="text/javascript" src="//apps.axibase.com/chartlab/portal/JavaScript/charts.min.js"></script>
    <script type="text/javascript" src="//apps.axibase.com/chartlab/portal/JavaScript/initialize.js"></script>
    <link rel="stylesheet" type="text/css" href="//apps.axibase.com/chartlab/portal/CSS/charts.min.css"/>

    <style>
        #widget-0 {
            height: 400px;
            width: 800px;
        }

        #title-0 {
            font-size: 18px;
            font-weight: bold;
        }

        .axi-tooltip-container {
            z-index: -1
        }
    </style>
</head>
<body onload="onload()">
<p id="title-0"></p>
<div id="widget-0"></div>
</body>
<script>
    function onload() {
        onBodyLoad();
        loadWidgets('WidgetExample.config?cache=' + Date.now(), function (widgetConfigs) {
            var widget = widgetConfigs[0];
            widget.path = "WidgetExampleSeriesProxy.php";
            document.getElementById("title-0").innerHTML = widget.title;
            updateWidget(widget, "widget-0");
        });
    }

</script>
</html>
