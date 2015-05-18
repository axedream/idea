<button type="button" class="btn btn-lg btn-danger" data-toggle="popover" title="<?= $textTitle ?>" data-content="<?= $baseText ?>"><?= $textButton ?></button>
<script>
  $(function () {
	$('[data-toggle="popover"]').popover()
  })
</script>