let tagInputs = [];

document.querySelectorAll('.tags-input').forEach(function(tagInput) {
    let input = new Tagify(tagInput, {
        whitelist: window.existingTags,
        originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(', '),
        dropdown: {
            maxItems: 20,
            enabled: 0,
            closeOnSelect: false
        }
    });
    tagInputs.push(input);
});

$(document).on('submit', '.image-update-form', function(event) {
    event.preventDefault();

    let submitButton = $(this).find('[type=submit]');
    submitButton.prop('disabled', true);

    let container = $(this).closest('.image-form-container');

    $.ajax(this.action, {
        'type': 'POST',
        'data': new FormData(this),
        'success': function(data) {
            container.html(data['edit-view']);
            tagInputs.forEach(function(input) {
                try {
                    input.settings.whitelist = data['tag-list'];
                } catch {}
            });
            let input = new Tagify(container.find('.tags-input')[0], {
                whitelist: data['tag-list'],
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(', '),
                dropdown: {
                    maxItems: 20,
                    enabled: 0,
                    closeOnSelect: false
                }
            });
            tagInputs.push(input);
            submitButton.prop('disabled', false);
            $(window).trigger('resize');

            $.notify({
                icon: "image",
                message: "Image was successfully saved."
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

            submitButton.prop('disabled', false);

            if(data.responseJSON && data.responseJSON.errors) {
                console.log(data.responseJSON.errors);
            }

            $.notify({
                icon: "image",
                message: "Error while saving image: " + error
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
})