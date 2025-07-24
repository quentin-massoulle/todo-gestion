@extends('layout')
@section('title')
    <title> todo gestion-acceuil</title>
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endsection
@section('content')

  
<h2 class="features-title">Découvrez les fonctionnalités clés de Todo Gestion</h2>
  <section class="features">
  <div class="feature">
    <div class="feature-icon"><img src="{{ asset('img/kanban.png') }}" alt="Kanban" width="50" height="50"></div>
    <h3 class="feature-name">Kanban intuitif</h3>
    <p class="feature-desc">
      Organisez et déplacez vos tâches facilement grâce à une interface glisser-déposer moderne et fluide. 
      Visualisez vos priorités d’un simple coup d’œil et adaptez votre tableau en quelques clics. 
    </p>
    <ul class="feature-list">
      <li>Gardez une vue claire et structurée de l’avancement de vos tâches grâce aux statuts.</li>
      <li>Définissez facilement les priorités pour concentrer vos efforts sur les tâches les plus importantes.</li>
      <li>Collaborez en temps réel avec votre équipe pour suivre les mises à jour </li>
    </ul>
  </div>

  <div class="feature">
    <div class="feature-icon"><img src="{{ asset('img/gantt-chart.png') }}" alt="Diagramme de Gantt" width="50" height="50"></div>
    <h3 class="feature-name">Diagramme de Gantt</h3>
    <p class="feature-desc">Planifiez vos projets sur la durée et visualisez les dépendances entre les tâches.
      Cette vue d’ensemble vous aide à mieux répartir les ressources et à anticiper les obstacles potentiels.
    </p>
    <ul class="feature-list">
      <li>Profitez d’une vue chronologique détaillée</li>
      <li>Attribuez des dates de début et de fin précises à chaque tâche.</li>
      <li>Identifiez et gérez facilement les jalons importants ainsi que toutes vos deadlines pour respecter vos objectifs.</li>
    </ul>
  </div>

  <div class="feature">
    <div class="feature-icon"><img src="{{ asset('img/diagram.png') }}" alt="Planification visuelle" width="50" height="50"></div>
    <h3 class="feature-name">Planification visuelle</h3>
    <p class="feature-desc">Suivez toutes vos échéances et événements importants en un coup d'œil avec un diagramme 
       en definissant des dates de début et de fin pour chaque période souhaitée.</p>
    <ul class="feature-list">
       <li>Visualiser clairement la durée et le déroulement de chaque projet</li>
       <li>Anticiper les retards grâce au suivi des dates clés</li>
       <li>Coordonner efficacement les tâches entre les membres de l’équipe</li> 
    </ul>
  </div>
</section>
   
@endsection
