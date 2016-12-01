<h1 class="ui dividing header">Mise à jour du fichier de configuration</h1>
</br>


<h4 class="ui dividing header">Recherche les VirtualHosts d'une machine ...</h4>

<label>Utilisateur : </label> </br>
<div class="ui  disabled dropdown">
yann.aubry@sts-sio-caen.info <i class="dropdown icon"></i>
  <div class="menu">
    <div class="item">yann.aubry@sts-sio-caen.info</div>

  </div>
</div>

	
	<div class="field">
        <label>Machine :</label>       
          <select class="ui fluid search dropdown" name=server">
          {% for host in hosts %}
          {% if host.getIdUser() == 3 %}
            <option value="{{ host.getId() }}">{{ host.getName() }}</option>
            {% endif %}
		{% endfor %}
          </select>
	</div>	



</br>
<button class="ui green button">
<i class="checkmark icon"></i>
  Valider 
</button>
</br>

<h4 class="ui dividing header">Liste des virtualhosts trouvés ...</h4>

{% for server in servers %}
<h4 class="ui dividing header">{{ server.getName() }}: <div class="mini ui button"><i class="power icon"></i>Redémarer le serveur</div></h4> 
<div class="ui middle aligned divided list">
{% for virtualhost in virtualhosts %}
{% if virtualhost.getIdServer() == server.getId() %}
  <div class="item">
    <div class="right floated content">
      <div class="mini ui button"><i class="power icon"></i>Valider et redémarer le service</div>
    </div>
    <i class="disk outline icon"></i>
    <div class="content">
      {{ virtualhost.getName() }}
    </div>
  </div>
{% endif %}
{% endfor %}
</div>
{% endfor %}

