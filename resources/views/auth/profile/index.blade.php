@extends('layouts.app')
@section('title', 'Profil')
@section('content')
    <h1>Bonjour Mr {{ auth()->user()->name }}</h1>
@endsection