<!DOCTYPE html>
<html lang="en">

<head>
    <link href="\css\dropdownStyle.css" rel="stylesheet" type="text/css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="\js\script1.js"></script>
    <title>MobileReferenceItem</title>
</head>

<body>
    @include('nav',$data)
    <div class="col-1">
        @include('dropdown')
        <?php
        createDropDown('qsclass', 'classes', 'Class', $data);
        createDropDown('qscategory', 'categories', 'Category', $data);
        createDropDown('qsmake', 'makes', 'Make', $data);
        createDropDown('qsmodel', 'models', 'Model', $data);
        createDropDown('qsmodelrange', 'modelRanges', 'ModelRange', $data);
        createDropDown('qstrimline', 'trimLines', 'TrimLines', $data);
        /*createDropDown('qscarseal', 'usedcarseal', 'UsedCarSeal', $data);
        createDropDown('qsfeature', 'features', 'Features', $data);*/ ?>

    </div>
</body>

</html>