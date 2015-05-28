
		<form class="form-horizontal" method="post" action="<?= $urlAction ?>">
		
			<div class="form-group">
				<label for="inputS" class="col-xs-5 control-label textInput">Измените фамилию:</label>
				<div class="col-xs-7">
					<input type="text" class="form-control" id="inputS" name="inputS" placeholder="Иванов" value="<?= $valueS ?>">
				</div>
			</div>

			<div class="form-group">
				<label for="inputN" class="col-xs-5 control-label textInput">Измените имя:</label>
				<div class="col-xs-7">
					<input type="text" class="form-control" id="inputN" name="inputN" placeholder="Иван" value="<?= $valueN ?>">
				</div>
			</div>

			<div class="form-group">
				<label for="inputM" class="col-xs-5 control-label textInput">Измените отчество:</label>
				<div class="col-xs-7">
					<input type="text" class="form-control" id="inputM" name="inputM" placeholder="Иванович" value="<?= $valueM ?>">
				</div>
			</div>

			<div class="form-group">
				<label for="inputKey" class="col-xs-5 control-label textInput">Измените роль ФИО:</label>
				<div class="col-xs-7">
					<select class="form-control input-lg" name="inputKey">
						<?= $option ?>
					</select>
				</div>
			</div>			
			
			<div class="form-group">
				<div class="col-xs-offset-5 col-xs-7">
					<button type="submit" class="btn btn-default">Редактировать</button>
				</div>
			</div>
	
		</form>
