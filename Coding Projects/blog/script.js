// Retrieve the comment input field and comment list
const commentInput = document.getElementById('comment-input');
const commentList = document.getElementById('comments-list');

// Handle form submission
document.getElementById('comment-form').addEventListener('submit', function(e) {
  e.preventDefault(); // Prevent form submission

  const commentText = commentInput.value.trim();

  if (commentText !== '') {
    // Create a new comment element
    const commentItem = document.createElement('li');
    commentItem.textContent = commentText;

    // Append the comment to the comment list
    commentList.appendChild(commentItem);

    // Clear the comment input field
    commentInput.value = '';
  }
});
