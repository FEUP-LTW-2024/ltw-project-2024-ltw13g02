<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../sessions/session.php');
require_once(__DIR__ . '/../database/get_from_db.php');

?>

<?php function drawAdmin(Session $session) { 
    $result = getCategories();
    $categories = "";
    foreach($result as $row) {
        $categories .= "<option value='" . $row['idCategory'] . "'>" . $row['category'] . "</option>";
    }
    $result = getTypes();
    $types = "";
    $i = 1;
    foreach($result as $row) {
        $types .= "<option value='$i'>" . $row['type_name'] . "</option>";
        $i++;
    }
    ?>
    <div id="admin">
        <form id = "adminGive" action="../actions/giveAdminStatus.php" method="post">
            <h2>Give the admin status to a user:</h2>
            <label id="userGiveEmail" class="required">
                <input type="text" name="email" placeholder=" User email..." required>
            </label>
            <button id="adminB" class="button" type="submit">Submit</button>
        </form>
        <form id = "adminRemove" action="../actions/removeAdminStatus.php" method="post">
            <h2>Remove the admin status to a user:</h2>
            <label id="userRemoveEmail" class="required">
                <input type="text" name="email" placeholder=" User email..." required>
            </label>
            <button id="adminB" class="button" type="submit">Submit</button>
        </form>
        <form id = "newCategory" action="../actions/newCategory.php" method="post">
            <h2>New Category:</h2>
            <label id="newC" class="required">
                <input type="text" name="category" placeholder=" Category..." required>
            </label>
            <button id="categoryB" class="button" type="submit">Submit</button>
        </form>
        <form id = "newType" action="../actions/newType.php" method="post">
            <h2>New Type of Characteristic:</h2>
            <label id="newC" class="required">
                <select name="category" required>
                    <option> Category of the Type...</option>
                    <?php echo $categories; ?>
                </select>
            </label>
            <label id="newT" class="required">
                <input type="text" name="type" placeholder=" Type..." required>
            </label>
            <button id="typeB" class="button" type="submit">Submit</button>
        </form>
        <form id = "newCharacteristic" action="../actions/newCharacteristic.php" method="post">
            <h2>New Characteristic:</h2>
            <label id="characteristicType" class="required">
                <select name="type" required>
                    <option> Type of the characteristic...</option>
                </select>
            </label>
            <label id="newChar" class="required">
                <input type="text" name="characteristic" placeholder=" Characteristic..." required>
            </label>
            <button id="characteristicB" class="button" type="submit">Submit</button>
        </form>
    </div>
<?php } ?>