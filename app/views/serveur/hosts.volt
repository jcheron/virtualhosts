<div class="header">


    <div id = "tab">
        <div class="ui positive message">
        <h3> Liste des machines : </h3>
        
          <p>Séléctionner une machine pour visualiser la liste des serveurs installés. </p>
             <p>Vous ne pouvez pas supprimer un serveur temp que tout ses virtualhosts soit supprimés </p>
         
          </div> <br />
        
        
        {{ q["lst-hosts"] }}
        
        <div id="servers" class="ui segment"></div>
        <div id="divAction"></div>
    </div>
</div>
{{ script_foot }}
