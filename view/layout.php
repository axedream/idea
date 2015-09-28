<!DOCTYPE html>
<html lang="ru">

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
            <div class="col-md-12 header">
                <div class="row carousel-holder">
                    <div class="textHeader">Супер магазин супер обуви</div>
                </div>
            </div>

            <div class="col-md-12 mheader"></div>

            <div class="col-md-2 leftMenu">
                <div class="headerM">Марки обуви:</div>
                <div class="list-group">
                    <a href="#" class="list-group-item">Марка 1</a>
                    <a href="#" class="list-group-item">Марка 2</a>
                    <a href="#" class="list-group-item">Марка 3</a>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row ind">
                    <?= $this->view['content'] ?>
                </div>
            </div>

            <div class="col-md-2">
            </div>

            <div class="navbar-fixed-bottom row-fluid">
                    <div class="container footer col-md-12">
                        <div class="textFooter">© IDEA, 2015</div>
                    </div>
            </div>

</body>

</html>