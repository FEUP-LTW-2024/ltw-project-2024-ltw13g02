const searchProducts = document.querySelector("#searchbar");
const category = document.querySelector("#category");
const characteristic1 = document.querySelector("#characteristic1");
const characteristic2 = document.querySelector("#characteristic2");
const characteristic3 = document.querySelector("#characteristic3");
const condition = document.querySelector("#condition");
const minPrice = document.querySelector("#price-min");
const maxPrice = document.querySelector("#price-max");

searchProducts.addEventListener("oninput", myFunction);
category.addEventListener("oninput", myFunction);
if (characteristic1) characteristic1.addEventListener("oninput", myFunction);
if (characteristic2) characteristic2.addEventListener("oninput", myFunction);
if (characteristic3) characteristic3.addEventListener("oninput", myFunction);
condition.addEventListener("oninput", myFunction);
minPrice.addEventListener("oninput", myFunction);
maxPrice.addEventListener("oninput", myFunction);

function myFunction() {
    if ((searchProducts && category && characteristic1 && characteristic2 && characteristic3
        && condition && minPrice && maxPrice) == null) {
        document.querySelector("#Recommended").classList.add("hidden");
        document.querySelector("#search-results").classList.remove("hidden");
    }
    else {
        document.querySelector("#Recommended").classList.remove("hidden");
        document.querySelector("#search-results").classList.add("hidden");
    }

    const xhttp = new XMLHttpRequest();
    let baseUrl = 'http://localhost:9000';
    let url = new URL("/utils/showProducts.php", baseUrl);
    url.searchParams.set('search',searchProducts.value);
    url.searchParams.set('category',category.value);
    if (characteristic1) url.searchParams.set('characteristic1',characteristic1.value);
    if (characteristic2) url.searchParams.set('characteristic2',characteristic2.value);
    if (characteristic3) url.searchParams.set('characteristic3',characteristic3.value);
    url.searchParams.set('condition',condition.value);
    url.searchParams.set('minPrice',minPrice.value);
    url.searchParams.set('maxPrice',maxPrice.value);
    xhttp.open("GET", url, true);

    try {

        xhttp.send();

        xhttp.onload = function() {
            if (xhttp.status != 200) {
                alert(`Error ${xhttp.status}: ${xhttp.statusText}`);
            } else {
                document.getElementById("search-results").innerHTML = this.responseText;
            }
        };

        xhttp.onerror = function() {
            alert(`Network Error`);
        };
    } catch(err) {
        alert("Request failed");
    }

}
