function clicked() {
    const paymentForms = document.querySelectorAll('.info-payment');

    paymentForms.forEach(form => {
        form.classList.add('hidden');
    });

    const selectedMethod = document.querySelector('input[name="method"]:checked').value;
    document.getElementById(`${selectedMethod}-form`).classList.remove('hidden');
}

document.addEventListener('DOMContentLoaded', clicked);

function submitClick(event) {
    event.preventDefault();
    document.getElementById('confirmationModal').classList.remove('hidden');
    document.getElementById('confirmationModal').style.display = 'block';
}

document.getElementById('formSubmitButton').addEventListener('click', submitClick);

document.getElementById('confirmYes').addEventListener('click', function() {
    // User confirmed checkout
    document.getElementById('addressShipping').submit();
});

document.getElementById('confirmNo').addEventListener('click', function() {
    // User wants to return to cart
    window.location.href = "../pages/cart_page.php";
});
