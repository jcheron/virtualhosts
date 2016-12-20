<div id="divAction"></div>
<div id="delete"></div>
<div class="ui black message">
{% if active === "true" %}
  <div class="header">
    Modifier type de propriété : <span class="ui green tiny label">{{ Stype.getName() }}</span>
  </div>
  <p>Tous les champs marqués par des <em>*</em> sont obligatoires.</p>
</div>

<div class="ui green segment">
<form id="frmUpdate">
    {{ q["table"] }}
</form>
</div>

{% else  %}
<div class="ui icon message">
  <i class="inbox icon"></i>
  <div class="content">
    <div class="header">
		Propriété type de serveur : <span class="ui green tiny label">{{ Stype.getName() }}</span>
    </div>
      <p>Ce type de serveur ne possède pas de propriétés ! Voulez-vous ajouter un type de propriété maintenant ?</p>
	<br>
    {{ q["btnAdd"] }}
    {{ q["btnCancel"] }}
  </div>
</div>

{% endif  %}
{{ script_foot }}