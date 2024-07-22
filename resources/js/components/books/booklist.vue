<template>
    <div>
        <div class="header">
        <h2>Where all your book needs are met.</h2>
    </div>

      <h1>Book List</h1>
      <div class="InputContainer">
        <input placeholder="Search by Id, Title, Description, Genre" id="input" class="input" v-model="searchQuery">
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
                <td colspan="3">No books available</td>
            </tr>
            <tr v-for="book in books" :key="book.id">
                <td>{{ book.id }}</td>
                <td>{{ book.title }}</td>
                <td>{{ book.description }}</td>
                <td>{{ book.genre }}</td>
                <td>{{ book.price }}</td>
                <td><button @click="borrowBook(book.id)">Borrow</button></td>
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
      searchQuery: ''
    };
  },
  mounted() {
    this.fetchBooks();
  },
  methods: {
    fetchBooks() {
      axios.get('/books')
        .then(response => {
          this.books = response.data.data;
        })
        .catch(error => {
          console.error('Error fetching books:', error);
        });
    },
    searchBooks() {
      axios.get(`/books/search?query=${this.searchQuery}`)
        .then(response => {
          this.books = response.data.data;
        })
        .catch(error => {
          console.error('Error searching books:', error);
        });
    },
    borrowBook(bookId){
      axios.post(`/books/${bookId}/borrow`)
      .then(response => {
        alert('Book borrowed successfully!');
      })
      .catch(error => {
        console.error('Error borrowing book:', error);
        alert('Failed to borrow book. Please try again.');
      });
    }
  }
};
</script>