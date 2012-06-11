<script type="text/javascript">
	    function subscribe(form){
	        if ($("#email").val()=="")
	        {
	            alert("e-Posta alanını boş bırakamazsınız!");
	        }else
	        {
	        	$.post(
	        		"<?php echo base_url(); ?>emaillist/subscribe", 
	        		$("#SubscribtionForm").serialize(),
	        		function(result){
	        		    $("#SubscribtionResult").html(result);
	        		}
	        	);
	        }
	    }
</script>
<ul class="thumbnails">
	<li class="span3">
		<div class="thumbnail">
			<img alt="Hoşgeldiniz" src="<?php echo base_url(); ?>images/welcome.png">
			<div class="caption">
				<h3>Hoşgeldiniz!</h3>
				<p>
					Geomatik Mühendisleri tarafından Geomatik Mühendisleri için tasarlanan Nivelman Hesabı uygulamasına hoşgeldiniz, uygulamayı kullanabilmek 
					için oturum açmanız gerekiyor. Böylece yaptığınız hesapları kaydedebilir
					ve daha sonra tekrar kullanabilirsiniz. Ayrıca sizin için üç farklı tipte örnek 
					projeyi de biz ekliyoruz.
				</p>
				<div class="btn-group">
				    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				    Oturum Açın
				    <span class="caret"></span>
				    </a>
				    <ul class="dropdown-menu">
				    	<li><a href="<?php echo base_url(); ?>user/login_with_google">Google ile Oturum Açın</a></li>
				    	<li><a href="<?php echo base_url(); ?>user/login_with_myopenid">myOpenID ile Oturum Açın</a></li>
				    </ul>
		    	</div>
		    </div>
    	</div>
	</li>
	<li class="span3">
		<div class="thumbnail">
			<img alt="Özellikler" src="<?php echo base_url(); ?>images/features.png">
			<div class="caption">
				<h3>Özellikleri</h3>
				<ul>
					<li>Açık Nivelman Hesabı</li>
					<li>Kapalı Nivelman Hesabı</li>
					<li>Bağlı Nivelman Hesabı</li>
					<li>İstenilen boyutta nivelman hesap tablosu oluşturma</li>
					<li>Hesapları proje olarak kaydedebilme</li>
					<li>Hata hesabı kontrolü</li>
					<li>GUPA servisleri ile çalışır</li>
					<li>Üyelik gerektirmez</li>
					<li><b>ve her zaman ücretsiz!</b></li>
				</ul>
			</div>
		</div>
	</li>
	<li class="span3">
		<div class="thumbnail">
			<img alt="Açık Kaynak" src="<?php echo base_url(); ?>images/opensource.png">
			<div class="caption">
				<h3>Açık Kaynak Kod</h3>
				<p>Bu uygulama sizin istekleriniz için yetersiz mi kaldı?
					O zaman kaynak kodlarını indirin ve özel ihtiyaçlarınıza göre değiştirin.
				</p>
				<p>
					<a class="btn" href="http://github.com/mtrcn/Nivelman-Hesabi">Kaynak Kodlara Ulaşın &raquo;</a>
				</p>
			</div>
		</div>
	</li>
	<li class="span3">
		<div class="thumbnail">
			<img alt="e-Posta Listesi" src="<?php echo base_url(); ?>images/emaillist.png">
			<div class="caption">
				<h3>Haberdar Olun</h3>
				<form id="SubscribtionForm">
					<input class="input-medium" type="text" name="email" placeholder="E-Posta Adresiniz...">
					<input class="btn" type="button" value="Kayıt Ol" onClick="subscribe(this.form)">			
				</form>
				<div id="SubscribtionResult"></div>
			</div>
		</div>
	</li>
</ul>
<div class="well">
	<b>Geomatik Uygulamalar kullanıcılarının hesapları ile ilgili!</b>
	<p>Daha önce kullandığımız Geomatik Uygulamalar lisans sistemi ile oluşturduğunuz projelere ulaşmak için 
	Nivelman Hesabı uygulamasında oturum açıp "Projelerim" sayfasında "GU Projelerimi Yükle" butonuna basın. Böylece Geomatik Uygulamalar hesap numaranızı 
	girerek daha önce oluşturduğunuz projeleri geri yükleyebilirsiniz. 
</div>