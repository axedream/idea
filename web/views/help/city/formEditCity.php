
		<form class="form-horizontal" method="post" action="<?= $urlAction ?>">
		
			<div class="form-group">
				<label for="inputCity" class="col-xs-5 control-label textInput">Измените наименование города:"</label>
				<div class="col-xs-7">
					<input type="text" class="form-control" id="inputCity" name="inputCity" value="<?= $value ?>">
				</div>
			</div>
	

			<div class="form-group">
				<div class="col-xs-offset-5 col-xs-7">
					<button type="submit" class="btn btn-default">Редактировать</button>
				</div>
			</div>

			
		</form>
