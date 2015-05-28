<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
		
			<!-- Заголовок модального окна -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title" id="myModalLabel">Авторизация</h4>
			</div>
			
			<!-- Основная часть модального окна, содержащая форму для авторизации -->
			<div class="modal-body">
			<!-- Форма для авторизации -->
				<form role="form" class="form-horizontal" method="post" id="formSend" action="<?= $url ?>">

				<!-- Блок для ввода логина -->
				<div class="form-group has-feedback">
					<label for="login" class="control-label col-xs-3">Логин:</label>
					
					<div class="col-xs-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input type="text" class="form-control" required="required" name="login" pattern="[A-Za-z]{6,}">
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
							<input type="password" class="form-control" required="required" name="password">
						</div>
						
						<span class="glyphicon form-control-feedback"></span>
					</div>
				</div>
				<!-- Конец блока для ввода пароля-->


			</form>
			</div>				

			<!-- Нижняя часть модального окна -->
			<div class="modal-footer">
				<button id="save" type="button" class="btn btn-primary">Войти</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>				
			</div>

		</div>
	</div>
</div>


<script>
$(function() {
	$('#save').click(function() {
		var formValid = true;
		$('input').each(function() {
			var formGroup = $(this).parents('.form-group');
			var glyphicon = formGroup.find('.form-control-feedback');

			if (this.checkValidity()) {
				formGroup.addClass('has-success').removeClass('has-error');
				glyphicon.addClass('glyphicon-ok').removeClass('glyphicon-remove');
				} 
				
			else {
				formGroup.addClass('has-error').removeClass('has-success');
				glyphicon.addClass('glyphicon-remove').removeClass('glyphicon-ok');
				formValid = false;  
				}
		});
		
	if (formValid) {
		$('#modalLogin').modal('hide');	
		$('#success-alert').removeClass('hidden');
		$('#formSend').submit();
		}
	});
});
</script>	

