import '../bootstrap.js'
import toast from "bootstrap/js/src/toast.js";

const selectors = {
    form: '#checkout-form',
    button: '#stripe-payment',
    stripeCard: '#stripe-payment-form'
}

function getFields() {
    return $(selectors.form).serializeArray()
        .reduce((obj, item) => {
            obj[item.name] = item.value
            return obj
        }, {})
}

function isEmptyFields() {
    let result = false
    const fields = getFields()

    Object.keys(fields).map((key) => {
        if (fields[key].length < 1) {
            $(`${selectors.form} input[name="${key}"]`).addClass('is-invalid')
            result = true
        }
    })

    return result
}

$(document).ready(function () {
    const elements = stripe.elements()
    const cardElement = elements.create('card')
    cardElement.mount(selectors.stripeCard)

    $(selectors.button).on('click', function (e) {
        e.preventDefault()
        const fields = getFields()
        $(selectors.form).find('.is-invalid').removeClass('is-invalid')

        if (isEmptyFields()) {
            iziToast.warning({
                title: 'Please fill an empty fields',
                position: 'topRight'
            })
            return
        }

        axios.post('/ajax/stripe/order', fields)
            .then(async (response) => {

                const { client_secret, payment_id } = response.data

                const {paymentIntent, error} = await stripe.confirmCardPayment(
                    client_secret,
                    {
                        payment_method: {
                            card: cardElement,
                            billing_details: {
                                name: `${fields.name} ${fields.lastname}`,
                            },
                        }
                    })

                if (error) {
                    console.error('stripe error:', error)
                    iziToast.error({
                        title: error.message,
                        position: 'topRight'
                    })
                } else if (paymentIntent && paymentIntent.status === 'succeeded') {

                    // axios.post('stripe/capture', {
                    //      status: paymentIntent.status
                    // }).then(() => {
                    /*iziToast.success({
                        title: 'Payment was completed',
                        position: 'topRight'
                    })*/
                    // )
                    iziToast.success({
                        title: 'Payment was completed',
                        position: 'topRight'
                    })
                }
            })
    })
});
