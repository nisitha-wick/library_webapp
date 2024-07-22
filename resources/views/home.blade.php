@extends('layouts.app')

@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
<div class="container">
    @auth
    <div id = "app">
        <booklist></booklist>
    </div>  
    @endauth
</div>

@endsection
