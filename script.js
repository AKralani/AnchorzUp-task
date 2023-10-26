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
                li.innerHTML = `<a href="${link.shortUrl}">${link.shortUrl}</a>`;
                shortLinksList.appendChild(li);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Call getShortLinks on page load
getShortLinks();