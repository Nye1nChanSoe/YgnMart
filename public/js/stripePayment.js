var stripe = Stripe(window.publicApiKeys.stripeKey);

/** create pre-build stripe elements like card number, card expiry ... */
var elements = stripe.elements();
var cardNumberElement = elements.create('cardNumber');
var cardExpiryElement = elements.create('cardExpiry');
var cardCvcElement = elements.create('cardCvc');

cardNumberElement.mount('#card-number');
cardExpiryElement.mount('#card-expiry-date');
cardCvcElement.mount('#card-cvc');

var form = document.getElementById('payment-form');
var submitBtn = document.getElementById('payment-submit');

/** Handle validation errors */
cardNumberElement.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if(event.error)
    {
        displayError.textContent = event.error.message;
    }
    else
    {
        displayError.textContent = "";
    }
});
cardExpiryElement.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if(event.error)
    {
        displayError.textContent = event.error.message;
    }
    else
    {
        displayError.textContent = "";
    }
});
cardCvcElement.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if(event.error)
    {
        displayError.textContent = event.error.message;
    }
    else
    {
        displayError.textContent = "";
    }
});

form.addEventListener('submit', function(event) {
    event.preventDefault();

    // TODO: add processing animation and disable the submit button to prevent multiple submissions
    submitBtn.disabled = true;

    /** retrieve card data from elements */
    var cardHolderName = document.getElementById('card-holder-name').value;
    var cardData = {
        number: cardNumberElement.value,
        expiry: cardExpiryElement.value,
        cvc: cardCvcElement.value
    };

    /** retrieve client_secret key which is unique to the individual PaymentIntent object */
    var clientSecret = document.getElementById('client-secret-key').value;
    /** confirm the payment */
    stripe.confirmCardPayment(clientSecret, {
        payment_method: {
            card: cardData,
            billing_details: {
                name: cardHolderName
            }
        }
    }).then(function(result) {
        if(result.error) 
        {
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = validationErrors[0].message;
            // errorElement.classList.add('text-red-500 text-sm');

            submitBtn.disabled = false;
        }
        else
        {

        }
    });
});