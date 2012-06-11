<script type="text/javascript" src="<?php echo base_url(); ?>java_scripts/tablecloth.js"></script>
<script type="text/javascript">
  function comma_block(that) {
    that.value = that.value.replace(/,/g,".");
  }
</script>
<h2><?php echo $title; ?></h2>
  <form class="form-inline" id="levellingTable" action="<?=base_url()?>levelling/calculate" method="post">
    <input type="hidden" name="num_points" value="<?php echo $numPoints; ?>">
    <input type="hidden" name="levelling_type" value="<?php echo $levellingType;?>">
    <input type="hidden" name="WL" value="<?php echo $WL; ?>">
    <input type="hidden" name="maxDHI" value="<?php echo $maxDHI; ?>">
    <table class="table table-striped">
        <thead>
	        <tr>
	          <th rowspan="2">Nokta<br>No</th>
	          <th colspan="2">Gidiş Nivelmanı</th>
	          <th colspan="2">Dönüş Nivelmanı</th>
	          <th rowspan="2">f<sub>hi</sub><br>(mm)</th>
	          <th rowspan="2">d<sub>hi</sub><br>(mm)</th>
	          <th colspan="2">Ortalama</th>
	          <th rowspan="2">V<sub>hi</sub><br>(mm)</th>
	          <th rowspan="2">Düzeltilmiş<br/>Deltah<sub>i</sub></th>
	          <th rowspan="2">H<br>(m)</th>
	        </tr>
	        <tr>
	          <th>deltah<sub>i</sub><br>(m)</th>
	          <th>l<sub>i</sub><br>(m)</th>
	          <th>deltah<sub>i</sub><br>(m)</th>
	          <th>l<sub>i</sub><br>(m)</th>
	          <th>deltah<sub>i</sub><br>(m)</th>
	          <th>l<sub>i</sub><br>(m)</th>
	        </tr>
        </thead>