<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>Phalcon PHP Framework</title>
{{stylesheet_link("https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.6/semantic.min.css")}}
{{stylesheet_link("https://cdnjs.cloudflare.com/ajax/libs/prism/1.5.1/themes/prism-okaidia.min.css")}}
{{stylesheet_link("public/css/styles.css")}}
{{javascript_include("https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js")}}

</head>
<body>
	<header class="navbar navbar-static-top bs-docs-nav" id="top"
		role="banner">
		<div class="ui container">
			<div class="ui menu secondary">
				<div class="header item">
					<i class="snapchat ghost big link icon"></i>
					Virtualhosts
				</div>
				<a class="item">Features</a> <a class="item">Testimonials</a> <a
					class="item">Sign-in</a>
			</div>
		</div>
	</header>
	<div class="pagehead">
		<div id="secondary-container" class="ui container">
			{{ q["secondary"] }}
		</div>
	</div>
	<div id="main-container" class="ui container">
		<div id="tools-container">
			{{ q["tools"] }}
		</div>
		<div id="content-container" class="ui segment">{{ content() }}</div>
	</div>
	<footer>
		<div class="ui container">Mentions légales :
			<ul>
				<li><a href="https://phalconphp.com/fr/">© 2016 phalcon 3.0</a></li>
				<li><a href="http://phpmv-ui.kobject.net/">© 2016 phpMv-UI 2.0</a></li>
			</ul>
		</div>
	</footer>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<!-- Latest compiled and minified JavaScript -->
	{{javascript_include("https://cdnjs.cloudflare.com/ajax/libs/prism/1.5.1/prism.min.js")}}
	{{javascript_include("https://cdnjs.cloudflare.com/ajax/libs/prism/1.5.1/components/prism-apacheconf.min.js")}}
	{{javascript_include("https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.6/semantic.min.js")}}
	{% if script_foot is defined %}
	{{ script_foot }}
	{% endif %}
</body>
</html>
