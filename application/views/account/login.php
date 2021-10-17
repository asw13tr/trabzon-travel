<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web:300,300i,400,400i,600,700&amp;subset=latin-ext" rel="stylesheet">
	<style>
		*:hover, *:active, *:focus{ outline: none !important; }
		html, body, div, span, applet, object, iframe,
		h1, h2, h3, h4, h5, h6, p, blockquote, pre,
		a, abbr, acronym, address, big, cite, code,
		del, dfn, em, img, ins, kbd, q, s, samp,
		small, strike, strong, sub, sup, tt, var,
		b, u, i, center,
		dl, dt, dd, ol, ul, li,
		fieldset, form, label, legend,
		table, caption, tbody, tfoot, thead, tr, th, td,
		article, aside, canvas, details, embed, 
		figure, figcaption, footer, header, hgroup, 
		menu, nav, output, ruby, section, summary,
		time, mark, audio, video {
			margin: 0;
			padding: 0;
			border: 0;
			font-size: 100%;
			font: inherit;
			vertical-align: baseline;
			font-family: 'Titillium Web', Arial, sans-serif;
		}
		/* HTML5 display-role reset for older browsers */
		article, aside, details, figcaption, figure, 
		footer, header, hgroup, menu, nav, section {
			display: block;
		}
		html {
			height: 100%;
			overflow-x: hidden;
			box-sizing: border-box;
		}
		body {
			line-height: 1;
			box-sizing: border-box;
			background-image: url('<?php echo base_url('assets/imgs/login-background.png'); ?>'); 
			background-position: center;
			background-repeat: no-repeat;
			background-size: cover;
			margin: 0px;
			min-height: 100%;
			position: relative;
			display: block;
		}
		ol, ul {
			list-style: none;
		}
		blockquote, q {
			quotes: none;
		}
		blockquote:before, blockquote:after,
		q:before, q:after {
			content: '';
			content: none;
		}
		table {
			border-collapse: collapse;
			border-spacing: 0;
		}
		#login{
			max-width: 400px;
			padding: 0; margin:0 auto;
			background-color: white;
			margin-top: 50px;

		}
		#login form{display: block; overflow: hidden; margin: 0; padding: 10px 0;}
		#login h3{display: block; padding: 30px 0px; text-align: center; color: white; font-weight: 700; letter-spacing: 0.3px; font-size: 30px; 
			background: url('<?php echo base_url('assets/imgs/login-background.png'); ?>') no-repeat center bottom;  }
		#login p{ margin: 20px 10px; padding: 0; }
		#login input{ width: 96%; margin: 0; padding: 10px 5px; border: none; border-bottom: 1px solid #E0E0E0;
			font-weight: 500;font-size: 16px; }
		#login button{ display: inline-block; padding: 10px 30px; border: none; border-radius: 3px; background-color: #43ACD9; color: white; font-weight: 600; cursor: pointer;}
		#login button:hover{ background-color: #3490B7; }

		p.success, p.error{ display: block !important; margin: 0 !important; padding: 15px !important; font-weight: 500; font-size: 1.1em; }
		p.success{ background-color: #CCFFCC; color: #339933; }
		p.error{ background-color: #FFCCCC; color:#993333 ; }
		
	</style>
	<script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js'); ?>"></script>
</head>
<body>

	<div id="login">
	<h3>Giriş Yap</h3>
	<?php if(isset($login_status)){
		if($login_status[0] == true){
			echo "<p class='success'>{$login_status[1]}</p>";
		}else{
			echo "<p class='error'>{$login_status[1]}</p>";
		}
	} ?>
	<form action="" method="POST">
		<p><input type="text" placeholder="Kullanıcı Adı" name="trvluname" /></p>
		<p><input type="password" placeholder="Parola" name="trvlpword" /></p>
		<p><button>Giriş Yap</button></p>
	</form>
	</div>
	<script>
		/*
		var w_login_outher = $('#login').outerWidth();
		var h_login_outher = $('#login').outerHeight();
		var login_left_margin 	= '-' + (w_login_outher / 2);
		var login_top_margin 	= '-' + (h_login_outher / 2);
		$('#login').attr('style','margin-top: '+login_top_margin+'px; margin-left: '+login_left_margin+'px;' );
*/


	</script>
	
</body>
</html>