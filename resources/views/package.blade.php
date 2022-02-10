<!DOCTYPE html>
<html lang="en">

@include('head')

<body>
    @include('nav',$data)

    <table id="package">
        <thead>
            <tr>
                <th>ModelRange</th>
                <th>TrimLines</th>
            </tr>
        </thead>
        <tbody>
            <ul>
                <tr>
                    <?php
                    $modelRanges = $data['modelRange'];
                    $trimLines = $data['trimLine']; ?>

                    <td>
                        <?php foreach ($modelRanges as $modelRange) : ?>
                            <li><?= $modelRange->key ?></li>
                        <?php endforeach ?>
                    </td>
                    <td>
                        <?php foreach ($trimLines as $trimLine) : ?>
                            <li><?= $trimLine->key ?></li>
                        <?php endforeach ?>
                    </td>
                </tr>
            </ul>
        </tbody>
    </table>
</body>

</html>