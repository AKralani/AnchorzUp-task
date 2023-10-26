<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div id="sidebar">
        <img src="AnchorzUp-logo.svg" alt="AnchorzUp Logo">
        <h3>My shortened URLs</h3>
        <div id="shortLinkList">
            <!-- Display the list of short links here --> 
            <ul id="shortLinksList"></ul>
            <div id="shortUrl"></div>
        </div>
    </div>
    <div id="content">
        <h1>URL Shortener</h1>
        <div id="urlInput">
            <input type="text" id="originalUrl" placeholder="Paste the URL to be shortened">
            <select id="expirationTime">
            <option value="" disabled selected class="my-class">Add expiration date</option>
                <option value="60">1 minute</option>
                <option value="300">5 minutes</option>
                <option value="1800">30 minutes</option>
                <option value="3600">1 hour</option>
                <option value="18000">5 hours</option>
            </select>
        </div>
        <button onclick="shortenUrl()">Shorten URL</button>  
    </div>
    <script src="script.js"></script>
</body>
</html>