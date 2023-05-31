// Get the canvas element by its ID
const canvas = document.getElementById("myCanvas");

// Get the 2D rendering context of the canvas

// Set the new width and height of the canvas
canvas.width = 800;
canvas.height = 600;
const ctx = canvas.getContext("2d");

// Set the font style and size
ctx.font = "50px fantasy";

// Set the fill color to red
ctx.fillStyle = "red";

// Write the text "You are gay" at position (10, 50)
// ctx.fillText("You are gay", 10, 50);

    // Generate random RGB color values
    const r = Math.floor(Math.random() * 256);
    const g = Math.floor(Math.random() * 256);
    const b = Math.floor(Math.random() * 256);

 // Set the fill style to the random color
 ctx.fillStyle = `rgb(${r}, ${g}, ${b})`;

// Set the initial position and velocity of the text
let x = 0;
let y = 0;
let dx = 3;
let dy = 3;

// Define the animation function
function animate() {
  // Request the next animation frame
  requestAnimationFrame(animate);

  // Clear the canvas before drawing the text
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  // Draw the text at the current position
  ctx.fillText("You are gay", x, y);

  // Update the position based on the velocity
  x += dx;
  y += dy;

  // Reverse the velocity if the text reaches the edges of the canvas
  if (x + ctx.measureText("You are gay").width > canvas.width || x < 0) {
    dx = -dx;
  }
  if (y + 50 > canvas.height || y < 0) {
    dy = -dy;
  }
}

// Start the animation loop
animate();
