<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/get_from_db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/product.class.php');
require_once(__DIR__ . '/../database/chat.class.php');
require_once(__DIR__ . '/../database/change_in_db.php');

require_once(__DIR__ . '/user.tpl.php');

?>

<?php function drawProductHeader(Session $session, $idProduct) { 
    if ($_GET['chat'] != null) { 
        $chat = getChat($_GET['chat']);
        if ($chat->product == $idProduct) { ?>
            <a href="../pages/messagesPage.php?chat=<?php echo $_GET['chat'] ?>"><i class="fa fa-angle-left fa-2x chat-back-button"></i></a>
<?php   }
        else { ?>
            <a href="../pages/index.php"><i class="fa fa-angle-left fa-2x chat-back-button"></i></a>
        <?php }
    }
    else { ?>
        <a href="../pages/index.php"><i class="fa fa-angle-left fa-2x chat-back-button"></i></a>
    <?php }
} ?> 

<?php function drawProduct(Session $session, $idProduct) {
    $user = $session->getUser();
    $product = getProduct($idProduct);
    if ($user != null && $product->getSeller()->id != $user->id) {
        $user->addToRecents($idProduct);
    }
    
    $seller = $product->getSeller(); 
    $photos = $product->getPhotos(); ?>
    <div class="product-grid" id="product-grid">
        <div class="product-image-container">
            <?php if (count($photos) === 0) { ?>
                <img id="product-image" src="../images/products/no_images_big.png" alt="Photo">
            <?php } else { ?>
                <img id="product-image" src="../images/products/<?php echo $photos[0]['photo']; ?>" alt="photo">
            <?php } ?>
            <?php if (count($photos) > 1) { ?>
                <button class="prev-button" onclick="changePhoto(-1)"><i class="fa fa-angle-left fa-2x prev-icon"></i></button>
                <button class="next-button" onclick="changePhoto(1)"><i class="fa fa-angle-right fa-2x next-icon"></i></button>
            <?php } ?>
        </div>

        <div class="product-info">
            <h2 id="product-page-name"><?php echo $product->name; ?> </h2>
            <h2 id="product-page-price"><?php echo $product->price; ?> € </h2>
            <a href="../pages/seller_page.php?user=<?=$seller->id?>" class="product-page-seller"><h2 class="product-page-seller"><?php echo $seller->name(); ?> </h2></a>
            <a href="../pages/reviewsPage.php?user=<?=$seller->id?>" class="product-page-stars"><h2 class="product-page-stars stars">
                <?php
                $stars = $seller->getStarsFromReviews();
                drawStars($stars);
                ?>
            </h2></a>
            <?php
            $characteristics = $product->getCharacteristics();
            $category = $product->getCategory();
            $condition = $product->getCondition();
            ?>
            <h2 id="product-condition"> Condition: <?php echo $condition ?> </h2>
            <h2 class="product-category">Category: <?php echo $category ?> </h2>
            <div id="product-characteristics"> 
                <?php foreach ($characteristics as $c) { ?> 
                    <h2 id="product-characteristic"> <?php echo $c ?> </h2>
                <?php } ?>
            </div>
            <h2 id="product-page-description">Description: <?php echo $product->description; ?> </h2>
            <?php $user = $session->getUser();
            if($user != null){
                $chat = $user->findBuyerChat($idProduct);
                $idChat = $chat->id; 
                if($seller->id !== $user->id ){?>
                    <button id="contact" class="button"><a href="../pages/messagesPage.php?chat=<?php echo $idChat ?>">Contact me</a></button> <?php
                    $favorites = $user->getFavorites();
                    if($favorites != null && in_array($idProduct, $favorites)) { ?>
                        <a href="../actions/updateFavorites.php?product=<?=$product->id?>" id="a_favs"><i class="fa fa-heart isFav fa-2x icon" id="favs"></i></a> <?php
                    } else { ?>
                        <a href="../actions/updateFavorites.php?product=<?=$product->id?>" id="a_favs"><i class="fa fa-heart-o fa-2x icon" id="favs"></i></a> <?php
                    }
                    $shoppingCart = $user->getShoppingCart();
                    if ($product->getBuyer() === null){
                        if(in_array($idProduct, $shoppingCart) )
                        { ?>
                            <button id="remove-from-cart" class="button"><a href="../actions/updateCart.php?product=<?=$product->id?>">Take From Cart</a></button> <?php
                        } else{ ?>
                            <button id="add-to-cart" class="button"><a href="../actions/updateCart.php?product=<?=$product->id?>">Add to cart</a></button> <?php
                        }
                    }
                }
                    ?>
                <?php } 
            ?>           
        </div>
    </div>
    <script>
        let currentIndex = 0;
        let photos = <?php echo json_encode($photos); ?>;

        function changePhoto(delta) {
            currentIndex += delta;
            if (currentIndex < 0) {
                currentIndex = photos.length - 1;
            } else if (currentIndex >= photos.length) {
                currentIndex = 0;
            }
            document.getElementById('product-image').src = "../images/products/" + photos[currentIndex]['photo'];
        }
    </script>
    <?php 
    } ?>

