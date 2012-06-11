</table>
<?
    if(isset($errorMessage))
    {
        echo '<div class="alert">'.$errorMessage.'</div>';
    }
    if (isset($regulation))
    {
        echo $regulation;
    }
?>
    <div id="save_form" style="display:none" class="well form-inline">
      <input class="input-medium" type="text" id="tag" name="tag" placeholder="Bir etiket girin..." >
      <input type="button" class="btn" onClick="save(this.form)" value="Kaydet"/> 
    </div>
    <div id="saveResult"></div>
    <div class="form-actions">
    	<input class="btn btn-primary btn-large" type="submit" value="Hesapla"/>
<?
    if(!$isEmpty && $isValid){
?>
    	<input type="button" class="btn btn-large" onClick="show_save_form()" value="Kaydet"/>
	    <script type="text/javascript">
		    function save(form){
		        if ($("#tag").val()=="")
		        {
		            alert("Etiket alanını boş bırakamazsınız!");
		        }else
		        {
		        	$.post(
		        		"<?php echo base_url(); ?>levelling/save", 
		        		$("#levellingTable").serialize(),
		        		function(result){
		        		    $("#saveResult").html(result);
		        		}
		        	);
		        }
		    }
		    function show_save_form(){
		        $('#save_form').slideDown("slow");
		    }
	    </script>
<?
    }
?>
	</div>
</form>