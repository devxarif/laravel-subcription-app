@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Subscribe</div>

                <div class="card-body">
                    <form action="{{ route('subscribe.store') }}" method="post" id="payment-form"
                        data-secret="{{ $intent->client_secret }}">
                        @csrf
                        <div class="mt-4" style="outline: 0">
                            <input type="radio" name="plan" value="price_1KRGj6DHsbz9CBNMpn08Uf44" id="plan1" />
                            <label for="plan1">Standard - $10 / month</label><br>
                            <input type="radio" name="plan" value="price_1KRGj6DHsbz9CBNMgPbmWF2J" id="plan2" />
                            <label for="plan2">Premium - $20 / month</label>
                        </div>

                        <label for="name">Name</label>
                        <input type="text" name="name" required id="cardholder-name" />

                        {{-- <label for="email">Email</label>
                        <input type="email" name="email" required /> --}}

                        <label for="card-element">Credit or debit card</label>
                        <div id="card-element" style="margin-bottom: 10px;">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>

                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert" class="text-danger"></div>

                        <button type="submit" class="mt-1 btn btn-primary" id="card-button">
                            Subscribe Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://js.stripe.com/v3/"></script>
<script>

    var stripe = Stripe('pk_test_51JAbnoDHsbz9CBNMjbDtUrA8pfBWkC9yvXqzFQYHeEJokRKFvpAedEruhqCxJhzqOflDi0KH1E020J5kitkMWV4q00fl2LBk6p');
    var elements = stripe.elements();

    // Create an instance of the card Element.
    var card = elements.create('card');

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function (event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission.
    var form = document.getElementById('payment-form');
    var cardHolderName = document.getElementById('cardholder-name');
    var clientSecret = form.dataset.secret;

    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        const { setupIntent,error} = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card,
                    billing_details: {
                        name: cardHolderName.value
                    }
                }
            }
        );

        if (error) {
            // Display "error.message" to the user...
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
        } else {
            // Send the token to your server.
            console.log(setupIntent);
            stripeTokenHandler(setupIntent);
            // The card has been verified successfully...
        }


        // stripe.createToken(card).then(function(result) {
        //   if (result.error) {
        //     // Inform the user if there was an error.
        //     var errorElement = document.getElementById('card-errors');
        //     errorElement.textContent = result.error.message;
        //   } else {
        //     // Send the token to your server.
        //     stripeTokenHandler(result.token);
        //   }
        // });
    });


    // Submit the form with the token ID.
    function stripeTokenHandler(setupIntent) {
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'paymentMethod'); // <-- important
        hiddenInput.setAttribute('value', setupIntent.payment_method);
        form.appendChild(hiddenInput);
        // Submit the form
        form.submit();
    }
</script>
@endsection

@section('style')
<style>
    .StripeElement {
        font-family: inherit;
        font-size: 100%;
        color: inherit;
        border: none;
        border-radius: 0;
        display: block;
        width: 100%;
        padding: 0;
        margin: 0;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    form label,
    form legend {
        font-size: 0.825rem;
        margin-bottom: 0.5rem;
    }

    /* border, padding, margin, width */
    form input,
    form select,
    form textarea,
    .StripeElement {
        box-sizing: border-box;
        border: 1px solid rgba(0, 0, 0, 0.2);
        background-color: rgba(255, 255, 255, 0.9);
        padding: 0.75em 1rem;
        margin-bottom: 1.5rem;
    }

    form input:focus,
    form select:focus,
    form textarea:focus,
    .StripeElement:focus {
        background-color: white;
        outline-style: solid;
        outline-width: thin;
        outline-color: gray;
        outline-offset: -1px;
    }

    form [type="text"],
    form [type="email"],
    .StripeElement {
        width: 100%;
    }

    form [type="button"],
    form [type="submit"],
    form [type="reset"] {
        width: auto;
        cursor: pointer;
        -webkit-appearance: button;
        -moz-appearance: button;
        appearance: button;
    }

    form [type="button"]:focus,
    form [type="submit"]:focus,
    form [type="reset"]:focus {
        outline: none;
    }

    form select {
        text-transform: none;
    }
</style>
@endsection
