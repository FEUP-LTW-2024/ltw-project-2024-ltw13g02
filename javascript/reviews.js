function reorderReviews() {
    let reviewOrder = document.getElementById('reviewOrder').value;
    let reviewsDiv = document.getElementById('review-list');
    let reviews = Array.from(reviewsDiv.getElementsByClassName('review'));

    if (reviewOrder === 'highest'){
        reviews.sort((a, b) => {
            let starsA = a.querySelectorAll('.fa-star').length;
            let starsB = b.querySelectorAll('.fa-star').length;
            if (starsA - starsB === 0){
                let dateA = new Date(a.querySelector('.created-at').textContent);
                let dateB = new Date(b.querySelector('.created-at').textContent);
                return dateB - dateA;
            }
            return starsB - starsA;
        });
    }else if (reviewOrder === 'lowest') {
        reviews.sort((a, b) => {
            let starsA = a.querySelectorAll('.fa-star').length;
            let starsB = b.querySelectorAll('.fa-star').length;
            if (starsA - starsB === 0){
                let dateA = new Date(a.querySelector('.created-at').textContent);
                let dateB = new Date(b.querySelector('.created-at').textContent);
                return dateB - dateA;
            }
            return starsA - starsB;
        });
    }else if (reviewOrder === 'newest') {
        reviews.sort((a, b) => {
            let dateA = new Date(a.querySelector('.created-at').textContent);
            let dateB = new Date(b.querySelector('.created-at').textContent);
            return dateB - dateA;
        });
    } else if (reviewOrder === 'oldest') {
        reviews.sort((a, b) => {
            let dateA = new Date(a.querySelector('.created-at').textContent);
            let dateB = new Date(b.querySelector('.created-at').textContent);
            return dateA - dateB;
        });
    }

    reviewsDiv.innerHTML = '';
    reviews.forEach(review => reviewsDiv.appendChild(review));
}

document.addEventListener('DOMContentLoaded', () => {
    let reviewOrder = document.getElementById('reviewOrder');
    reviewOrder.addEventListener('change', reorderReviews);
    reorderReviews();
});