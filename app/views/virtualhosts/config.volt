<h1>Configuration de l'hôte virtuel {{ virtualHost.getName() }}</h1>


<div class="ui top attached tabular menu">
  <a class="item active" data-tab="first"><i class="dashboard icon"></i>Récapitulatif</a>
  <a class="item" data-tab="second"><i class="settings icon"></i>Configuration</a>
</div>
<div class="ui bottom attached tab segment active" data-tab="first">
{{ title1 }}
{{ q["infos"] }}

<br />
{{ title2 }}
  <pre>
  	<code class="language-apacheconf">
  		 {{ virtualHost.getConfig() }}
  	</code>
  
  </pre>
</div>
<div class="ui bottom attached tab segment" data-tab="second">
  {{ q["modifier"] }}
  {{ q["importOrExport"] }}

  <div id="uploadExport"></div>
  <div id="modification"></div>
  <pre>
  	<code class="language-apacheconf">
  		 {{ virtualHost.getConfig() }}
  	</code>
  
  </pre>
 
</div>


<script>
$('.menu .item')
.tab()
;
</script>
{{ script_foot }}