<div id="paypal-button-container"></div>

@push('footer-js')
    <script src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.' . config('paypal.mode') . '.client_id') }}&currency={{ config('paypal.currency') }}"></script>
    @vite(['resources/js/payments/paypal.js'])
@endpush
