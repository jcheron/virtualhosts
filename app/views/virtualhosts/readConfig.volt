<h2 style="padding-top:10px">Séléctionnez un fichier de configuration</h2>

<form action="readConfig/{{ vh.getId() }}" method="post" enctype="multipart/form-data">
Séléctionnez un fichier de configuration : 
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Envoyer" name="submit">
</form>

<pre style="background-color:black; color:green">
##DEBUGGER##
{% if state1 is defined  %}
{{ state1 }}
{% endif %}

{% if state2 is defined  %}
{{ state2 }}
{% endif %}

{% if state3 is defined  %}
{{ state3 }}
{% endif %}

{% if state4 is defined  %}
{{ state4 }}
{% endif %}
</pre>