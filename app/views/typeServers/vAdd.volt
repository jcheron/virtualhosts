<!--  <form action="{{ url("typeServers/vAddSubmit") }}" method="Post">
<div class="ui form">
  <div class="field">
    <label>Nom</label>
    <input type="text" name="name" placeholder="Nom type server">
  </div>
  <div class="field">
    <label>Template</label>
    <textarea name="configTemplate" placeholder="Template"></textarea>
  </div>
  <div class="field">
<button class="ui primary button">
  Valider
</button>
</div>
</div>
</form>
-->
<div class="ui black message">
  <div class="header">
    Ajouter un type de server
  </div>
  <p>Tous les champs marqués par des <em>*</em> sont obligatoires.</p>
</div>
<div class="ui blue segment">
{{ q["frmAdd"] }}
</div>
{{ script_foot }}