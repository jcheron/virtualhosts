<div id="test">
</div>

<div id="divAction">

{% if  q["table4"] is defined %}
<div class="ui positive message">
<h3> Liste des machines : </h3>
   Liste des virtualHosts :
  </div>
  
{{ q["table4"] }}
{% else %}
<div class="ui positive message">
<h3> Il n'existe pas de virtualhost actuellement pour ce serveur </h3>
  </div>
<p>  Pas de virtualhost en ce moment .. </p>
{% endif %}



{{ q["ajoutervirtual"]}}

</div>


{{ script_foot }}
