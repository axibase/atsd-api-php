<?php
namespace axibase\atsdPHP;
require_once '../atsdPHP/HttpClient.php';
require_once '../atsdPHP/models/Entities.php';
$client = new Entities();
if (empty($_REQUEST['entity'])) {
    exit("Entity is not specified");
}
$metrics = $client->findMetrics($_REQUEST['entity'], array("useEntityInsertTime" => true));
if($metrics === false) {
    $metrics = array();
}

if (!isset($_REQUEST['lag']))
    $_REQUEST['lag'] = "99999999";
if (!isset($_REQUEST['ahead']))
    $_REQUEST['ahead'] = "99999999";


if (!isset($_REQUEST['status'])) {
    $_REQUEST['status'] = 'all';
}

function prepareTimestamp($timestamp) {
    $date = new \DateTime();
    $date->setTimestamp($timestamp/1000);
    return $date->format('Y-m-d H:i:s');
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require('includes/head.html'); ?>
    <script type="text/javascript" src="js/metrics.js"></script>
</head>
<body>
<h4 class="metricTitle">Entity: <?= $_REQUEST['entity'] ?></h4>
<?php require('includes/time.php');?>
<table id="data" border="1px" class="table-striped table-bordered table-condensed sortable midtable data-table">
    <tr class="table-head">
        <th>Status</th>
        <th>Last Insert</th>
        <th>Time Lag (min:sec)</th>
        <th>Metric Name</th>

    </tr>
    <?php if (!empty($metrics)) {
        foreach ($metrics as $metric) {
            echo "<tr class='data-node'>";
            echo "<td class='status'><div class='status-div'></div></td>";
            echo "<td class='time' data-time=" . (empty($metric['lastInsertTime']) ? "" : $metric['lastInsertTime']) . ">" . (empty($metric['lastInsertTime']) ? "" : prepareTimestamp($metric['lastInsertTime'])) . "</td>";
            echo "<td class='diff' sorttable_customkey='" . (empty($metric['lastInsertTime']) ? "0" : $metric['lastInsertTime']) . "'>" . (empty($metric['lastInsertTime']) ? "" : getDiff($date, $metric['lastInsertTime'])) . "</td>";
            echo "<td>" . $metric['name'] . "</td>";
            echo "</tr>";
        }
    }
    ?>
</table>
<input type="hidden" id="lag" value="<?=$_REQUEST['lag']?>"/>
<input type="hidden" id="ahead" value="<?=$_REQUEST['ahead']?>"/>
<!-- Start of StatCounter Code -->
<script type="text/javascript">
        var sc_project=10201325; 
        var sc_security="473703da"; 
        var sc_invisible=1;
        var scJsHost = (("https:" == document.location.protocol) ? "https://secure." : "http://www.");
 document.write("<sc"+"ript type='text/javascript' src='" +scJsHost +"statcounter.com/counter/counter.js'></"+"script>");
</script>
<noscript>
 <div class="statcounter">
  <a title="web analytics" href="http://statcounter.com/">
   <img class="statcounter" src="http://c.statcounter.com/10201325/0/473703da/1/" alt="web analytics" />
  </a>
 </div>
</noscript>
<!-- End of StatCounter Code -->
</body>
</html>
