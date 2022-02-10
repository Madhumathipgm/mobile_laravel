<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="/css/navStyle.css" rel="stylesheet" type="text/css">
</head>

<body>
    <header>
        <div class="container">
            <p class="title">MobileReferenceDataItems</p>
            <nav>
                <ul class="nav-links">
                    <div class="dropdown">
                        <button class="dropbtn">Language
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <?php $langs = $data['langs'];
                        $queryParam = $data['queryParam']; ?>
                        <div class="dropdown-content">
                            <?php foreach ($langs as $key => $value) : ?>

                                <a href="/{{$queryParam}}?lang={{$key}}"><?= $value ?></a>

                            <?php endforeach ?>
                        </div>
                    </div>

                    <li><a href="/">Home</a></li>
                    <li><a href="/models">Models</a></li>
                    <li><a href="/categories">Categories</a></li>
                    <li><a href="/carSeals">UsedCarSeal</a></li>
                    <li><a href="/features">Features</a></li>
                    <div class="attributes">
                        <button class="dropbtn">Attributes
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <?php $attributes = $data['attributes'];
                        $queryParam = $data['queryParam']; ?>
                        <div class="attributes-content">
                            <?php foreach ($attributes as $key => $value) : ?>

                                <a href="/attributes/{{$key}}"><?= ucfirst($key) ?></a>

                            <?php endforeach ?>
                        </div>
                    </div>
                </ul>
            </nav>

        </div>


    </header>
</body>