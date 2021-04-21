<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
    $.ajax({
        url:'/api/product/view.php?product_id=1&lang_id=1',
        success:function(data){
            console.log(data.response);
        },
        error:function(){

        }
    })
    </script>
</body>
</html>