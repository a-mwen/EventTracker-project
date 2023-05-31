// Select all the HTML elements with the class name 'square' and assign them to the variable 'squares'
const squares = document.querySelectorAll('.square');

// Select the HTML element with the ID 'message' and assign it to the variable 'message'
const message = document.getElementById('message');



// Initialize the 'player' variable to 'X'
let player = 'X';

// For each square, add an event listener that listens for a 'click' event
squares.forEach((square) => {
  square.addEventListener('click', () => {
    
    // If the square is empty
    if (square.innerHTML === '') {
      
      // Set the square's innerHTML to the current player's symbol ('X' or 'O')
      square.innerHTML = player;
      
      // Check if the current player has won
      if (checkWin()) {
        
        // If the current player has won, set the message to display that the current player has won and disable all squares
        message.innerHTML = `${player} wins!`;
        disableSquares();
      } 
      
      // If the game is not won, check if the game is a draw
      else if (checkDraw()) {
        
        // If the game is a draw, set the message to display that the game is a draw and disable all squares
        message.innerHTML = 'Draw!';
        disableSquares();
      } 
      
      // If the game is not won and not a draw, switch to the other player's turn
      else {
        player = player === 'X' ? 'O' : 'X';
      }
    }
  });
});

function checkWIn() {

    //Define all possible combinations
    const winningCombos = [
        [0,1,2], //first row
        [3,4,5],//second row
        [6,7,8], //third column
        [0,3,6], //first column
        [1,4,7], //second column
        [2,5,8], // third column
        [0,4,8], //Diagonal top-left to bottom-right
        [2,4,6],//Diagonal from top-right to botton-left
    ];

    //Check if any of the winning combinations have been achieved
    return winningCombos.some((combo) => {

        //If all squares in a winning combination have the same symbol and are not empty, return true
        return squares[combo[0]].innerHTML !== '' &&
            squares[combo[0]].innerHTML === squares[combo[1]].innerHTML &&
            squares[combo[1]].innerHTML === squares[combo[2]].innerHTML;
    });
}

    function checkDraw() {
  
        // Check if every square has been played
        return Array.from(squares).every((square) => {
          return square.innerHTML !== '';
        });
      }
      
      function disableSquares() {
        
        // Disable all squares by setting their CSS pointer-events property to 'none'
        squares.forEach((square) => {
          square.style.pointerEvents = 'none';
        });
      }
      