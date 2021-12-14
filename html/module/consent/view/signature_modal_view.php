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
<script type="text/javascript" src="../assets/JS/contact.js"/></script>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Edit/Consent</h4>
				<?php //print_r($branch_id_FK); ?>
			</div>

			<div class="modal-body">	
				<div id="signature"></div>
		        <hr>
		        <button id="clear">Clear</button>
		        <button id="save">Save</button>
				<div id="consent_form_div"></div>	
			</div>
		</div>
	</div>
</div>
