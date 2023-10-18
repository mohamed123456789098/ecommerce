<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @livewireStyles
</head>
<body>

<h6>test</h6>
@livewire('counter')
<?php
 $test = array();
foreach ($color as $val){
   $test[] =  $val->product_color_id;
}

print_r($test);
?>




    @livewireScripts
</body>
</html>
