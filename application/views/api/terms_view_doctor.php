<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title></title>

    <style type="text/css">
        body{ font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif; margin:0; }

        .AboutArea{ padding:15px 25px}
        .AboutArea h3{margin: 0 0 13px;font-size: 28px;font-weight:700;text-transform:uppercase;line-height: 28px;padding: 0 0 5px;position: relative;}
        .AboutArea h3:after{content: '';position: absolute;bottom: 0;left: 0;width: 125px;height: 2px;background-color: #000;}
        .AboutArea p{ margin:0 0 10px; font-size:15px; line-height:24px; color:#3c3b3b; font-family:'Arial'}
        .AboutArea ul{ margin:0 0 10px 0}
        .AboutArea ul li{ font-size:16px; line-height:27px; color:#3c3b3b}

    </style>
 

</head>
<body>
 
    <section>
        <div class="AboutArea">
            <h3><?= ucwords($terms->title)  ?></h3>

            <p><?= $terms->description ?></p>


         


           
        </div>
    </section>

 

</body>
</html>