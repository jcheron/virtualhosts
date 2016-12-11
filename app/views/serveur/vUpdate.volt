<div class="ui green segment">
    
    
    <form action="Serveur/vAddSubmit" method="post">
    <h5> Nom du serveur  : </h5>
    {{ name }}
    <h5> Configuration du serveur  :</h5>
     {{ config }}
     <br/><br/>
    {{ q["frmUpdate"] }}
    
    
    </div>
    </form>


* Champ Obligatoire 
{{ script_foot }}