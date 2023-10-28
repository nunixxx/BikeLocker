setTimeout(() => {
    const messageElement = document.getElementById("messageBox");
    if (messageElement) {
        messageElement.remove();
    }
}, 5000);