@extends('layout.pos')
@section('title', 'POS')
@section('content')
        <pos-component></pos-component>
    @if (session('token'))
        <script>
            localStorage.setItem("token", "{{ session('token') }}");
            localStorage.setItem("name", "{{ auth()->user()->name }}");
            localStorage.setItem("role", "{{ auth()->user()->roles[0]->name }}");
            localStorage.setItem("image", "{{ auth()->user()->thumbnail->file?? null }}");
        </script>
    @endif
@endsection
