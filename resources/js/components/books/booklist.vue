<template>
  <div class="web_cont">
    <h1>Book List</h1>
    <div class="InputContainer">
      <input class="input" placeholder="Search by Id, Title, Description, Genre" v-model="searchQuery">
      <button @click="searchBooks" class="searchbtn">Search</button>
    </div>
    <div class="container">
      <table class="clean-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Genre</th>
            <th>Price</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="books.length === 0">
            <td colspan="6">No books available</td>
          </tr>
          <tr v-for="book in books" :key="book.id">
            <td>{{ book.id }}</td>
            <td>{{ book.title }}</td>
            <td>{{ book.description }}</td>
            <td>{{ book.genre }}</td>
            <td>{{ book.price }}</td>
            <td>
              <button v-if="!book.is_borrowed" @click="borrowBook(book.id)">Borrow</button>
              <button class = 'returnbtn' v-if="book.is_borrowed" @click="returnBook(book.id)">Return</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      books: [],
      searchQuery: '',
      borrowedBooks: []
    };
  },
  mounted() {
    this.fetchBooks();
  },
  methods: {
    fetchBooks() {
      axios.get('/books')
      .then(response => {
        this.borrowedBooks = response.data.borrowedBooks || [];
        this.books = response.data.books.map(book => ({
          ...book,
          is_borrowed: this.checkIfBorrowed(book.id)
        }));
      })
      .catch(error => {
        console.error('Error fetching books:', error.response ? error.response.data : error.message);
      });
    },
    searchBooks() {
      axios.get(`/books/search?query=${this.searchQuery}`)
        .then(response => {
          this.books = response.data.data.map(book => ({
            ...book,
            is_borrowed: this.checkIfBorrowed(book.id)
          }));
        })
        .catch(error => {
          console.error('Error searching books:', error.response ? error.response.data : error.message);
        });
    },
    borrowBook(bookId) {
      axios.post(`/books/${bookId}/borrow`)
        .then(response => {
          alert(response.data.message);
          this.fetchBooks();
        })
        .catch(error => {
          alert(error.response ? error.response.data.message : error.message);
          console.error('Error borrowing book:', error.response ? error.response.data : error.message);
        });
    },
    returnBook(bookId) {
      axios.post(`/books/${bookId}/return`)
        .then(response => {
          alert(response.data.message);
          this.fetchBooks();
        })
        .catch(error => {
          alert(error.response ? error.response.data.message : error.message);
          console.error('Error returning book:', error.response ? error.response.data : error.message);
        });
    },
    checkIfBorrowed(bookId) {
    if (!this.borrowedBooks) {
      return false;
    }
    return this.borrowedBooks.includes(bookId);
  }
  }
};
</script>
