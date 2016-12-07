<style>
.js .input-file-container {
  position: relative;
  width:100%;
}
.js .input-file-trigger {
  display: block;
  padding: 14px 45px;
  background: #DF0101;
  color: #fff;
  font-size: 1em;
  transition: all .4s;
  cursor: pointer;
  text-align:center;
}
.js .input-file {
  position: absolute;
  top: 0; left: 0;
  width: 225px;
  padding: 14px 0;
  opacity: 0;
  cursor: pointer;
}
 
/* quelques styles d'interactions */
.js .input-file:hover + .input-file-trigger,
.js .input-file:focus + .input-file-trigger,
.js .input-file-trigger:hover,
.js .input-file-trigger:focus {
  background: black;
  color: white;
}
 
/* styles du retour visuel */
.file-return {
  margin: 0;
}
.file-return:not(:empty) {
  margin: 1em 0;
}
.js .file-return {
  font-style: italic;
  font-size: .9em;
  font-weight: bold;
}
/* on complète l'information d'un contenu textuel
   uniquement lorsque le paragraphe n'est pas vide */
.js .file-return:not(:empty):before {
  content: "Fichier selectionné : ";
  font-style: normal;
  font-weight: normal;
}
</style>

<h2 style="padding-top:10px">Séléctionnez un fichier de configuration</h2>

{{ q["virtualHosts"] }}
<div class="input-file-container">
  <input class="input-file" id="my-file" type="file">
  <label for="my-file" class="input-file-trigger" tabindex="0">Parcourir</label>
</div>
<p class="file-return"></p>

<script>
//ajout de la classe JS à HTML
document.querySelector("html").classList.add('js');
 
// initialisation des variables
var fileInput  = document.querySelector( ".input-file" ),  
    button     = document.querySelector( ".input-file-trigger" ),
    the_return = document.querySelector(".file-return");
 
// action lorsque la "barre d'espace" ou "Entrée" est pressée
button.addEventListener( "keydown", function( event ) {
    if ( event.keyCode == 13 || event.keyCode == 32 ) {
        fileInput.focus();
    }
});
 
// action lorsque le label est cliqué
button.addEventListener( "click", function( event ) {
   fileInput.focus();
   return false;
});
 
// affiche un retour visuel dès que input:file change
fileInput.addEventListener( "change", function( event ) {  
    the_return.innerHTML = this.value;  
});
</script>