setInterval(() => {
    fetch('bid_update.php')
    .then(response => response.text())
    .then(data => {
        // Send bid data to main script
        postMessage(data);
    });
}, 1000);
