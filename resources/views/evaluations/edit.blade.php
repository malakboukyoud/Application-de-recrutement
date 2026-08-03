@extends('layouts.app')
@section('title', "Modifier l'évaluation")
@include('layouts.topbar')
@section('content')
    <h3 class="mb-1">Modifier l'évaluation</h3>
    <p class="text-muted">
        Candidature {{ $candidature->numero_candidature }} —
        {{ $candidature->candidat->nom }} {{ $candidature->candidat->prenom }}
    </p>

    <div class="card p-4">
        <form method="POST" action="{{ route('evaluations.update', $evaluation) }}">
            @csrf
            @method('PUT')
            @include('evaluations._form')
        </form>
    </div>

    <form method="POST" action="{{ route('evaluations.destroy', $evaluation) }}" class="mt-2"
          onsubmit="return confirm('Supprimer cette évaluation ?')">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger btn-sm">Supprimer cette évaluation</button>
    </form>
@endsection
