<!DOCTYPE html>
<html lang="en">

@include('head')

<body>
    @include('nav',$data)
    <?php $values = $data['values'];
    $textLang = $data['text'];
    $text = $data['queryParam'];
    $attribute = $data['attribute'] ?>
    <table id="attributes">

        <thead>
            <tr>
                <th><?= ucfirst($attribute); ?></th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td>
                    <ol type="1" class="attr-list">
                        <?php

                        foreach ($values as $val) : ?>


                            <li> <?= $val->$textLang ?>
                            </li>



                        <?php endforeach ?>
                    </ol>
                </td>
            </tr>

        </tbody>
    </table>
</body>

</html>