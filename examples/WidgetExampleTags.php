<?php
namespace axibase\atsdPHP;
require_once '../atsdPHP/models/Entities.php';
require_once '../atsdPHP/HttpClient.php';
?>
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
        .title {
            font-size: 18px;
            font-weight: bold;
        }

        .tags-table {
            width: 785px;
            margin-left: 15px;
        }

        .axi-tooltip-container {
            z-index: -1
        }

        table, th, td {
            border-collapse: collapse;
            padding: 4px;

        }
    </style>
</head>
<body onload="onload()">

<form>
    <select name="entity" onchange="this.form.submit()">
        <option value="">choose entity</option>
        <?php
        $file_handle = fopen("WidgetExampleEntities.list", "r");
        while (!feof($file_handle)) {
            $line = htmlentities(trim(fgets($file_handle)));
            echo "<option value=" . $line . ((!empty($_REQUEST['entity'])&&$_REQUEST['entity'] == $line)?" selected":"") . ">" . $line . "</option>";
        }
        fclose($file_handle);
        ?>
    </select>

</form>
<?php if(!empty($_REQUEST['entity'])): ?>

<p id="title-0" class="title"></p>
<div id="widget-0"></div>

<p class="title">Tags:</p>
<table border="1px" class="tags-table">
    <tr>
        <th>name</th>
        <th>value</th>
    </tr>
    <?php
        $client = new Entities();
        $entityData = $client->find($_REQUEST['entity']);
        foreach($entityData['tags'] as $key => $value) {
            echo "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
        }
    ?>
</table>
</body>
<script>
    function onload() {
        onBodyLoad();
        loadWidgets('WidgetExample.config?cache=' + Date.now(), function (widgetConfigs) {
            var widget = widgetConfigs[0];
            widget.path = "WidgetExampleSeriesProxy.php";

            var series = widget.series[0];
            series.entity = "<?=$_REQUEST['entity']?>";
            document.getElementById("title-0").innerHTML = widget.title;
            updateWidget(widget, "widget-0");
        });
    }

</script>
<?php else: ?>
    <p id="title-0">Entity not selected</p>
<?php endif?>
</html>
