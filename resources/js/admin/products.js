const selectors = {
    thumbnail: {
        input: '#thumbnail',
        preview: '#thumbnail-preview'
    },
    gallery: {
        wrapper: '#images-wrapper',
        input: '#images',
        editInput: '#edit-images'
    }
}


const galleryPreviewTemplate = "<div class='mb-4 col-md-6'><img src='_url_' style='width: 100%' /></div>"

// Anonymous function will be run only after document (web page) will be ready
$(document).ready(function () {

    // Anonymous function will be run only when <input id="thumbnail" /> value will be changed
    $(selectors.thumbnail.input).on('change', function () {
        const reader = new FileReader()

        // Additional configuration to make an image preview
        reader.onloadend = (e) => {
            // <img id="thumbnail-preview" /> => <img id="thumbnail-preview" src="image_path_url" />
            // img { display: none; } => show => img { display: block; }
            $(selectors.thumbnail.preview).attr('src', e.target.result).show()
        }

        // this => <input id="thumbnail" />
        reader.readAsDataURL(this.files[0])
    })


    $(selectors.gallery.input).on('change', function() {
        $(selectors.gallery.wrapper).html('')
        galleryPreview(this.files)
    })

    $(selectors.gallery.editInput).on('change', function() {
        $(`${selectors.gallery.wrapper} div:not(.images-wrapper-item)`).remove()
        galleryPreview(this.files)
    })
})


const galleryPreview = (files) => {
    let counter = 0, file;

    while(file = files[counter++]) {
        const reader = new FileReader();
        reader.onloadend = (() => {
            return (e) => {
                const img = galleryPreviewTemplate.replace('_url_', e.target.result);
                $(selectors.gallery.wrapper).append(img);
            }
        })(file);
        reader.readAsDataURL(file);
    }
}
