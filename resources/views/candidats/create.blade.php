@extends('layouts.app')
@section('title', 'Nouveau candidat')

@section('content')
    <h3 class="mb-3">Nouveau candidat</h3>
    <div class="card p-4">
        <form method="POST" action="{{ route('candidats.store') }}">
            @csrf
            @include('candidats._form')
        </form>
    </div>
@endsection
