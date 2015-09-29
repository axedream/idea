<!DOCTYPE html>
<html>

<head>

    <?= $this->view['header']['charset'] ?>
    <?= $this->view['header']['description'] ?>
    <?= $this->view['header']['keywords'] ?>
    <?= $this->view['header']['title'] ?>
    <?= $this->view['header']['js'] ?>
    <?= $this->view['header']['css'] ?>
    <?= $this->view['header']['font'] ?>
    
</head>

<body>

    <?= $this->view['content']['header'] ?>

    <?= $this->view['content']['menu']['left-brends'] ?>

    <div class="col-md-8">
        <div class="row ind bodyS">

            <?= $this->view['content']['body'] ?>

        </div>
    </div>

    <div class="col-md-2">
    </div>

    <?= $this->view['content']['footer'] ?>

</body>

</html>