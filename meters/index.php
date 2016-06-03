<?php require_once ('includes/Request.php');
$request = new Request();
$title = "Meter Report";?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once("includes/head.php") ?>
    <script type="text/javascript" src="js/entity.js"></script>
</head>
<body onLoad="onBodyLoad();generateWidgets('<?=$request->getSelectedEntity()?>')">

<?php include_once("includes/menu.php") ?>

<div id="data">
    <table>
        <tbody>
        <tr>
            <td>
                <div id="daily-usage" class="widget"></div>
            </td>
            <td>
                <div id="current-usage" class="widget"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div id="monthly-usage" class="widget"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php if ($request->getSelectedEntity()) : ?>
                    <div>
                        <h4>Daily Reports:</h4>
                        <?php for ($i = 0; $i < 7; $i++) : ?>
                            <a href="javascript:getReport('<?= $request->getSelectedEntity() ?>','<?= $request->formatEndTime("day", $i, $view = false) ?>','1-DAY')"><?= $request->formatEndTime('day', $i, $view = true) ?></a></br>
                        <?php endfor; ?>
                    </div>
                    <div>
                        <h4>Weekly Reports:</h4>
                        <?php for ($i = 0; $i < 4; $i++) : ?>
                            <a href="javascript:getReport('<?= $request->getSelectedEntity() ?>','<?= $request->formatEndTime("week", $i, $view = false) ?>','1-WEEK')"><?= $request->formatEndTime('week', $i, $view = true) ?></a></br>
                        <?php endfor; ?>
                    </div>
                    <div>
                        <h4>Monthly Reports:</h4>
                        <?php for ($i = 0; $i < 3; $i++) : ?>
                            <a href="javascript:getReport('<?= $request->getSelectedEntity() ?>','<?= $request->formatEndTime("month", $i, $view = false) ?>','1-MONTH')"><?= $request->formatEndTime('month', $i, $view = true) ?></a></br>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>
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
