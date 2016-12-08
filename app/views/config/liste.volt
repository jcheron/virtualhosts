<h1 class="ui dividing header">Mise à jour du fichier de configuration <i class="configure icon"></i></h1>
</br>



</br>
<form action="{{ url("Config/Reboot") }}" class="ui form" method="POST" id='redemarer'>
<h4 class="ui dividing header">Liste des virtualhosts trouvés ...</h4>


{% if host != "rien" %}<!-- 4 -->
{% for server in servers %}<!-- 1 -->
<h4 class="ui dividing header">{{ server.getName() }}: <div class="mini ui button"><i class="power icon"></i>Redémarer le serveur</div></h4> 
<div class="ui middle aligned divided list">

{% for virtualhost in virtualhosts %}<!-- 2 -->
{% if virtualhost.getIdServer() == server.getId() %}<!-- 3 -->
  <div class="item">
    <div class="right floated content">
      <button class="mini ui button" name ="virtualhost" id="{{ virtualhost.getId() }}"><i class="power icon"></i>Valider et redémarer le service</div>
    </button>
    <i class="disk outline icon"></i>
    <div class="content">
      {{ virtualhost.getName() }}
    </div>
  </div>
{% endif %}<!-- 3 -->
{% endfor %}<!-- 2 -->
</div>
{% endfor %}<!-- 1 -->
{% endif %}<!-- 4 -->


{% if host == "rien" %}
<div class="ui middle aligned divided list">
{% for virtualhost in virtualhosts %}<!-- 2 -->
{% if virtualhost.getIdUser() == user.getId() %}<!-- 3 -->
  <div class="item">
    <div class="right floated content">
      <button class="mini ui button" name ="virtualhost" id="{{ virtualhost.getId() }}"><i class="power icon"></i>Valider et redémarer le service</div>
    </button>
    <i class="disk outline icon"></i>
    <div class="content">
      {{ virtualhost.getName() }}
    </div>
  </div>
{% endif %}<!-- 3 -->
{% endfor %}<!-- 2 -->
</div>
{% endif %}
</form>