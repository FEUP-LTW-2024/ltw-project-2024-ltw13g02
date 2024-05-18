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

function submitClick() {
    event.preventDefault();
    document.getElementById('confirmationModal').classList.remove('hidden');
    document.getElementById('confirmationModal').style.display = 'block';
}

document.getElementById('formSubmitButton').addEventListener('click', submitClick);

document.getElementById('confirmYes').addEventListener('click', function() {
    document.getElementById('addressShipping').submit();
});

document.getElementById('confirmNo').addEventListener('click', function() {
    window.location.href = "../pages/cart_page.php";
});
