<h2 style="padding-top:10px">Séléctionnez un fichier de configuration</h2>

<form action="readConfig" method="post" enctype="multipart/form-data">
Séléctionnez un fichier de configuration : 
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Envoyer" name="submit">
</form>

{% if state is defined and state == 0 %}
<h3>Aucun fichier n'a été envoyé...</h3>
{% endif %}

{% if state is defined and state == 1 %}
<h3>Envoi effectué avec succés !</h3>
{% endif %}