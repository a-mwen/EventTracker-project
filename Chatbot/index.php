<html>
    <head>
        <title>EventTracker Chatbot</title>
        <link rel="stylesheet" href="./css/stylesheet.css">
    </head>
    <body>
        <div class="chat-container">
            <h1>EventTracker Chatbot</h1>
            <div id="chatbox">
                <div id="messages"></div>
            </div>
            <form id="chat-form"  method="POST" >
                <input type="text" id="user-input" placeholder="Type your message here..">
                <button type="submit">Send</button>
            </form>

            <button id="refresh-chat">Refresh Chat</button>

<script>
document.getElementById('refresh-chat').addEventListener('click', function() {
    document.getElementById('messages').innerHTML = ''; // Clear chat messages
    document.getElementById('user-input').value = ''; // Clear input field
});
</script>
        </div>
        <div class="back-button">
                <a href="../authentication/welcome.php" class="back-link">Back to Welcome Page</a>
            </div>

            

        <script src="./js/chatbot.js"></script>
    </body>
</html>