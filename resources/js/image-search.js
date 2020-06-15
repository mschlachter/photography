let lastRequestUrl = '';

const updateImageContent = function(newContent) {
    document.querySelector('#image-section').innerHTML = newContent;
}

new SlimSelect({
    select: '#slct-tag',
    placeholder: 'Select Tags',
    searchText: 'No Tags Found',
    searchHighlight: true,
    closeOnSelect: false,
    onChange: function() {
        const form = document.querySelector('.photo-search-form');
        const newUrl = form.action + '?' + (new URLSearchParams(new FormData(form))).toString();
        lastRequestUrl = newUrl;

        if(window.fetch) {
            fetch(newUrl, {
                method: form.method,
                'headers': {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
            })
            .then(function(response) {
                return response.text();
            })
            .then(function(responseText) {
                // prevent race conditions
                if(newUrl != lastRequestUrl) {
                    return;
                }
                updateImageContent(responseText);
            })
            .catch(error => {
                console.error('There was a problem getting the image results: ', error);
            });
        } else {
            // legacy support
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                // prevent race conditions
                if(newUrl != lastRequestUrl) {
                    return;
                }
                if (this.readyState == 4 && this.status == 200) {
                    updateImageContent(this.responseText);
                }
            };

            xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp.open(newUrl, form.action, true);
            xhttp.send();
        }
    },
})