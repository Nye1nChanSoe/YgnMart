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

// Listen for changes in the card elements and enable/disable the submit button accordingly
// To prevent submitting without card information

        
/** Handle validation errors */
var displayError = document.getElementById('card-errors');
cardNumberElement.addEventListener('change', function(event) {
    if(event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = "";
    }
});
cardExpiryElement.addEventListener('change', function(event) {
    if(event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = "";
    }
});
cardCvcElement.addEventListener('change', function(event) {
    if(event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = "";
    }
});


form.addEventListener('submit', function(event) {
    event.preventDefault();

    // TODO: add processing animation and disable the submit button to prevent multiple submissions
    submitBtn.disabled = true;

    /** retrieve client_secret key which is unique to the individual PaymentIntent object */
    var clientSecret = document.getElementById('client-secret-key').value;

    /** confirm the payment */
    stripe.confirmCardPayment(clientSecret, {
        payment_method: {
            card: cardNumberElement,
            billing_details: {
                name: window.user.name,
                email: window.user.email,
                phone: window.user.phone_number,
            }
        },
    })
    .then(function(result) {
        if(result.error) 
        {
            console.log(result.error.message);
            displayError.textContent = result.error.message;

            submitBtn.disabled = false;
        }
        else
        {
            // Payment confirmed, send AJAX request to server-side to update checkout and order status
            console.log(result.paymentIntent);

            var paymentIntentId = result.paymentIntent.id;
            console.log('/checkout/' + paymentIntentId);

            // send AJAX request to update the record of checkouts table's status column
            fetch('/checkout/' + paymentIntentId, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',

                    // The CSRF TOKEN is embedded in the meta tag 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    payment_intent_id: paymentIntentId 
                })
            }).then(function(response) {
                if(!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            }).then(function(data) {
                console.log(data);  // handle the response data as needed

                // send another AJAX request to create a new order
                fetch('/orders', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
    
                        // The CSRF TOKEN is embedded in the meta tag 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        payment_intent_id: paymentIntentId 
                    })
                }).then(function(response) {
                    if(!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                }).then(function(data) {
                    console.log(data);  // handle the response data as needed

                    // Redirect to order page to diplay the order details
                    window.location.href = '/orders';
                }).catch(function(error) {
                    console.log('Error: ', error);

                    // display error message to user if necessary
                });
            }).catch(function(error) {
                console.log('Error: ', error);

                // display error message to user if necessary
            });
        }
    });
});