<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');

?>

<?php function drawStars($stars) { 
    $filledStars = floor($stars);
    if($stars - $filledStars > 0.5)  $filledStars++;
    else if ($stars - $filledStars <= 0.5 && $stars - $filledStars > 0) $hasHalfStar = true;

    for ($i = 1; $i <= 5; $i++) {
        $filled = $i <= $filledStars;
        if ($filled) echo '<i class="fa fa-star"></i>';
        else if ($hasHalfStar) {
        echo '<i class="fa fa-star-half-o"></i>';
        $hasHalfStar = false;
        }
        else echo '<i class="fa fa-star-o"></i>';
    }
} ?>

<?php function drawUserProfile(Session $session) { ?>
    <div class="user-info">
        <?php 
        $user = $session->getUser();
        $email = $user->getEmail();
        ?>
        <h2><?php drawPhoto($session, $email);?></h2>
        <div class="info">
        <?php
          if($email != null) {
        ?>
            <h2><?php echo "Name: " . $user->name(); ?></h2>
            <a href="reviewsPage.php"><h2 id="stars" class="stars">
            <?php
              $stars = $user->getStarsFromReviews();
              drawStars($stars);
            ?>
            </h2></a>
            <h2><?php echo "Email: " . $user->getEmail(); ?></h2>
            <h2><?php echo "Phone: " . $user->getPhone(); ?></h2>
            <h2><?php echo "Country: " . $user->getCountry(); ?></h2>
            <h2><?php echo "City: " . $user->getCity(); ?></h2>
            <h2><?php echo "Address: " . $user->getAddress(); ?></h2>
            <h2><?php echo "zipCode: " . $user->getZipCode(); ?></h2>
        <?php
          }
          else {
            ?>
            <h2><?php echo "Guest\n"; ?></h2>
            <h2><?php echo "Login to announce and buy!!"; ?></h2>
            <?php
          }
        ?>
        </div>
    </div>
<?php } ?>

<?php function drawPhoto($session, $email) {
    $user = $session->getUser();
    $photo = $user->getPhoto(); 
    if($email != null) { ?>
        <div class="user-photo-container">
            <?php if ($photo == "Sem FF") { ?>
                <a href="../pages/editingProfile.php" class="user-icon-link">
                    <i class="fa fa-user fa-5x userIconPhoto"></i>
                    <a href="../pages/editingProfile.php"><i class="fa fa-pencil edit-icon fa-1x"></i></a>
                </a>
            <?php } else { ?>
                <a href="../pages/editingProfile.php" class="user-photo-link">
                    <img class="userphoto" src="../images/userProfile/<?php echo $photo; ?>" alt="Photo">
                    <a href="../pages/editingProfile.php"><i class="fa fa-pencil edit-icon fa-1x"></i></a>
                </a>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="user-photo-container">
            <a href="../pages/profilePage.php" class="user-icon-link">
            <i class="fa fa-user fa-5x userIconPhoto"></i>
            </a>
        </div>
    <?php }
 } ?>


<?php function drawEditProfile($session){ ?>
    <link rel="stylesheet" href="../css/editProfile.css"-->
    <div class="user-info">
        <div class="info">
            <?php $user = $session->getUser(); ?>
            <h2><?php echo "Editing Profile" ?></h2>
            <form id="editProfileForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?= $user->getFirstName(); ?>"><br><br>

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?= $user->getLastName(); ?>"><br><br>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?= $user->getPhone(); ?>"><br><br>
            
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?= $user->getAddress(); ?>"><br><br>
                
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
                </label><br><br>
                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?= $user->getCity(); ?>"><br><br>
                
                <label for="zipCode">Zip Code:</label>
                <input type="text" id="zipCode" name="zipCode" value="<?= $user->getZipCode(); ?>"><br><br>

                <input type="submit" value="Submit">
            </form>
        </div>
    </div> 
<?php } ?>