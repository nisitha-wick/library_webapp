<template>
    <div>
      <h1>Book List</h1>
      <ul>
        <li v-for="book in books" :key="book.id">
          {{ book.title }} - {{ book.genre }} - ${{ book.price }}
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        books: []
      };
    },
    mounted() {
      this.fetchBooks();
    },
    methods: {
      fetchBooks() {
        axios.get('http://127.0.0.1:8000/books')
          .then(response => {
            this.books = response.data;
          })
          .catch(error => {
            console.error('Error fetching books:', error);
          });
      }
    }
  };
  </script>