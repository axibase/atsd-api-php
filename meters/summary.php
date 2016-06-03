<?php require_once ('includes/Request.php');
$request = new Request();
$title = "Summary Report";?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once("includes/head.php") ?>
    <script type="text/javascript" src="js/summary.js"></script>
</head>
<body onLoad="onBodyLoad();generateSummary()">

<?php include_once("includes/menu.php") ?>

<div id="data">
    <table>
        <tbody>
            <tr>
                <td><div id="summary-chart" class="widget"></div></td>
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

