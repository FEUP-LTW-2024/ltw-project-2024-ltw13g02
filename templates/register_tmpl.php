<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');

?>

<?php function drawRegister() { ?>
    <!DOCTYPE html>
    <html lang="en-US">
        <head>
            <title>Register</title>
            <link rel="stylesheet" href="../css/forms.css">
            <link rel="stylesheet" href="../css/style.css">

            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Didact+Gothic&display=swap" rel="stylesheet">
        </head>
        <body class="reg">
            <div class="register">
                <form action="../actions/registerAction.php" id="register" method="post" onsubmit="return validatePassword()">
                    <h1>Register</h1>
                    <label id="name" class="required">
                        <input type="text" name="name" placeholder=" Name..." required>
                    </label>
                    <label id="phone" class="required">
                        <input type="text" name="phone" placeholder=" Phone Number..." required>
                    </label>
                    <label id="email" class="required">
                        <input type="text" name="email" placeholder=" Email..." required>
                    </label>
                    <label id="password" class="required">
                        <input type="password" id="passwordInput" name="password" placeholder=" Password..." required>
                    </label>
                    <label id="confirmPassword" class="required">
                        <input type="password" id="confirmPasswordInput" name="confirmPassword" placeholder=" Confirm Password..." required>
                    </label>
                    <label id="country" class="required">
                        <select name="country" required>
                            <option></option>
                            <option value='1'>Afghanistan</option>
                            <option value='2'>Albania</option>
                            <option value='3'>Algeria</option>
                            <option value='4'>Andorra</option>
                            <option value='5'>Angola</option>
                            <option value='6'>Antigua and Barbuda</option>
                            <option value='7'>Argentina</option>
                            <option value='8'>Armenia</option>
                            <option value='9'>Australia</option>
                            <option value='10'>Austria</option>
                            <option value='11'>Azerbaijan</option>
                            <option value='12'>Bahamas</option>
                            <option value='13'>Bahrain</option>
                            <option value='14'>Bangladesh</option>
                            <option value='15'>Barbados</option>
                            <option value='16'>Belarus</option>
                            <option value='17'>Belgium</option>
                            <option value='18'>Belize</option>
                            <option value='19'>Benin</option>
                            <option value='20'>Bhutan</option>
                            <option value='21'>Bolivia</option>
                            <option value='22'>Bosnia and Herzegovina</option>
                            <option value='23'>Botswana</option>
                            <option value='24'>Brazil</option>
                            <option value='25'>Brunei</option>
                            <option value='26'>Bulgaria</option>
                            <option value='27'>Burkina Faso</option>
                            <option value='28'>Burundi</option>
                            <option value='29'>Cabo Verde</option>
                            <option value='30'>Cambodia</option>
                            <option value='31'>Cameroon</option>
                            <option value='32'>Canada</option>
                            <option value='33'>Central African Republic</option>
                            <option value='34'>Chad</option>
                            <option value='35'>Chile</option>
                            <option value='36'>China</option>
                            <option value='37'>Colombia</option>
                            <option value='38'>Comoros</option>
                            <option value='39'>Congo (Congo-Brazzaville)</option>
                            <option value='40'>Costa Rica</option>
                            <option value='41'>Croatia</option>
                            <option value='42'>Cuba</option>
                            <option value='43'>Cyprus</option>
                            <option value='44'>Czechia</option>
                            <option value='45'>Denmark</option>
                            <option value='46'>Djibouti</option>
                            <option value='47'>Dominica</option>
                            <option value='48'>Dominican Republic</option>
                            <option value='49'>Ecuador</option>
                            <option value='50'>Egypt</option>
                            <option value='51'>El Salvador</option>
                            <option value='52'>Equatorial Guinea</option>
                            <option value='53'>Eritrea</option>
                            <option value='54'>Estonia</option>
                            <option value='55'>Eswatini</option>
                            <option value='56'>Ethiopia</option>
                            <option value='57'>Fiji</option>
                            <option value='58'>Finland</option>
                            <option value='59'>France</option>
                            <option value='60'>Gabon</option>
                            <option value='61'>Gambia</option>
                            <option value='62'>Georgia</option>
                            <option value='63'>Germany</option>
                            <option value='64'>Ghana</option>
                            <option value='65'>Greece</option>
                            <option value='66'>Grenada</option>
                            <option value='67'>Guatemala</option>
                            <option value='68'>Guinea</option>
                            <option value='69'>Guinea-Bissau</option>
                            <option value='70'>Guyana</option>
                            <option value='71'>Haiti</option>
                            <option value='72'>Honduras</option>
                            <option value='73'>Hungary</option>
                            <option value='74'>Iceland</option>
                            <option value='75'>India</option>
                            <option value='76'>Indonesia</option>
                            <option value='77'>Iran</option>
                            <option value='78'>Iraq</option>
                            <option value='79'>Ireland</option>
                            <option value='80'>Israel</option>
                            <option value='81'>Italy</option>
                            <option value='82'>Jamaica</option>
                            <option value='83'>Japan</option>
                            <option value='84'>Jordan</option>
                            <option value='85'>Kazakhstan</option>
                            <option value='86'>Kenya</option>
                            <option value='87'>Kiribati</option>
                            <option value='88'>Kosovo</option>
                            <option value='89'>Kuwait</option>
                            <option value='90'>Kyrgyzstan</option>
                            <option value='91'>Laos</option>
                            <option value='92'>Latvia</option>
                            <option value='93'>Lebanon</option>
                            <option value='94'>Lesotho</option>
                            <option value='95'>Liberia</option>
                            <option value='96'>Libya</option>
                            <option value='97'>Liechtenstein</option>
                            <option value='98'>Lithuania</option>
                            <option value='99'>Luxembourg</option>
                            <option value='100'>Madagascar</option>
                            <option value='101'>Malawi</option>
                            <option value='102'>Malaysia</option>
                            <option value='103'>Maldives</option>
                            <option value='104'>Mali</option>
                            <option value='105'>Malta</option>
                            <option value='106'>Marshall Islands</option>
                            <option value='107'>Mauritania</option>
                            <option value='108'>Mauritius</option>
                            <option value='109'>Mexico</option>
                            <option value='110'>Micronesia</option>
                            <option value='111'>Moldova</option>
                            <option value='112'>Monaco</option>
                            <option value='113'>Mongolia</option>
                            <option value='114'>Montenegro</option>
                            <option value='115'>Morocco</option>
                            <option value='116'>Mozambique</option>
                            <option value='117'>Myanmar</option>
                            <option value='118'>Namibia</option>
                            <option value='119'>Nauru</option>
                            <option value='120'>Nepal</option>
                            <option value='121'>Netherlands</option>
                            <option value='122'>New Zealand</option>
                            <option value='123'>Nicaragua</option>
                            <option value='124'>Niger</option>
                            <option value='125'>Nigeria</option>
                            <option value='126'>North Korea</option>
                            <option value='127'>North Macedonia</option>
                            <option value='128'>Norway</option>
                            <option value='129'>Oman</option>
                            <option value='130'>Pakistan</option>
                            <option value='131'>Palau</option>
                            <option value='132'>Palestine</option>
                            <option value='133'>Panama</option>
                            <option value='134'>Papua New Guinea</option>
                            <option value='135'>Paraguay</option>
                            <option value='136'>Peru</option>
                            <option value='137'>Philippines</option>
                            <option value='138'>Poland</option>
                            <option value='139'>Portugal</option>
                            <option value='140'>Qatar</option>
                            <option value='141'>Romania</option>
                            <option value='142'>Russia</option>
                            <option value='143'>Rwanda</option>
                            <option value='144'>Saint Kitts and Nevis</option>
                            <option value='145'>Saint Lucia</option>
                            <option value='146'>Saint Vincent and the Grenadines</option>
                            <option value='147'>Samoa</option>
                            <option value='148'>San Marino</option>
                            <option value='149'>Sao Tome and Principe</option>
                            <option value='150'>Saudi Arabia</option>
                            <option value='151'>Senegal</option>
                            <option value='152'>Serbia</option>
                            <option value='153'>Seychelles</option>
                            <option value='154'>Sierra Leone</option>
                            <option value='155'>Singapore</option>
                            <option value='156'>Slovakia</option>
                            <option value='157'>Slovenia</option>
                            <option value='158'>Solomon Islands</option>
                            <option value='159'>Somalia</option>
                            <option value='160'>South Africa</option>
                            <option value='161'>South Korea</option>
                            <option value='162'>South Sudan</option>
                            <option value='163'>Spain</option>
                            <option value='164'>Sri Lanka</option>
                            <option value='165'>Sudan</option>
                            <option value='166'>Suriname</option>
                            <option value='167'>Sweden</option>
                            <option value='168'>Switzerland</option>
                            <option value='169'>Syria</option>
                            <option value='170'>Taiwan</option>
                            <option value='171'>Tajikistan</option>
                            <option value='172'>Tanzania</option>
                            <option value='173'>Thailand</option>
                            <option value='174'>Timor-Leste</option>
                            <option value='175'>Togo</option>
                            <option value='176'>Tonga</option>
                            <option value='177'>Trinidad and Tobago</option>
                            <option value='178'>Tunisia</option>
                            <option value='179'>Turkey</option>
                            <option value='180'>Turkmenistan</option>
                            <option value='181'>Tuvalu</option>
                            <option value='182'>Uganda</option>
                            <option value='183'>Ukraine</option>
                            <option value='184'>United Arab Emirates</option>
                            <option value='185'>United Kingdom</option>
                            <option value='186'>United States</option>
                            <option value='187'>Uruguay</option>
                            <option value='188'>Uzbekistan</option>
                            <option value='189'>Vanuatu</option>
                            <option value='190'>Vatican City</option>
                            <option value='191'>Venezuela</option>
                            <option value='192'>Vietnam</option>
                            <option value='193'>Yemen</option>
                            <option value='194'>Zambia</option>
                            <option value='195'>Zimbabwe</option>
                        </select>
                    </label>
                    <label id="city" class="required">
                        <input type="text" name="city" placeholder=" City..." required>
                    </label>
                    <label id="address" class="required">
                        <input type="text" name="address" placeholder=" Address..." required>
                    </label>
                    <label id="zipCode" class="required">
                        <input type="text" name="zipCode" placeholder=" Zip Code..." required>
                    </label>
                    <?php
                        if(ISSET($_SESSION['success'])){
                    ?>
                    <div class="alert alert-success"><?php echo $_SESSION['success']?></div>
                    <?php
                        unset($_SESSION['success']);
                        }
                    ?>
                    <button id="Bregister" type="submit">Register</button>
                    <a href="login.php"><h2 id="goToLog">I already have an account</h2></a>
                </form>
                <script>
                    function validatePassword() {
                        var password = document.getElementById("passwordInput").value;
                        var confirmPassword = document.getElementById("confirmPasswordInput").value;

                        if (password != confirmPassword) {
                            alert("Passwords do not match.");
                            return false;
                        }
                        return true;
                    }
                </script>
            </div>
        </body>
    </html>
<?php } ?>
