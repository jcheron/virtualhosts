<!-- DIV FORM LOGIN .col-md-4-->
	<div class="col-md-4" data-wow-delay="0.4s">
		<h3>Connexion utilisateur</h3>
			<p>Veuillez vous connecter s'il vous plaît.</p>
			<div class="connection">
				<form action="login" class="ui form" method="POST" id='frm'>
					<div class="form-group">
						<label for="identifiant">E-mail <span>*</span>:</label>
						<input name="email" type="email"  placeholder="Email" id="mail" class="form-control mail"> 
					</div>
					<div class="form-group">
						<label for="pwd">Mot de passe <span>*</span>:</label>
						<input name="password" type="password" placeholder="Mot de passe" class="form-control" id="pwd">
					</div>
					</br>
					<input type="submit" value="Connexion" class="ui button" id="connexion">
				</form>
			</div>
	</div>
<!-- //DIV FORM LOGIN .col-md-4-->