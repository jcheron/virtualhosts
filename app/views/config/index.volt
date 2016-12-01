<h1 class="ui dividing header">Mise à jour du fichier de configuration</h1>
</br>


<form action="{{ url("Config/liste") }}" class="ui form" method="POST" id='frm'>
<h4 class="ui dividing header">Recherche les VirtualHosts d'une machine ...</h4>
<label>Utilisateur : </label> </br>
<div class="ui  disabled dropdown">
{{ user.getEmail() }} <i class="dropdown icon"></i>
  <div class="menu">
    <div class="item">yann.aubry@sts-sio-caen.info</div>

  </div>
</div>

	
	<div class="field">
        <label>Machine :</label>       
          <select class="ui fluid search dropdown" name=server">
          {% for host in hosts %}
          {% if host.getIdUser() == user.getId() %}
            <option value="{{ host.getId() }}">{{ host.getName() }}</option>
            {% endif %}
		{% endfor %}
          </select>
	</div>	



</br>
<button class="ui green button" id="Valider">
<i class="checkmark icon"></i>
  Valider 
</button>
</br>
</form>



