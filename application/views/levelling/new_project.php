<script type="text/javascript">
  function check_form(form){
    if (form.num_points.value<2)
        alert("Lütfen nokta sayısı için 2 ve ya daha büyük bir sayı girin.");
    else
        form.submit();
  }

  function show_criteria()
  {
	$("#error_limit_2").show();
	$("#error_limit_1").show();
  }

  function hide_criteria()
  {
	$("#error_limit_2").hide();
	$("#error_limit_1").hide();
  }
</script>
<h2>Yeni Proje</h2>
<form method="post" action="<? echo site_url("levelling/table"); ?>">
<table class="table">
	<tr>
		<td width="180px">Nivelman Türü</td>
		<td>: <input name="levelling_type" type="radio" value="free"
			checked="checked" onclick="hide_criteria()" /> Açık <input name="levelling_type" type="radio"
			value="ring" onclick="show_criteria()" /> Kapalı <input name="levelling_type" type="radio"
			value="closed" onclick="show_criteria()" /> Bağlı</td>
	</tr>
	<tr>
		<td>Nokta Sayısı</td>
		<td>: <input type="text" size="5" class="input-small" name="num_points"></td>
	</tr>
	<tr id="error_limit_1" style="display:none">
          <td>Lup Kapanma Sınırı</td>
          <td>: 
            <img src="<?php echo base_url(); ?>images/regulation/wlkucuk.png">
            <input class="input-mini" type="text" value="15" name="WL"><img src="<?=base_url()?>images/regulation/lkm.png"><br>
          </td>
        </tr>
    <tr id="error_limit_2" style="display:none">
          <td>Gidiş-Dönüş Kapanma Sınırı</td>
          <td>: 
            <img src="<?php echo base_url(); ?>images/regulation/wkucuk.png">
            <input type="text" value="12" class="input-mini" name="maxDHI">
            <img src="<?=base_url()?>images/regulation/skm.png">
          </td>
    </tr>
</table>			
<input class="btn btn-large" type="button" onclick="javascript:check_form(this.form)" value="Devam >>" />
</form>
<div class="alert alert-info">
		<ul>
			<li>Yeni bir proje oluşturmak için <b>Nivelman Türü</b> ve <b>Nokta Sayısı</b> kısımlarını doldurun.</li>
			<li>Kapalı ve bağlı nivelmanda kapanma sınır değerlerine ne gireceğinizi bilmiyorsanız Büyük Ölçekli Harita ve Harita Bilgileri Üretim Yönetmeliği(2005) Madde-37 ve Madde-38'i inceleyin.</li>
			<li>Varsayılan olarak gelen değerler ana nivelman ağı içindir. </li>		
		</ul>
</div>