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
            div.className = "static_offer_container";
        
            try {
                const seller = await fetchProductSeller(product.seller);
                const sellerLink = document.createElement('a');
                // Create seller link and append it to div
        
                const photos = await fetchProductPhotos(product.id);
                const productLink = document.createElement('a');
                // Create product link and append it to div
        
                // Create and append offer info elements
            } catch (error) {
                console.error('Error:', error);
                // Handle error
            }
        
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
