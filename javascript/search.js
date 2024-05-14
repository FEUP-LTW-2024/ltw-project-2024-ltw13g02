const searchProducts = document.querySelector("#searchbar");

searchProducts.addEventListener("oninput", myFunction);

function myFunction() {
   
    if (searchProducts.value != 0) {
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
