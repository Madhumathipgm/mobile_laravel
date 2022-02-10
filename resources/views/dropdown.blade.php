<?php
function createDropDown(string $id, string $name, string $label, $data)
{ ?>

    <div class="form-group" xmlns="http://www.w3.org/1999/html">
        <form action='' class="form_control" id="postForm">


            <label for="<?= $id ?>"><?= $label ?></label>
            <select id="<?= $id ?>" name="<?= $name ?>" class="dropdown_control" @if ($name==="classes" ): onchange="getCategoryAndMake('<?= $id ?>','<?= $name ?>','<?= $data['lang'] ?>','qscategory','qsmake')" @elseif ($name==="makes" ): onchange="getModelsWithGroup('<?= $id ?>','<?= $name ?>','<?= $data['lang'] ?>','qsclass','qsmodel')" @elseif ($name==="models" ): onchange="getModelRangeAndTrimLine('<?= $id ?>','<?= $name ?>','<?= $data['lang'] ?>','qsclass','qsmake','qsmodelrange','qstrimline')" @endif>

                <?php if ($name === "classes") :
                    selectOption($data['classes'], $data['text'], $name);
                elseif ($name === "categories") :
                    selectOption($data['categories'], $data['text'], $name);
                elseif ($name === "makes") :
                    selectOption($data['makes'], $data['text'], $name);
                elseif ($name === "models") :
                    selectOption($data['models'], $data['text'], $name);
                elseif ($name === "modelRanges") :
                    selectOption($data['modelRanges'], $data['text'], $name);
                elseif ($name === "trimLines") :
                    selectOption($data['trimLines'], $data['text'], $name);
                endif; ?>

            </select>
        </form>
    </div>
    <script>
    </script>
<?php } ?>
<?php
function selectOption($items, $text, $name)
{ ?>
    <option value="" selected>All <?= $name ?></option>
    <?php foreach ($items as $item) : ?>
        <option value="{{$item->key}}"> {{$item->$text}} </option>
<?php endforeach;
} ?>