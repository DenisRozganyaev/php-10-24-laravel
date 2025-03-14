const selectors = {
    wrapper: '#images-wrapper',
    item: '.images-wrapper-item',
    removeBtn: '.images-wrapper-item-remove'
}

$(document).ready(function() {
    $(selectors.removeBtn).on('click', function(e) {
        e.preventDefault()

        const $btn = $(this)
        $btn.addClass('disabled')

        // HTTP DELETE REQUEST
        axios.delete($btn.data('url'), {
            responseType: 'json'
        }).then((response) => {
            iziToast.success({
                message: response.data.message, // created on back-end side
                position: 'topRight'
            })

            $btn.parent().remove()
        }).catch((error) => {
            iziToast.error({
                message: error.data.message, // created on back-end side
                position: 'topRight'
            })
            $btn.removeClass('disabled')
        })
    })
})
