// Get the chat form and the chat box
const chatForm = document.getElementById('chat-form');
const chatBox = document.getElementById('messages');

// Add an event listener to the chat form
chatForm.addEventListener('submit', async function(event) {
    // Prevent the default form submission behavior
    event.preventDefault();

    // Get the user's input
    const userInput = document.getElementById('user-input').value;
    const userMessage = `<div class="user-message"><strong>You: </strong> ${userInput} </div>`;
    chatBox.innerHTML += userMessage;

    try {
        const response = await fetch('bot_logic.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({ user_input: userInput }),
        });

        if (!response.ok) throw new Error('Network response was not ok');

        const botResponse = await response.json();
        const botResponseMessage = `<div class="bot-message"><strong>Bot: </strong> ${botResponse.answer} </div>`;
        chatBox.innerHTML += botResponseMessage;
    } catch (error) {
        chatBox.innerHTML += `<div class="error-message"><strong>Error:</strong> Unable to get a response. Please try again later.</div>`;
        console.error('Fetch error:', error);
    }

    // Clear the user's input
    chatForm.reset();
});
