const template = `
<div id="notification">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-__type__ d-flex align-items-center justify-content-between" role="alert">
                            <div>__message__</div>
                            <button type="button" id="notification-close" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
`

window.Echo.private('admin-channel')
    .listen('.admin.export.begin', (event) => {
        $('#notification').remove()
        console.log('begin', event)
        $('main').prepend(
            template.replace('__message__', event.message)
                .replace('__type__', event.type)
        )
    })
    .listen('.admin.export.download', (event) => {
        $('#notification').remove()
        console.log('download', event)
        $('main').prepend(
            template.replace('__message__', event.message)
                .replace('__type__', event.type)
        )
    })
    .listen('.admin.export.failed', (event) => {
        console.log('admin.export.failed', event)
        $('#notification').remove()
        $('main').prepend(
            template.replace('__message__', event.message)
                .replace('__type__', event.type)
        )
    })

$(document).ready(function () {
    $(document).on('click', '#export-products', function () {
        axios.get($(this).data('url')).catch((error) => {
            console.error('export-products', error)
        })
    })
    $(document).on('click', '#notification-close', function () {
        $('#notification').remove()
    })
})
