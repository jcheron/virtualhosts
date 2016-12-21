<h2 style="padding-top:10px">Séléctionnez un fichier de configuration</h2>

<form action="/VirtualHosts/VirtualHosts/readConfig/{{ vh.getId() }}" method="post" enctype="multipart/form-data">
Séléctionnez un fichier de configuration : 
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Envoyer" name="submit">
</form>

{% if q["state"] is defined %}
{{ q["state"] }}
{% endif %}