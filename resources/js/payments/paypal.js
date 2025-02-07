import '../bootstrap.js'

const selectors = {
    form: '#checkout-form'
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

paypal.Buttons({
    style: {
        color: 'blue',
        shape: 'pill',
        label: 'pay',
        height: 40
    },

    onInit: function(data, actions) {
        actions.disable()

        $(document).on('change', selectors.form, function () {
            if (!isEmptyFields()) {
                actions.enable()
                $(selectors.form).find('.is-invalid').removeClass('is-invalid')
            }
        })
    },

    onClick: function(data, actions) {
        if (isEmptyFields()) {
            iziToast.warning({
                title: 'Please fill an empty fields',
                position: 'topRight'
            })
            return
        }

        $(selectors.form).find('.is-invalid').removeClass('is-invalid')
    },

    createOrder: function (data, actions) {
        return axios.post('/ajax/paypal/order', getFields())
            .then((res) => {
                const {data} = res
                console.log('createOrder response:', res)
                return data.vendor_order_id
            }).catch((error) => {
                console.error('createOrder error:', error)
            })
    },

    onApprove: function (data, actions) {
        return axios.post(`/ajax/paypal/order/${data.orderID}/capture`, {})
            .then(function (response) {
                const orderData = response.data

                console.log('orderData', orderData)

                iziToast.success({
                    title: 'Order was created!',
                    position: 'topRight',
                    onClosing: () => {
                        window.location.href = `orders/${orderData.orderId}/thank-you`
                    }
                })
            })
            .catch((error) => {
                const errorDetail = Array.isArray(error.data.details) && error.data.details[0]

                if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
                    return actions.restart() // Recoverable state, per:
                }

                if (errorDetail) {
                    let msg = 'Sorry, your transaction could not be processed.'
                    if (errorDetail.description) msg += '\n\n' + errorDetail.description
                    if (error.data.debug_id) msg += ' (' + error.data.debug_id + ')'
                    return alert(msg)
                }
            })
    }

}).render('#paypal-button-container')
