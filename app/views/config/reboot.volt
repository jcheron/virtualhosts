<h1 class="ui dividing header">Mise Ã  jour du fichier de configuration <i class="configure icon"></i></h1>
</br>


<form action="{{ url("Config/fin") }}" class="ui form" method="POST" id='chargement'>



{{ virtualhost.getName() }}
{{ server.getName() }}


<div class="ui icon message">
  <i class="notched circle loading icon"></i>
  <div class="content">
    <div class="header">
      En attente de la confirmation de redemarage du virtualhost :
    </div>
    <p class="ui brown header"><b> {{ virtualhost.getName() }}</b>     </p>
  </div>
</div>





  <button class="ui green button" name ="property">
<i class="reply icon"></i>
  Confirmer 
</button>


</br>
</br>

</form>
<form action="{{ url("Config/index") }}" class="ui form" method="POST" id='chargement'>
  <button class="ui red button"  >
<i class="reply icon"></i>
 Annuler
</button>
</form>