@extends('layout')

@section('content')
    <h1>Checkout</h1>


    <form action="/order/checkout" method="post" id="payment-form">
        @csrf
        <div class="form-group">
            <input class="form-control" name="name" placeholder="Name"/>
        </div>

        <div class="form-group">
            <input class="form-control" name="email" placeholder="Email"/>
        </div>

        <div class="form-group">
            <input class="form-control" name="address" placeholder="Address"/>
        </div>

        <div class="form-group" id="card-element">
            <input class="form-control" placeholder="Credit card #"/>
        </div>

        <!-- Used to display Element errors -->
        <div id="card-errors" role="alert"></div>


    <div class="panel panel-default">
        <div class="panel-body">
            <button class="btn btn-success pull-right">Checkout</button>
        </div>
    </div>

    </form>

    <script src="https://js.stripe.com/v3/"></script>

    <script>
        var stripe = Stripe('{{getenv('APP_STRIPE_KEY')}}');
        var elements = stripe.elements();


        var style = {
            base: {
                // Add your base input styles here. For example:
                fontSize: '16px',
                color: "#32325d",
            }
        };

        // Create an instance of the card Element
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>
        card.mount('#card-element');


        // Create a token or display an error when the form is submitted.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Inform the customer that there was an error
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    </script>
@endsection
