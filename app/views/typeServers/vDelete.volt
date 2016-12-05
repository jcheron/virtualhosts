<div class="ui red segment">
    <div class="ui error message">
      <i class="close icon"></i>
      <div class="header">
        Voulez-vous vraiment supprimer l'élément {{ element.getName() }}
      </div>
      <ul class="list">
      <form action="{{ url("TypeServers/confirmDelete/") }}{{ element.getId() }}" method="Post">
    	<div class="ui form">
        	<div class="field">
        		<input type="text" name="name" value="" placeholder="Confirmer le nom du type de server">
        	</div>
        	<div class="field">
                <button class="ui red button">
                  Supprimer
                </button>
                <a href="{{ url("typeServers") }}" class="ui button">
                  Annuler
                </a>
            </div>
    	</div>
      </ul>
    </div>
</div><br>