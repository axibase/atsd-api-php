<?php
namespace axibase\atsdPHP;
require_once '../atsdPHP/HttpClient.php';
require_once '../atsdPHP/models/EntityGroups.php';


$client = new EntityGroups();
$groups = $client->findAll();
if (!isset($_REQUEST['lag']))
    $_REQUEST['lag'] = "15";
if (!isset($_REQUEST['ahead']))
    $_REQUEST['ahead'] = "1";


if (!isset($_REQUEST['status'])) {
    $_REQUEST['status'] = 'all';
}

$entities = array();
if (!empty($_REQUEST['group'])) {
    $entities = $client->findEntities($_REQUEST['group'], array("tags" => "*"));
    if($entities === false) {
        $entities = array();
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <?php require('includes/head.html'); ?>
    <script type="text/javascript" src="js/index.js"></script>
</head>
<body>

<?php require('includes/menu.php') ?>
<?php require('includes/time.php');?>


<table id="data" border="1px" class="table-striped table-bordered table-condensed sortable midtable data-table">
    <tr class="table-head">
        <th>Status</th>
        <th>Last Insert</th>
        <th>Time Lag (min:sec)</th>
        <th>Entity</th>
        <?php
        $orderedTags = array();
        foreach ($entities as $entity) {
            if (!empty($entity['tags'])) {
                foreach ($entity['tags'] as $key => $value) {
                    if (!in_array($key, $orderedTags)) {
                        $orderedTags[] = $key;
                        echo "<th>" . htmlspecialchars($key) . "</th>";
                    };
                }
            }
        }
        ?>

    </tr>
    <?php if (!empty($entities)) {
        foreach ($entities as $entity) {
            if (!$entity['enabled']) {
                continue;
            }
            echo "<tr class='data-node'>";
            echo "<td class='status'><div class='status-div'></div></td>";
            echo "<td class='time' data-time=" . (empty($entity['lastInsertDate']) ? "" : toTimestamp($entity['lastInsertDate'])) . ">" . (empty($entity['lastInsertDate']) ? "" : prepareDate($entity['lastInsertDate'])) . "</td>";

            echo "<td class='diff' sorttable_customkey='" . (empty($entity['lastInsertDate']) ? "0" : toTimestamp($entity['lastInsertDate'])) . "'>" . (empty($entity['lastInsertDate']) ? "" : getDiff($date, toTimestamp($entity['lastInsertDate']))) . "</td>";

            echo '<td><a href=javascript:redirect("' . rawurlencode($entity['name']) . '")>' . $entity['name']. '</a></td>';


            foreach ($orderedTags as $tagName) {
                if (!empty($entity['tags'][$tagName])) {
                    echo "<td>" . $entity['tags'][$tagName] . "</td>";
                } else {
                    echo "<td></td>";
                }
            }

            echo "</tr>";
        }
    }
    ?>
</table>
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
