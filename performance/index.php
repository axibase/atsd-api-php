<?php require_once ('includes/Request.php');
$request = new Request();
$title = "Performance Viewer";
$currentTab = $request->currentTab;?>
<!DOCTYPE html>
<html>
<head>
    <title>Performance Application</title>
    <?php include_once("includes/head.php") ?>

</head>
<body onLoad="onBodyLoad()">

<div class="head">
    <div align="left" class="title">
        <b><?= $title ?></b>
    </div>
    <div align="right" id="user">
        User:
        <b><?= htmlspecialchars($_SESSION['user']) ?></b>
    </div>
</div>


<table class="contentTable">
    <tr>
        <td>
            <?php include_once("includes/menu.php") ?>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <ul id="tabs" class="nav nav-tabs">
                            <li <?= $currentTab=="perf"?'class="active"':''?>)">
                                <a href="#performanceTab" data-tag="perf">Performance</a>
                            </li>
                            <li <?= $currentTab=="prop"?'class="active"':''?>)">
                                <a href="#propertiesTab" data-tag="prop">Properties</a>
                            </li>
                            <li <?= $currentTab=="conf"?'class="active"':''?>)">
                                <a href="#configurationTab" data-tag="conf">Configuration</a>
                            </li>

                        </ul>
                    </td>
                </tr>
                <tr>

                    <td>
                        <?php if(is_null($request->selectedEntity)):?>
                            Entity is not selected. <?exit()?>
                        <?php elseif(!in_array($request->selectedEntity, $_SESSION['entities'])) :?>
                            <div class="title">
                                <b><?=$_SESSION['user']?></b> denied access to entity <b><?=$request->selectedEntity?></b>
                            </div>
                        <?php else :?>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane in <?= $currentTab=="perf"?'active':''?>" id="performanceTab">

                                </div>
                                <div role="tabpanel" class="tab-pane in <?= $currentTab=="prop"?'active':''?>" id="propertiesTab">
                                    <?php foreach($request->propertyTypes as $propertyType): ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <b><?=htmlspecialchars($propertyType)?></b>
                                            </div>
                                            <div id="collapse-<?=htmlspecialchars($propertyType)?>" class="panel-collapse" style="display:none">
                                                <div id="propWidget-<?=htmlspecialchars($propertyType)?>" class="widget"></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div role="tabpanel" class="tab-pane in <?= $currentTab=="conf"?'active':''?>" id="configurationTab">
                                    <div id="confWidget" class="widget"></div>
                                </div>
                            </div>
                        <?php endif?>
                    </td>

                </tr>

            </table>
        </td>
    </tr>
</table>
<input type="hidden" data-metrics="<?php foreach($request->metrics as $metric) {echo htmlspecialchars($metric) . " ";}?>" id="availableMetrics"/>
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
