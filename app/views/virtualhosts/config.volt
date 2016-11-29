<h1>Configuration de l'hôte virtuel {{ virtualHost.getName() }}</h1>


<div class="ui top attached tabular menu">
  <a class="item active" data-tab="first"><i class="dashboard icon"></i>Récapitulatif</a>
  <a class="item" data-tab="second"><i class="settings icon"></i>Configuration</a>
  <a class="item" data-tab="third"><i class="options icon"></i> Ressources allouées</a>
</div>
<div class="ui bottom attached tab segment active" data-tab="first">
{{ q["infos"] }}
</div>
<div class="ui bottom attached tab segment" data-tab="second">
  
</div>
<div class="ui bottom attached tab segment" data-tab="third">
  
</div>


<script>
$('.menu .item')
.tab()
;
</script>