<?php function drawNewProduct(Session $session, array $conditions, array $categories) { 
    if ($session->isLoggedIn()) { ?>
        <link rel="stylesheet" href="../css/editProfile.css">
        <div class="user-info">
            <div class="info">
                <?php $user = $session->getUser(); ?>
                <h2><?php echo "New Product" ?></h2>
                <br>
                <form id="newProductForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                    <input type="hidden" name='csrf' value="<?=$session->getCSRF()?>">
                    <label for="prodName">Product Name:</label>
                    <input type="text" id="prodName" name="prodName" required>
                    
                    <label for="prodDescription">Description:</label>
                    <input type="text" id="prodDescription" name="prodDescription" required>
                    
                    <label for="price">Price:</label>
                    <input type="text" id="price" name="price" required>
                
                    <label for="condition">Condition:</label>
                    <select id="condition" name="condition" required>
                        <option value="" disabled selected>Select Condition</option>
                        <?php foreach ($conditions as $condition) { ?>
                            <option value="<?php echo $condition['idCondition']; ?>"><?php echo htmlspecialchars($condition['condition']); ?></option>
                        <?php } ?>
                    </select>

                    <label for="category">Category:</label>
                    <select id="category" name="category" onChange="updateCharacteristics()" required>
                        <option value="" disabled selected>Select Category</option>
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?php echo $category['idCategory']; ?>"><?php echo htmlspecialchars($category['category']); ?></option>
                        <?php } ?>
                    </select>

                    <div id="characteristics">
                        <label disabled>
                            <option value="" disabled selected>Select Category First</option>
                        </label>
                    </div>
                    
                    <label name="photosProd" for="photosProd">Photos:</label>
                    <input type="file" id="photosProd" name="photosProd[]" accept="image/*" multiple>

                    <input id="submitProd" type="submit" value="Submit">
                </form>
            </div>
        </div> 
        <script>
        function updateCharacteristics() {
            const categoryId = document.getElementById('category').value;
            const characteristicsDiv = document.getElementById('characteristics');

            // Clear existing characteristics
            characteristicsDiv.innerHTML = '';

            fetch(`../actions/getCharacteristics.php?categoryId=${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(type => {
                        const label = document.createElement('label');
                        label.textContent = type.type_name;
                        characteristicsDiv.appendChild(label);

                        const select = document.createElement('select');
                        select.name = `characteristics[${type.idType}]`;
                        select.className = 'characteristic';
                        type.characteristics.forEach(characteristic => {
                            const option = document.createElement('option');
                            option.value = characteristic.idCharacteristic;
                            option.textContent = characteristic.characteristic;
                            select.appendChild(option);
                        });
                        characteristicsDiv.appendChild(select);
                    });
                });
        }

        document.getElementById('photosProd').addEventListener('change', function() {
            if (this.files.length > 5) {
                alert("You can only upload a maximum of 5 photos.");
                this.value = ""; // Clear the input
            }
        });
        </script>
    <?php } else { ?>
        <div id="info-to-user">
            <h2 class="info-to-user">You need to sign up to add a product.</h2>
        </div>
    <?php }    
} ?>


<?php function drawEditProduct(Session $session, $idProduct) {
    $user = $session->getUser();
    $product = getProduct($idProduct);
    $photos = $product->getPhotosId();
    $seller = $product->getSeller(); ?>
    <div id="edit-product-container" class="product-edit-container">
        <div class="product-grid" id="product-grid">
            <div class="product-image-container">
                <?php if (count($photos) === 0) { ?>
                    <img id="product-image" src="../images/products/no_images_big.png" alt="Photo">
                <?php } else { ?>
                    <img id="product-image" src="../images/products/<?php echo $photos[0]['photo']; ?>" alt="photo">
                <?php } ?>
                <?php if (count($photos) > 1) { ?>
                    <button class="prev-button" onclick="changePhoto(-1)"><i class="fa fa-angle-left fa-2x prev-icon"></i></button>
                    <button class="next-button" onclick="changePhoto(1)"><i class="fa fa-angle-right fa-2x next-icon"></i></button>
                <?php } ?>
            </div>

            <button class="button" onclick="document.getElementById('photo-input').click()">Add Photo</button>
            <input type="file" id="photo-input" style="display: none;" accept="image/*" onchange="uploadPhoto(this.files)">

            <form id="editing-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <div class="product-info edits">
                    <input type="hidden" name='csrf' value="<?=$session->getCSRF()?>">
                    <input type="hidden" name="product_id" value="<?php echo $idProduct; ?>">
                    
                    <h2 id="product-page-name">Title: <br><input type="text" id="product-name-input" name="prodName" value="<?php echo htmlspecialchars($product->name); ?>"></h2>
                    
                    <h2 id="product-page-price">Price: <input type="text" id="price-input" name="price" value="<?php echo htmlspecialchars(strval($product->price)); ?>"></h2>
                    
                    <a href="../pages/seller_page.php?user=<?=$seller->id?>" class="product-page-seller"><h2 class="product-page-seller"><?php echo $seller->name(); ?> </h2></a>
                    <a href="../pages/reviewsPage.php?user=<?=$seller->id?>" class="product-page-stars"><h2 class="product-page-stars stars">
                        <?php
                        $stars = $seller->getStarsFromReviews();
                        drawStars($stars);
                        ?>
                    </h2></a>
                    <?php
                    $characteristics = $product->getCharacteristics();
                    $category = $product->getCategory();
                    $condition = $product->getCondition();
                    ?>
                    <h2 id="product-condition"> Condition: <?php echo $condition ?> </h2>
                    <h2 class="product-category">Category: <?php echo $category ?> </h2>
                    <div id="product-characteristics"> 
                        <?php foreach ($characteristics as $c) { ?> 
                            <h2 id="product-characteristic"> <?php echo $c ?> </h2>
                        <?php } ?>
                    </div>
                    <div id="product-page-description">
                        <h2><label for="prodDescription">Description:</label></h2>
                        <h2><textarea id="prodDescription" name="prodDescription"><?php echo htmlspecialchars($product->description); ?></textarea></h2>
                    </div>
                    <button type="submit" class="button">Submit</button>
                </div>
            </form>
            <div class="thumbnail-container">
                <?php foreach ($photos as $index => $photo) { ?>
                    <div class="thumbnail-wrapper">
                        <img class="product-thumbnail" src="../images/products/<?php echo $photo['photo']; ?>" data-index="<?php echo $index; ?>" alt="Thumbnail">
                        <span class="delete-icon" onclick="confirmDeletePhoto(<?php echo $index; ?>)"><i class="fa fa-times fa-1x"></i></span>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>    
    <script>
        let currentIndex = 0;
        let photos = <?php echo json_encode($photos); ?>;

        function uploadPhoto(files) {
            let photo = files[0];
            let productId = "<?php echo $idProduct; ?>";
            let photosCount = <?php echo count($photos); ?>;

            // Check if the number of existing photos is less than 5
            if (photosCount >= 5) {
                alert("Limit of 5 photos reached.");
                return; // Exit the function
            }

            let formData = new FormData();
            formData.append('photo', photo);
            formData.append('product_id', productId);

            fetch('../actions/upload_photo.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Photo uploaded successfully!");
                    location.reload();
                } else {
                    alert("Failed to upload photo: " + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }


        function changePhoto(delta) {
            currentIndex += delta;
            if (currentIndex < 0) {
                currentIndex = photos.length - 1;
            } else if (currentIndex >= photos.length) {
                currentIndex = 0;
            }
            document.getElementById('product-image').src = "../images/products/" + photos[currentIndex]['photo'];
        }

        function confirmDeletePhoto(index) {
            let result = confirm("Are you sure you want to delete this photo?");
            if (result) {
                let idPhoto = photos[index]['idPhoto'];
                let productId = "<?php echo $idProduct; ?>";

                fetch('../actions/delete_photo.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        idPhoto: idPhoto,
                        product_id: productId, 
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === "Photo deleted successfully") {
                        alert("Photo deleted!");
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        }


        document.addEventListener('DOMContentLoaded', (event) => {
            const thumbnails = document.querySelectorAll('.thumbnail-wrapper');
            thumbnails.forEach((thumbnailWrapper) => {
                const deleteIcon = thumbnailWrapper.querySelector('.delete-icon');
                thumbnailWrapper.addEventListener('mouseover', () => {
                    deleteIcon.style.display = 'block';
                });
                thumbnailWrapper.addEventListener('mouseout', () => {
                    deleteIcon.style.display = 'none';
                });
            });
        });

    </script>
<?php 
} ?>
