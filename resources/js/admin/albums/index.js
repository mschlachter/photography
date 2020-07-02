$(document).on('change', '.input-publish-album', function(event) {
    event.preventDefault();

    let form = this.form;

    $.ajax(form.action, {
        'type': 'POST',
        'data': new FormData(form),
        'success': function(data) {
            $.notify({
                icon: "image",
                message: "Album publish status successfully updated."
            },{
                type: 'success',
                timer: 4000,
                placement: {
                    from: 'top',
                    align: 'right'
                }
            });
        },
        'error': function(data) {
            let error = data.status;
            if(data.responseJSON) {
                error = data.responseJSON.message;
            } else if (data.responseText) {
                error = data.responseText;
            }

            if(data.responseJSON && data.responseJSON.errors) {
                console.log(data.responseJSON.errors);
            }

            $.notify({
                icon: "image",
                message: "Error while updating publish status: " + error
            },{
                type: 'danger',
                timer: 4000,
                placement: {
                    from: 'top',
                    align: 'right'
                }
            });
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
});