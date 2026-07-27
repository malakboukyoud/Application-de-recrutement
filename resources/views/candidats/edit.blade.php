@extends('layouts.app')
@section('title', 'Modifier le candidat')

@section('content')
    <h3 class="mb-3">Modifier : {{ $candidat->nom_complet }}</h3>
    <div class="card p-4">
        <form method="POST" action="{{ route('candidats.update', $candidat) }}">
            @csrf
            @method('PUT')
            @include('candidats._form')
        </form>
    </div>
@endsection
