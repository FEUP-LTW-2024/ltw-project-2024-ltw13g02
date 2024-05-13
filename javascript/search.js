const searchProducts = document.querySelector("#searchbar");

if (searchProducts) {
    searchProducts.addEventListener('input', async function() {

        const query = '../api/products.api.php?search=' + this.value;
        const response = await fetch(query);
        const products = await response.json();
        const section = document.querySelector('#search-results');
        section.innerHTML = '';

        if (this.value.length === 0) return;

        if (!products.length) {
            const error = document.createElement('h3');
            error.textContent = "There are no announcements for this search.";
            error.className = "error";
            section.appendChild(error);
            return; // Exit early
        }

        for (const product of products) {
            const div = document.createElement('div');
            div.className = "static_offer";

            fetchProductSeller(product.seller)
                .then(seller => {
                    const sellerLink = document.createElement('a');
                    sellerLink.href = '../pages/seller_page.php?user=' + seller.id;
                    sellerLink.className = "user_small_card";
                
                    const sellerImage = document.createElement('img');
                    sellerImage.className = "user_small_pfp";
                    if (seller.photo !== "Sem FF") {
                        sellerImage.src = '../images/userProfile/' + seller.photo;
                    } else {
                        const userIcon = document.createElement('i');
                        userIcon.className = "fa fa-user fa-1x user-icons";
                        sellerLink.appendChild(userIcon);
                    }
                
                    const sellerName = document.createElement('p');
                    sellerName.textContent = seller.firstName + " " + seller.lastName;
                
                    sellerLink.appendChild(sellerImage);
                    sellerLink.appendChild(sellerName);
                    div.appendChild(sellerLink);

                    const productLocation = document.createElement('h5');
                    productLocation.textContent = product.city + ", " + product.country;
                    div.appendChild(productLocation);
                })
                .catch(error => {
                    console.error('Error fetching seller info:', error);
                    // Handle error
                });

            fetchProductPhotos(product.id)
                .then(photos => {
                    const productLink = document.createElement('a');
                    productLink.href = '../pages/productPage.php?product=' + product.id;
        
                    const productImage = document.createElement('img');
                    productImage.className = "offer_img";
                    productImage.src = '../images/products/' + photos[0];
        
                    productLink.appendChild(productImage);
                    div.appendChild(productLink);
                })
                .catch(error => {
                    console.error('Error fetching product photos:', error);
                    // Handle error
                });

            const offerInfo = document.createElement('div');
            offerInfo.className = "offer_info";

            const productName = document.createElement('h4');
            productName.textContent = product.name.substring(0, 30);

            const productPrice = document.createElement('p');
            productPrice.textContent = product.price + "€";

            offerInfo.appendChild(productName);
            offerInfo.appendChild(productPrice);

            div.appendChild(offerInfo);

            section.appendChild(div);
        }
        
        async function fetchProductPhotos(productId) {
            try {
                const response = await fetch('../api/productPhotos.api.php?id=' + productId);
                const photos = await response.json();
                return photos;
            } catch (error) {
                throw error;
            }
        }

        async function fetchProductSeller(userId) {
            try {
                const response = await fetch('../api/user.api.php?id=' + userId);
                const seller = await response.json();
                return seller;
            } catch (error) {
                throw error;
            }
        }
    });
}
