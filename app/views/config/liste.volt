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
