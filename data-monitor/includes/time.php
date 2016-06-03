<?php
$date = new DateTime();
function prepareDate($isoDate) {
    $date = new \DateTime();
    $date->setTimestamp(strtotime($isoDate));
    return $date->format('Y-m-d H:i:s');
}

function toTimestamp($isoDate) {
	return strtotime($isoDate) * 1000;
}

function getDiff(\DateTime $date, $timestamp) {
    $diff = $date->getTimestamp() - $timestamp/1000;
    $diffStr = intval($diff/60) . ":" . (abs($diff%60)>=10?abs($diff%60):"0" . abs($diff%60));
    return $diffStr;
    $nDate = new \DateTime();
    $nDate->setTimestamp($timestamp / 1000);
    $diff = $date->diff($nDate);
//    return $diff->format('%d days %H:%i:%s');
    if($diff > 0) {
        $diffStr = "-";
    } else {
        $diffStr = "";
    }
    $diffStr .= ($diff->d*24*60+$diff->h*60+$diff->i) . ":" . $diff->s;
    return $diffStr;
}
?>


<div id="timezone">
    All times specified in <b><?=date_default_timezone_get()?></b></br>
    <div align="right"><?=$date->format('Y-m-d H:i:s')?></div>
    <input type="hidden" id="time-timestamp" data-timestamp="<?=$date->getTimestamp()?>"/>
</div>
