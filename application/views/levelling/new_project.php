<script type="text/javascript">
  function check_form(form){
    if (form.num_points.value<2)
        alert("Lütfen nokta sayısı için 2 ve ya daha büyük bir sayı girin.");
    else
        form.submit();
  }

  function show_error()
  {
	$("#error_limit_2").show();
	$("#error_limit_1").show();
  }

  function hide_error()
  {
	$("#error_limit_2").hide();
	$("#error_limit_1").hide();
  }
</script>
<h1>Yeni Proje</h1>
<form method="post" action="<? echo site_url("levelling/table"); ?>">
<table width="100%">
	<tr>
		<td width="180px">Nivelman Türü</td>
		<td>: <input name="levelling_type" type="radio" value="free"
			checked="checked" onclick="hide_error()" /> Açık <input name="levelling_type" type="radio"
			value="ring" onclick="show_error()" /> Kapalı <input name="levelling_type" type="radio"
			value="closed" onclick="show_error()" /> Bağlı</td>
	</tr>
	<tr>
		<td>Nokta Sayısı</td>
		<td>: <input type="text" size="5" style="text-align: center;"
			name="num_points"></td>
	</tr>
	<tr id="error_limit_1" style="display:none">
          <td>Lup Kapanma Sınırı</td>
          <td>: 
            <img src="<?php echo base_url(); ?>images/regulation/wlkucuk.png" align="absbottom"><input type="text" size="1" value="15" style="text-align:center;" name="WL"><img src="<?=base_url()?>images/regulation/lkm.png" align="absbottom"><br>
          </td>
        </tr>
    <tr id="error_limit_2" style="display:none">
          <td>Gidiş-Dönüş Kapanma Sınırı</td>
          <td>: 
            <img src="<?php echo base_url(); ?>images/regulation/wkucuk.png" align="absbottom"><input type="text" value="12" size="1" style="text-align:center;" name="maxDHI"><img src="<?=base_url()?>images/regulation/skm.png" align="absbottom">
          </td>
    </tr>
	<tr>
		<td colspan="2" align="center">
			<input style="width: 200px; text-align: center;" type="button"
	onclick="javascript:check_form(this.form)" value="Devam >>" />
		</td>
	</tr>
</table>
</form>
<div id="help">
	<div class="helpItem">
		<p>
		- Yeni bir proje oluşturmak için <b>Nivelman Türü</b> ve <b>Nokta Sayısı</b> kısımlarını doldurun.
		<br/>
		- Kapalı ve bağlı nivelmanda kapanma sınır değerlerine ne gireceğinizi bilmiyorsanız Büyük Ölçekli Harita ve Harita Bilgileri Üretim Yönetmeliği(2005) Madde-37 ve Madde-38'i inceleyin.
		<br/>
		- Varsayılan olarak gelen değerler ana nivelman ağı içindir. 
		</p>
	</div>
</div>
</div>
