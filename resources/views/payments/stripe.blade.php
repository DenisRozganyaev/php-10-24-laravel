<div class="card my-2">
    <div class="card-body">
        <div id="stripe-payment-form" class="my-2"></div>
        <button id="stripe-payment" class="btn btn-outline-primary w-100 mt-2 mb-3">Pay by Stripe</button>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
@push('footer-js')
    <script>
        const stripe = Stripe('{{ config('services.stripe.publishable_key') }}')
    </script>
    @vite(['resources/js/payments/stripe.js'])
@endpush
