function shortenUrl() {
    const originalUrl = document.getElementById('originalUrl').value;
    const expirationTime = document.getElementById('expirationTime').value;
    
    if (!originalUrl) {
        alert('Please enter a URL.');
        return;
    }

    fetch('shorten.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ url: originalUrl, expiration: expirationTime }),
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('shortUrl').innerHTML = `New Short URL: <a href="${data.shortUrl}">${data.shortUrl}</a>`;
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Function to retrieve the list of short links
function getShortLinks() {
    fetch('shorten.php?getShortLinks=true')
        .then(response => response.json())
        .then(data => {
            const shortLinksList = document.getElementById('shortLinksList');
            shortLinksList.innerHTML = ''; // Clear the list

            data.shortLinks.forEach(link => {
                const li = document.createElement('li');
                li.innerHTML = `<a href="${link.shortUrl}">${link.shortUrl}</a>
                <span class="delete-icon" onclick="deleteShortUrl('${link.shortUrl}')">
                <i class="fas fa-trash-alt"></i>
                </span>`;
                shortLinksList.appendChild(li);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function deleteShortUrl(shortUrl) {
    fetch('shorten.php', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ short_url: shortUrl }),
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.status === 'success') {
            // alert(data.message);
            return getShortLinks();  // Refresh the list
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Call getShortLinks on page load
getShortLinks();