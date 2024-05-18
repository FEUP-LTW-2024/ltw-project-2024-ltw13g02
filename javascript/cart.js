function attachSubmitEvent() {

    let cityRegex = /^[a-zA-Z\u00C0-\u017F\s]+$/;

    let addressRegex = /^[a-z0-9A-Z\u00C0-\u017F\s]+$/;

    let zipCodeRegex = /^\d{4}-\d{3}$/;

    let submitButton = document.getElementById("addressShipping");

    if (submitButton != null) {
        submitButton.addEventListener('submit', function (event) {

        let city = document.getElementById("cityField").value;
        let address = document.getElementById("addressField").value;
        let zipCode = document.getElementById("zipcodeField").value;


        let isCityValid     = cityRegex.test(city);
        let isAddressValid  = addressRegex.test(address);
        let isZipCodeValid  = zipCodeRegex.test(zipCode);
        if (!isCityValid) {
            alert("City field is invalid.");
        } else if (!isAddressValid) {
            alert("Address field is invalid.");
        } else if (!isZipCodeValid) {
            alert("Zip code field is invalid.");
        }
        if (!isCityValid || !isAddressValid || !isZipCodeValid) {
            event.preventDefault();
        }
        
    });
    }
}

attachSubmitEvent();