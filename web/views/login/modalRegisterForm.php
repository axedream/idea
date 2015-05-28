<div class="modal fade" id="modalRegister" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">

			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title" id="myModalLabel">Форма запроса на регистрацию</h4>
			</div>
			
			<div class="modal-body">
			
				<form class="form-horizontal">
				
				<div class="form-group">
					<label class="control-label col-xs-3" for="userName">Логин:</label>
					<div class="col-xs-9">
						<input type="text" class="form-control" id="userName" placeholder="superuser">
					</div>
				</div>


				<div class="form-group">
					<label class="control-label col-xs-3" for="inputEmail">Email:</label>
					<div class="col-xs-9">
						<input type="email" class="form-control" id="inputEmail" placeholder="Email">
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-xs-3" for="inputPassword">Пароль:</label>
					<div class="col-xs-9">
						<input type="password" class="form-control" id="inputPassword" placeholder="Введите пароль">
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-xs-3" for="confirmPassword">Подтвердите пароль:</label>
					<div class="col-xs-9">
						<input type="password" class="form-control" id="confirmPassword" placeholder="Введите пароль ещё раз">
					</div>
				</div>

			</form>
			</div>

				
			<div class="modal-footer">
				<div class="col-xs-offset-3 col-xs-9">
					<button id="save" type="button" class="btn btn-primary">Отправить запрос</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				</div>
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
		$('#modalRegister').modal('hide');	
		$('#success-alert').removeClass('hidden');
		$('#formSend').submit();
		}
	});
});
</script>	

