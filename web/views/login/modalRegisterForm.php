<div class="modal fade" id="modalRegister" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Заголовок модального окна -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title" id="myModalRegister">Регистрация</h4>
			</div>

			<!-- Основная часть модального окна, содержащая форму для регистрации -->
			<div class="modal-body">
			<!-- Форма для регистрации -->
				<form role="form" class="form-horizontal" method="post" id="formRegister" action="<?= $url ?>">

				<!-- Блок для ввода логина -->
				<div class="form-group has-feedback">
					<label for="login" class="control-label col-xs-3">Логин:</label>

					<div class="col-xs-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input type="text" class="form-control" required="required" name="login" pattern="[0-9A-Za-z]{4,20}">
						</div>

						<span class="glyphicon form-control-feedback"></span>
					</div>
				</div>

				<!-- Блок для ввода e-mail -->
				<div class="form-group has-feedback">

					<label for="email" class="control-label col-xs-3">Почта (e-mail):</label>
					<div class="col-xs-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="email" class="form-control" required="required" name="email">
						</div>

						<span class="glyphicon form-control-feedback"></span>
					</div>
				</div>



				<!-- Блок для ввода пароля -->
				<div class="form-group has-feedback">
					<label for="password" class="control-label col-xs-3">Пароль:</label>
					<div class="col-xs-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="password" class="form-control" required="required" name="password" pattern="[0-9A-Za-z\-\_]{4,40}">
						</div>

						<span class="glyphicon form-control-feedback"></span>
					</div>
				</div>



			</form>
			</div>

			<!-- Нижняя часть модального окна -->
			<div class="modal-footer">
				<button id="sendR" type="button" class="btn btn-primary">Регистрация</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
			</div>

		</div>
	</div>
</div>


<script>
$(function() {
	$('#sendR').click(function() {
		var FV = true;
		$(document.forms[0].elements).each(function() {

			var formGroup = $(this).parents('.form-group');
			var glyphicon = formGroup.find('.form-control-feedback');

			if (this.checkValidity()) {
				formGroup.addClass('has-success').removeClass('has-error');
				glyphicon.addClass('glyphicon-ok').removeClass('glyphicon-remove');
				}

			else {
				formGroup.addClass('has-error').removeClass('has-success');
				glyphicon.addClass('glyphicon-remove').removeClass('glyphicon-ok');
				FV = false;
				}
		});
	if (FV) {
		$('#modalRegister').modal('hide');
		$('#formRegister').submit();
		}
	});
});
</script>

