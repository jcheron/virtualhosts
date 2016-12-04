<!--{{ q["frm"] }}-->
<form class="ui form" action="{{ url("TypeServers/vUpdateSubmit") }}" method="Post">
  <div class="field">
    <label>Nom</label>
    <input type="text" name="name" placeholder="Nom type server" value="{{ typeServer.getName() }}">
  </div>
  <div class="field">
    <label>Template</label>
    <textarea name="configTemplate">{{ typeServer.getConfigTemplate() }}</textarea>
  </div>
  <input type="hidden" name="id" value="{{ typeServer.getId() }}">
  <button class="ui button" type="submit">Submit</button>
</form>