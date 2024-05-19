function clicked() {
    paymentForms.forEach(form => {
        form.classList.add('hidden');
    });

    const selectedMethod = document.querySelector('input[name="method"]:checked').value;
    document.getElementById(`${selectedMethod}-form`).classList.remove('hidden');
}
const paymentForms = document.querySelectorAll('.info-payment');
paymentForms.forEach(form => {
    form.addEventListener("onclick", clicked);
});

function submitClick(cartCountries, total) {

    document.getElementById('confirmationModal').classList.remove('hidden');
    document.getElementById('confirmationModal').style.display = 'block';

    const buyerCountry = document.getElementById('countryField').value;
    let ports = 0;
    for (let index = 0; index < cartCountries.length; index++) {
        if (cartCountries[index] !== buyerCountry){
            ports += 5;
        }
    }

    let addressShipping = document.querySelector('.modal-content');

    const portsDiv = document.createElement("p");
    portsDiv.textContent = "Ports: " + ports + "€";

    const finalPayment = document.createElement("p");
    total += ports;
    finalPayment.textContent = "Final payment: " + total  + "€";
    console.log(isNaN(finalPayment.value));
    console.log(finalPayment.value);
    console.log(ports);
    console.log(total);
    if (!isNaN(total)){
        addressShipping.insertBefore(finalPayment, addressShipping.firstChild);
        addressShipping.insertBefore(portsDiv, finalPayment );
    }

}

document.getElementById('formSubmitButton').addEventListener('click', submitClick);

document.getElementById('confirmYes').addEventListener('click', function() {
    document.getElementById('addressShipping').submit();
});

document.getElementById('confirmNo').addEventListener('click', function() {
    window.location.href = "../pages/cart_page.php";
});
