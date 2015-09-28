<!DOCTYPE html>
<html lang="ru">

<head>
    <?= $this->view['header']['charset'] ?>
    <?= $this->view['header']['description'] ?>
    <?= $this->view['header']['keywords'] ?>
    <?= $this->view['header']['title'] ?>
    <?= $this->view['header']['js'] ?>
    <?= $this->view['header']['css'] ?>
</head>

<body>
            <div class="col-md-12">
                <div class="row carousel-holder">
                    <div>HEADER</div>
                </div>
            </div>

            <div class="col-md-2">
                <p class="lead">MENU</p>
                <div class="list-group">
                    <a href="#" class="list-group-item">Category 1</a>
                    <a href="#" class="list-group-item">Category 2</a>
                    <a href="#" class="list-group-item">Category 3</a>
                </div>
            </div>

            <div class="col-md-8">
                <div>ТЕЛО</div>
            </div>

            <div class="col-md-2">
            </div>

</body>

</html>