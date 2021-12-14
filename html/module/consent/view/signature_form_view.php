<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<script>
    $(document).ready(function() {
        $sig = $("#signature").jSignature();
        $('#save').click(function() {
            datapair = $sig.jSignature("getData", "svg");
            $('#sigstring').text(datapair[1]);

            var canvas = document.querySelector("canvas")
            context = canvas.getContext("2d");

            var image = new Image;
            image.src = "data:" + datapair[0] + "," + datapair[1];
            $(image).appendTo($("#PNGsignature"));

            context.drawImage(image, 0, 0);
            var a = document.createElement("a");
            a.download = "fallback.png";
            a.href = canvas.toDataURL("image/png");
            $.ajax({
                url:'../controller/save_config.php', 
                type:'POST', 
                data:{
                    data:a.href
                }
            });
        });
        $('#clear').click(function() {
            $sig.jSignature("clear");
        });
    });
</script>
<div>
    <div id="signature"></div>
    <hr>
    <button id="clear">Clear</button>
    <button id="save">Save</button>
    <div id="consent_form_div"></div>   
</div>