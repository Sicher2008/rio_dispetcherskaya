<style>
	.foau {
		margin: 0 auto;
		width: 321px;
	}
	div.foau input {
		width: 318px;
	}
	div.foau h3 {
		text-align: center;
	}
</style>
<div class="foau">
	<h3>Добро пожаловать</h3>
	<form action="/" method="post">
		<p>
			<label>Имя пользователя:<br></label>
			<input name="login" type="text" size="15" maxlength="15">
		</p>
		<p>
			<label>Пароль:<br></label>
			<input name="password" type="password" size="15" maxlength="15">
		</p>

		<p>
			<input type="submit" name="save" value="Войти" style="width: 150px;margin-left: 80px;"><br>
		</p>
	</form>
</div>