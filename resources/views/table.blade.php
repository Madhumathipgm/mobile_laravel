<!DOCTYPE html>
<html lang="en">

@include('head')

<body>
    @include('nav',$data)
    <div class="toggle">

        Toggle column: <a class="toggle-vis" data-column="0">Class</a> - <a class="toggle-vis" data-column="1">Make</a> - <a class="toggle-vis" data-column="2">Model</a> - <a class="toggle-vis" data-column="3">ModelGroup</a>
    </div>

    <div class="table-content">
        <table id="modelsTable">
            <thead>
                <tr>
                    <th>Class</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>ModelGroup</th>
                </tr>

            </thead>
            <tbody>

                <?php
                $textLang = $data['textLang'];
                $classes = $data['classes'];
                $makes = $data['makes'];
                $models = $data['models'];
                $modelGroups = $data['modelGroups'];
                foreach ($classes as $class) :
                    if ($class->key !== 'Car') :
                        continue;
                    endif;
                    $make_items = $makes[$class->key] ?? [];
                    foreach ($make_items as $make) :
                        if (!isset($models[$make->key])) :
                            continue;
                        endif;
                        $model_items = $models[$make->key]; ?>

                        <?php foreach ($model_items as $model) : ?>
                            <tr>
                                <td><?= $class->$textLang ?></td>
                                <td><?= $make->$textLang ?></td>
                                <td><a href="/packages/<?= $model->key ?>"><?= $model->$textLang ?></a></td>


                                <td>
                                    <?php $modelGroup = isset($modelGroups[$model->key . $make->key]) ? $modelGroups[$model->key . $make->key]->key : '' ?>
                                    <?= $modelGroup ?>
                                </td>


                            <?php endforeach; ?>

                        <?php endforeach; ?>
                    <?php endforeach; ?>
                            </tr>

            </tbody>


        </table>
    </div>


</body>

</html>