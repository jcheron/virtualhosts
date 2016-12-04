{{ q["btnAdd"] }}
<div class="page-header">
    <h1>Type Servers</h1>
</div>
<div id="divAdd"></div>
<!--{{ q['table'] }}-->   
<table class="ui single line table">
  <thead>
    <tr>
      <th>id</th>
      <th>Nom</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
  {% for typeServer in typeServers %}
    <tr>
      <td>{{ typeServer.getId() }}</td>
      <td>{{ typeServer.getName() }}</td>
      <td><a href="{{ url("TypeServers/vUpdate/") }}{{ typeServer.getId() }}" class="ui secondary button">Modifier</a>
		<a href="#" id="btn" class="ui button">Supprimer</a></td>
    </tr>
<div class="ui modal">
    <div class="header">
      Changing Your Thing
    </div>
    <div class="content">
      <p>Do you want to change that thing to something else?</p>
    </div>
    <div class="actions">
      <div class="ui negative button">
        No
      </div>
      <div class="ui positive right labeled icon button">
        Yes
        <i class="checkmark icon"></i>
      </div>
      <a href="{{ url("TypeServers/delete/") }}{{ typeServer.getId() }}" class="ui button">Supprimer</a>
    </div>
</div>
    {% endfor %}
  </tbody>
</table>

<script>
$('#btn').click(function(){
$('.ui.modal').modal('show');
});
</script>