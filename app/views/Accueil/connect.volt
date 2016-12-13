<!-- DIV FORM LOGIN .col-md-4-->
	<div class="col-md-4" data-wow-delay="0.4s">
		<h3>Connexion utilisateur</h3>
			<div class="connection">
				<form action="login" class="ui form" method="POST" id='frm'>
				<div class="two fields">
					<div class="form-group">
					<div class="field">	
						<label for="identifiant">E-mail :<i class="asterisk red icon"></i></label>
						<input name="email" type="email"  placeholder="Email" id="mail" class="form-control mail"> 
						</div>
					</div>
					<div class="form-group">
					<div class="field">					
						<label for="pwd">Mot de passe : <i class="asterisk red icon"></i></label>
						<input name="password" type="password" placeholder="Mot de passe" class="form-control" id="pwd">
					</div>
					</div>
					</br>
					</div>
					<label><i class="asterisk red icon"></i> Champs obligatoires </label>
					</br>
					{{ q['frm'] }}
					</br>
					<input type="submit" value="Connexion" class="ui button" id="connexion">
				</form>
			</div>
			
			 
	</div>
<!-- //DIV FORM LOGIN .col-md-4-->