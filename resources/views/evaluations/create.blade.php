@extends('layouts.app')
@section('title', 'Nouvelle évaluation')
@include('layouts.topbar')
@section('content')
    <h3 class="mb-1">Nouvelle évaluation</h3>
    <p class="text-muted">
        Candidature {{ $candidature->numero_candidature }} —
        {{ $candidature->candidat->nom }} {{ $candidature->candidat->prenom }}
    </p>

    <div class="card p-4">
        <form method="POST" action="{{ route('candidatures.evaluations.store', $candidature) }}">
            @csrf
            @include('evaluations._form')
        </form>
    </div>
@endsection
