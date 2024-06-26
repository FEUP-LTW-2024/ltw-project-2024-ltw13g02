<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');

?>

<?php function drawEditProfile($session){ ?>
    <link rel="stylesheet" href="../css/editProfile.css">
    <div class="user-info">
        <div class="info">
            <?php $user = $session->getUser(); ?>
            <h2><?php echo "Editing Profile" ?></h2>
            <a href="../pages/confirmLogin.php" class="change-buttons">Change Email or Password</a>
            <br><br>
            <form id="editProfileForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <input type="hidden" name='csrf' value="<?=$session->getCSRF()?>">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?= $user->firstName; ?>">

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?= $user->lastName; ?>">

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?= $user->phone; ?>">
            
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?= $user->userAddress; ?>">
                
                <label for="country">Country: </label>
                <label id="country" class="required"> 
                    <select name="country" required>
                        <?php
                        $currentCountry = $user->getCountry();

                        echo "<option value='$currentCountry'>$currentCountry</option>";

                        $countries = array(
                            "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria",
                            "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan",
                            "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cabo Verde", "Cambodia",
                            "Cameroon", "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo (Congo-Brazzaville)", "Costa Rica",
                            "Croatia", "Cuba", "Cyprus", "Czechia", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt",
                            "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini", "Ethiopia", "Fiji", "Finland", "France", "Gabon",
                            "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana",
                            "Haiti", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel",
                            "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kosovo", "Kuwait", "Kyrgyzstan",
                            "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Madagascar",
                            "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia",
                            "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal",
                            "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea", "North Macedonia", "Norway", "Oman", "Pakistan",
                            "Palau", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar",
                            "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe",
                            "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia",
                            "South Africa", "South Korea", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland", "Syria",
                            "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey",
                            "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Uzbekistan", "Vanuatu",
                            "Vatican City", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
                        );

                        foreach ($countries as $country) {
                            if ($country === $currentCountry) continue;
                            echo "<option value='$country'>$country</option>";
                        }
                        ?>
                    </select>
                </label>
                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?= $user->city; ?>">
                
                <label for="zipCode">Zip Code:</label>
                <input type="text" id="zipCode" name="zipCode" value="<?= $user->zipCode; ?>">

                <label for="photo">Photo:</label>
                <input type="file" name="photo" id="photo">
                

                <input id="submit" type="submit" value="Submit">
            </form>
        </div>
    </div> 
<?php } ?>

<?php function drawConfirmLogin() { ?>
    <link rel="stylesheet" href="../css/editProfile.css">
    <div class="user-info">
        <div class="info">
            <form id = "login" action="../actions/confirmLoginAction.php" method="post">
                <h2><?php echo "Confirm Login" ?></h2>
                <label id="email" class="required"></label>
                <input type="text" name="email" placeholder=" Email..." required>
                
                <label id="password" class="required"></label>
                <input type="password" name="password" placeholder=" Password..." required>
                <br>
                <?php
                    if(ISSET($_SESSION['error'])){
                ?>
                        <div class="alert alert-danger"><?php echo $_SESSION['error']?></div>
                <?php
                        unset($_SESSION['error']);
                    }
                ?>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
<?php } ?>

<?php function drawChangeEmail($session) { ?>
    <link rel="stylesheet" href="../css/editProfile.css">
    <div class="user-info">
        <div class="info">
            <?php $user = $session->getUser(); ?>
            <h2><?php echo "Change Email" ?></h2>
            <form id="editChangeEmail" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <input type="hidden" name='csrf' value="<?=$session->getCSRF()?>">
                <label id="email" class="required">New Email</label>
                <input type="text" id="email" name="email" value="<?= $user->email; ?>" required>
                
                <br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div> 
<?php } ?>

<?php function drawChangePassword($session) { ?>
    <link rel="stylesheet" href="../css/editProfile.css">
    <div class="user-info">
        <div class="info">
            <?php $user = $session->getUser(); ?>
            <h2><?php echo "Change Password" ?></h2>
            <form id="editChangePassword" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validatePassword()">
                <input type="hidden" name='csrf' value="<?=$session->getCSRF()?>">
                <label for="newPassword" class="required">New Password:</label>
                <input type="password" id="newPassword" name="newPassword" placeholder="New Password..." required>
                <br>
                <label for="confirmPassword" class="required">Confirm New Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm New Password..." required>
                <br>
                <input type="submit" value="Submit">
            </form>
            <script>
                function validatePassword() {
                    let newPassword = document.getElementById("newPassword").value;
                    let confirmPassword = document.getElementById("confirmPassword").value;

                    if (newPassword !== confirmPassword) {
                        alert("Passwords do not match.");
                        return false;
                    }
                    return true;
                }
            </script>
        </div>
    </div> 
<?php } ?>


<?php function drawChangeEmailOrPassword($session){ ?>
    <link rel="stylesheet" href="../css/editProfile.css">
    <div class="user-info">
        <div class="info">
            <?php $user = $session->getUser(); ?>
            <h2><?php echo "Editing Profile" ?></h2>
            <a href="../pages/changeEmail.php" class="change-buttons">Change Email</a>
            <br><br>
            <a href="../pages/changePassword.php" class="change-buttons">Change Password</a>
        </div>
    </div> 
<?php } ?>