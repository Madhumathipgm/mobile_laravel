<!DOCTYPE html>
<html lang="en">

@include('head')

<body>
    @include('nav',$data)
    <?php $classes = $data['classes'];
    $textLang = $data['text'];
    $text = $data['queryParam'];
    $refItems = $data[$text]; ?>
    <table id="<?= $text ?>">

        <thead>
            <tr>
                <th>Class</th>
                <th><?= ucfirst($text) ?></th>
            </tr>
        </thead>
        <tbody>
            <ul>
                <?php
                foreach ($classes as $class) : ?>
                    <tr>
                        <td> <?= $class->$textLang ?></td>
                        <td>
                            <?php $items = isset($refItems[$class->key]) ? $refItems[$class->key] : '';
                            foreach ($items as $item) : ?>
                                <li><?= $item->$textLang ?></li>
                            <?php endforeach ?>
                        </td>

                    <?php endforeach ?>

                    </tr>
            </ul>
        </tbody>
    </table>
</body>

</html>