<h1 class="ui dividing header">Mise Ã  jour du fichier de configuration <i class="configure icon"></i></h1>
</br>


<form action="{{ url("Config/liste") }}" class="ui form" method="POST" id='frm'>
<h4 class="ui dividing header">Recherche les VirtualHosts d'une machine ...</h4>
<label>Utilisateur : </label> </br>
<div class="ui  disabled dropdown">
{{ user.getEmail() }} 

</div>

<div class="ui form">
  <div class="two fields">
	<div class="col-md-7">
        <label>Machine :</label>       
          <select class="ui fluid search dropdown" name="host">
          {% for host in hosts %}
          {% if host.getIdUser() == user.getId() %}
            <option value="{{ host.getId() }}">{{ host.getName() }}</option>
            {% endif %}
		{% endfor %}
		<option value="rien">Je ne possÃ¨de aucune machine</option>
          </select>
	</div>	
	<div class="col-md-7">
        <label>Machine :</label>       
          <select class="ui fluid search dropdown" name="host">
          {% for host in hosts %}
          {% if host.getIdUser() == user.getId() %}
            <option value="{{ host.getId() }}">{{ host.getName() }}</option>
            {% endif %}
		{% endfor %}
		<option value="rien">Je ne posséde aucune machine</option>
          </select>
	</div>	
	
	
	
</div>
</div>


</br>
<button class="ui green button" id="Valider" name="Valider">
<i class="checkmark icon"></i>
  Valider 
</button>
</br>
</form>



