
<div class="ui black message">
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
{{ script_foot }}