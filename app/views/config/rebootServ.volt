<h1 class="ui dividing header">Mise à jour du fichier de configuration <i class="configure icon"></i></h1>
</br>


<form action="{{ url("Config/finServ") }}" class="ui form" method="POST" id='chargement'>







<div class="ui icon message">
  <i class="notched circle loading icon"></i>
  <div class="content">
    <div class="header">
      En attente de la confirmation de redemarage du server :
    </div>
    <p class="ui brown header"><b> {{ server.getName() }}</b>     </p>
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