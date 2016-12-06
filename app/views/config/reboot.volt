<h1 class="ui dividing header">Mise à jour du fichier de configuration <i class="configure icon"></i></h1>
</br>

{% if attente == 0 %}
<form action="{{ url("Config/reboot") }}" class="ui form" method="POST" id='chargement'>
<div class="ui icon message">
  <i class="notched circle loading icon"></i>
  <div class="content">
    <div class="header">
      Veuillez patienter
    </div>
    <p class="ui brown header">Le virtualhost<b> {{ virtualhost.getName() }}</b>     redémare.</p>
  </div>
</div>
</form>
{% endif %}

{% if attente == 1 %}
<h1>Bonjour</h1>
{% endif %}
{#% for property in propertys %}
{% if property.getIdVirtualhost() == virtualhost.getId() %}
{% set  property.setActive(0) %}
{% endif %}
{% endfor %}


