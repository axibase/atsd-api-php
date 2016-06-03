<form>
<table class="menu-table">
    <tr>
        <th>Entity Group</th>
        <th>Time Lag ( min )</th>
        <th>Time Ahead ( min )</th>
        <th>Status</th>
    </tr>
    <tr>
        <td>
            <select name="group" class="form-control" onchange="this.form.submit()">
                <option value="">select</option>
                <?php
                foreach ($groups as $group) {
                    $groupName = htmlspecialchars($group["name"]);
                    echo '<option value="' . $groupName . ((!empty($_REQUEST['group']) && $_REQUEST['group'] == $groupName) ? '" selected' : '"') . ">" . $groupName . "</option>";
                }
                ?>
            </select>
        </td>
        <td>
            <select name="lag" class="time-select form-control">
                <?php
                $timeList = array(0,1,2,3,4,5,6,7,8,9,10,15,20,40,60,180,360,720,1440);
                foreach($timeList as $i) {
                    echo "<option value='" . $i . ((isset($_REQUEST['lag']) && $_REQUEST['lag'] == $i) ? "' selected" : "'") . ">" . $i . "</option>";
                }

                ?>
            </select>
        </td>
        <td>
            <select name="ahead" class="time-select form-control">
                <?php
                for ($i = 0; $i <= 15; $i++) {
                    echo "<option value='" . $i . ((isset($_REQUEST['ahead']) && $_REQUEST['ahead'] == $i) ? "' selected" : "'") . ">" . $i . "</option>";
                }
                ?>
            </select>
        </td>
        <td>
            <select name="status" class="filter-select form-control">
                <option value="all" <?=$_REQUEST['status'] == 'all'?"selected":""?>>ALL</option>
                <option value="lagging" <?=$_REQUEST['status'] == 'lagging'?"selected":""?> class="lagging">LAGGING</option>
                <option value="ahead" <?=$_REQUEST['status'] == 'ahead'?"selected":""?> class="ahead">AHEAD</option>

            </select>
        </td>
    </tr>
</table>
</form>
