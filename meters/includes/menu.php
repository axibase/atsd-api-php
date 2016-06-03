<div id="title">
    <b><?= $title ?></b>
</div>
<div align="right">
    User:
    <b><?= htmlspecialchars($_SESSION['user']) ?></b>
</div>
<div align="right" id="timezone">
    All times specified in <?= $request->getTimezone() ?>
</div>

<?php if ($request->getError() !== null)
    exit($request->getError());?>

<div class="menuBlocks">Meters:</div>

<?php if(empty($_SESSION['entities'])):?>
    No entities found for current user. <?exit()?>
<?php else :?>
    <div class="menuBlocks" id="menu">
        <form method="POST" action="index.php">
            <?php foreach($_SESSION['entities'] as $entity): ?>
                <input type="radio" <?=($request->getSelectedEntity() == $entity)?"checked":""?>
                       name="entity" value="<?=htmlspecialchars($entity)?>" id="<?=htmlspecialchars($entity) ?>" onchange="this.form.submit()">
                <label for="<?=htmlspecialchars($entity)?>"><?=htmlspecialchars($entity)?></label></br>
            <?php endforeach; ?>
        </form>
        <form method="POST" action="summary.php" style="padding-top: 10px">
            <input type="hidden" value="false" id="summary" name="summary"/>
            <input type="button" value="Summary" onclick="document.getElementById('summary').value = true; this.form.submit()"/>
        </form>
    </div>
<?php endif?>