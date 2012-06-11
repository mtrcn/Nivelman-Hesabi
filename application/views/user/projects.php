	<script type="text/javascript">
		function deleteProject(id)
		{
			if (confirm('Silmek istediğinize emin misiniz?'))
			{
				window.location='<?php echo site_url("levelling/delete"); ?>/'+id;
			}
		}
	</script>
<h2>Projeler</h2>
<p>
    Aşağıda daha önce kaydettiğiniz projeleri görüyorsunuz.
</p>
<div>
<table class="table">
	<thead>
    	<tr><th width="17%">Tarih</th><th width="15%">Nivelman Türü</th><th>Etiket</th><th width="15%">İşlemler</th></tr>
<?php
$title_tr=array('free' => 'Açık Nivelman','ring' => 'Kapalı Nivelman','closed' => 'Bağlı Nivelman');
if ($projects->num_rows()>0)
{
	foreach ($projects->result() as $project)
	{
?>
		<tr>
			<td><?php echo date('d.m.Y H:i',$project->date); ?></td>
			<td><?php echo $title_tr[$project->type]; ?></td>
			<td><?php echo $project->tag; ?></td>
			<td align="center">
				<button class="btn btn-large" onClick="javascript:window.location='<?php echo site_url("levelling/open/".$project->pid); ?>'">Aç</button>
				<button class="btn btn-danger btn-large" onClick="deleteProject(<?php echo $project->pid; ?>)">Sil</button>
			</td>
		</tr>
<?php
	}
}else
{
?>
   		<tr><td colspan="4" align="center">Henüz kayıtlı bir projeniz yok, yeni bir proje oluşturmak için <a href="<?php echo site_url("levelling/new_project"); ?>">buraya tıklayın.</a></td></tr>
<?php 
}
?>
    </table>
    <div class="alert alert-info">
    	Daha önce Geomatik Uygulamalar Lisans Sistemi ile kaydettiğiniz projeleri yüklemek için butona tıklayın. 
    	<a href="#LoadGUProjectsForm" data-toggle="modal"  class="btn">GU Projelerimi Yükle</a>
    </div>
    <div class="alert alert-info">
    	Kaydettiğiniz bir projeyi listeden açarak çalışmanıza devam edebilir veya silebilirsiniz.
    </div>
</div>
<script type="text/javascript">
	    function LoadGUProjects(form){
	        if ($("#id").val()=="")
	        {
	            alert("Hesap Numarası alanını boş bırakamazsınız!");
	        }else
	        {
	        	$.post(
	        		"<?php echo base_url(); ?>user/load_gu_projects", 
	        		$("#LoadGUProjectsForm").serialize(),
	        		function(result){
	        		    $("#LoadGUProjectsResult").html(result);
	        		}
	        	);
	        }
	    }
</script>
<form class="modal hide" id="LoadGUProjectsForm" action="<?php echo base_url(); ?>user/loadGUProjects" method="post">
    <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal">×</button>
	    <h3>GU Lisans Projelerini Yükle</h3>
    </div>
    <div class="modal-body">
   		<label for="id">GU Üye Hesap Numarası:</label>
	    <input type="text" name="id" id="id"/>
	    <div id="LoadGUProjectsResult"></div>
	</div>
    <div class="modal-footer">
	    <a href="<?php echo base_url(); ?>user/projects" class="btn">Kapat</a>
	    <input type="button" class="btn btn-primary" value="Yükle" onClick="LoadGUProjects(this.form)"/>
	</div>
</form>