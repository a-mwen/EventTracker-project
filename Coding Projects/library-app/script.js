let myLibrary = [];

function Book(title, author, read, pages) {
    this.title = title;
    this.author = author;
    this.read = read;
    this.pages = pages;
}

function addBookToLibrary(){
    event.preventDefault(); // prevent the form from submitting and refreshing the page
    
    let title = document.getElementById("bookTitle").value;
    let author = document.getElementById("author").value;
    let pages = document.getElementById("pages").value;
    let read = document.getElementById("read").checked;

    let book = new Book(title, author, read, pages);
    myLibrary.push(book);
    console.log(myLibrary);

    displayBooks();

  document.querySelector('form').reset();

}

function displayBooks() {
    let bookTable = document.getElementById("bookTable");
    const tbody = bookTable.querySelector("tbody");
    tbody.innerHTML = "";

    //loop through the library and add each book to the table
    for (let i = 0; i < myLibrary.length; i++) {
        const book = myLibrary[i];

        const row = document.createElement("tr");
        row.innerHTML = `
        <td>${book.title}</td>
        <td>${book.author}</td>
        <td>${book.pages}</td>
        <td>${book.read ? "Yes" : "No"}</td>
        <td><button class="delete" data-index="${i}">Delete</button></td>

      `;
    
      tbody.appendChild(row);
    }

      // add event listeners to delete buttons
  const deleteButtons = document.querySelectorAll(".delete");
  deleteButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      const index = event.target.getAttribute("data-index");
      myLibrary.splice(index, 1);
      displayBooks();
    });
  });
}


document.querySelector('form').addEventListener('submit', addBookToLibrary);


