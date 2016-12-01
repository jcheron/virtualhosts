<form action="{{ url("typeServers/vAddSubmit") }}" method="Post">
<div class="ui form">
  <div class="field">
    <label>Nom</label>
    <input type="text" name="name" placeholder="Nom server">
  </div>
  <div class="field">
    <label>Template</label>
    <textarea name="configTemplate" placeholder="Template"></textarea>
  </div>
  <div class="field">
<button class="ui primary button">
  Valider
</button>
<button class="ui button">
  Annuler
</button>
</div>
</div>
</form>