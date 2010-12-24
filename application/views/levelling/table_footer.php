</table>
<?
    if(isset($errorMessage))
    {
        echo '<div id="warning">'.$errorMessage.'</div>';
    }
    if (isset($regulation))
    {
        echo $regulation;
    }
?>
    <div id="save_form" style="display:none">
    <fieldset style="margin-bottom:5px;">
      <legend><b>Proje Kaydet</b></legend>
      Etiket: <input type="text" style="text-align:left;" id="tag" name="tag" size="30">
      <input style="text-align:center;" type="button" onClick="save(this.form)" value="Kaydet" /> 
      <small>(Proje kaydedebilmek için bir etiket tanımlamak zorunludur.)</small>
      <div id="saveResult"></div>
    </fieldset>
    </div>
    <center>
    <input style="width:120px; text-align:center;" type="submit" value="Hesapla"/>
<?
    if(!$isEmpty && $isValid){
?>
    <input style="width:120px; text-align:center;" type="button" onClick="show_save_form()" value="Kaydet" />
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
  </center>
</form>
</div>