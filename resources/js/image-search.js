let lastRequestUrl = '';

const updateImageContent = function(ajaxResponse, newUrl) {
    // prevent race conditions
    if(newUrl != lastRequestUrl) {
        return;
    }
    // update available tags
    let selected = tagSelect.selected();
    tagSelect.setData(
        ajaxResponse.tags.map(
            function(tag) {
                return {
                    text: tag,
                    value: tag,
                    selected: selected.includes(tag),
                };
            }
        )
    );
    // update images displayed
    document.querySelector('#image-section').innerHTML = ajaxResponse.imageView;
    // update query string in url
    window.history.replaceState({path:newUrl},'',newUrl);
}

let tagSelect = new SlimSelect({
    select: '#slct-tag',
    placeholder: 'Select Tags',
    searchText: 'No Tags Found',
    searchHighlight: true,
    closeOnSelect: false,
    onChange: function() {
        const form = document.querySelector('.photo-search-form');
        const queryString = (new URLSearchParams(new FormData(form))).toString();
        const newUrl = form.action + (queryString ? '?' + queryString : '');
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
                return response.json();
            })
            .then(function(responseText) {
                updateImageContent(responseText, newUrl);
            })
            .catch(error => {
                console.error('There was a problem getting the image results: ', error);
            });
        } else {
            // legacy support
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    updateImageContent(JSON.parse(this.responseText), newUrl);
                }
            };

            xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp.open(newUrl, form.action, true);
            xhttp.send();
        }
    },
})