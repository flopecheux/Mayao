<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/EN/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Mayao</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
@media screen and (max-width: 480px), screen and (max-device-width: 480px) {
*[class].resize {
	width: 320px !important;
	height: auto !important;
	text-align: center !important;
}
*[class].hide {
	width: 0px !important;
	height: 0px !important;
	display: none !important;
}
*[class].texte_center {
	width: 320px!important;
	text-align: center !important;
	padding:10px !important;
	/*padding-left: 10px!important;*/
	height: auto !important;
}
img[class="centpourcent"] {
	width: 160px;
	height: auto;
	padding-top: 5px !important;
}
td[class="ninja"] {
	width: 160px !important;
	height: auto !important;
	float: left;
	display: block !important;
}
}
</style>
</head>
<body bottommargin="0" topmargin="0" rightmargin="0" leftmargin="0" marginheight="0" marginwidth="0" alink="#000000" vlink="#000000" link="#000000" bgcolor="#ffffff">
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff">
  <tr>
    <td align="center" valign="top" style="font-size: 0px">
<table id="Tableau_01" width="640" border="0" cellpadding="0" cellspacing="0" class="resize">
	<tr>
		<td class="texte_center" width="640" height="25" style="font-family:Arial; font-size:10px; color:#000000; text-decoration:none; text-align:center;">
			Si cet email ne s'affiche pas correctement, vous pouvez le visualiser 
            <a href="" style="color:#000000; text-decoration:none;" target="_blank"><u>gr&acirc;ce &agrave; ce lien</u></a></td>
	</tr>
    <tr>
       <td align="left" style="font-size:0px"><table align="left" border="0" cellpadding="0" cellspacing="0" width="640" class="resize">
        <tr>
            <td class="hide" width="120">
                <a href="http://www.mayao.fr" target="_blank">
                <img src="{{ url('img/email/006_Nouveau_message/logo1.gif') }}" width="120" height="171" alt="" border="0"></a></td>
            <td class="resize" width="397">
                <a href="http://www.mayao.fr" target="_blank">
                <img src="{{ url('img/email/006_Nouveau_message/logo2.gif') }}" width="397" height="171" alt="" border="0" class="resize"></a></td>
            <td class="hide" width="123">
                <a href="http://www.mayao.fr" target="_blank">
                <img src="{{ url('img/email/006_Nouveau_message/logo3.gif') }}" width="123" height="171" alt="" border="0"></a></td>
        </tr>
      </table></td>
    </tr>
	<tr>
       <td align="left" style="font-size:0px"><table align="left" border="0" cellpadding="0" cellspacing="0" width="640" class="resize">
            <tr>
                <td class="hide" width="58"></td>
                <td class="texte_center" width="540" height="130" style="font-family:Arial; font-size:16px; color:#000000; text-decoration:none;">
                Bonjour {{ $msg->destinataire->prenom }},<br /><br />
               Vous avez un nouveau  message&nbsp;!</td>
                <td class="hide" width="42">&nbsp;</td>
            </tr>
        </table></td>
    </tr>

    <tr>
        <td class="resize" width="640" height="36" align="center">
            <a href="{{ url('/message/'.$msg->id) }}"><img src="{{ url('img/email/006_Nouveau_message/btn_aac.gif') }}" width="246" height="36" alt="" class="resize"></a></td>
    </tr>
    <tr>
       <td align="left" style="font-size:0px"><table align="left" border="0" cellpadding="0" cellspacing="0" width="640" class="resize">
            <tr>
                <td class="hide" width="58"></td>
                <td class="texte_center" width="540" height="100" style="font-family:Arial; font-size:16px; color:#000000; text-decoration:none;">
                &Agrave; bientôt,<br />
                L'équipe MAYAO</td>
                <td class="hide" width="42">&nbsp;</td>
            </tr>
        </table></td>
    </tr>
	<tr>
          <td align="center" style="font-size:0px"><table border="0" cellspacing="0" cellpadding="0" class="resize" align="center">
              <tr>
                <td align="left" style="font-size:0px"><!--[if mso]><table cellpadding="0" cellspacing="0" border="0"><tr><td><![endif]-->
                  
                  <table border="0" cellspacing="0" cellpadding="0" align="left" class="resize">
                    <tr>
                        <td class="resize" width="320">
                            <a href="http://www.mayao-blog.com" target="_blank">
                            <img src="{{ url('img/email/006_Nouveau_message/mayao_blog.gif') }}" width="320" height="92" alt="" border="0"></a></td>
                    </tr>
                  </table>
                  <!--[if mso]></td><td><![endif]-->
                  <table border="0" cellspacing="0" cellpadding="0" align="left" class="resize">
                    <tr>
                        <td>
                            <a href="https://www.facebook.com/mayaoblog" target="_blank">
                            <img src="{{ url('img/email/006_Nouveau_message/facebook.gif') }}" width="85" height="92" alt="" border="0"></a></td>
                        <td>
                            <a href="https://twitter.com/mayao_fr" target="_blank">
                            <img src="{{ url('img/email/006_Nouveau_message/twitter.gif') }}" width="81" height="92" alt="" border="0"></a></td>
                        <td>
                            <a href="https://instagram.com/mayao_fr/" target="_blank">
                            <img src="{{ url('img/email/006_Nouveau_message/instagram.gif') }}" width="77" height="92" alt="" border="0"></a></td>
                        <td>
                            <a href="https://www.pinterest.com/mayao_blog/" target="_blank">
                            <img src="{{ url('img/email/006_Nouveau_message/pinterest.gif') }}" width="77" height="92" alt="" border="0"></a></td>
                   </tr>
                 </table>
              <!--[if mso]></td></tr></table><![endif]--></td>
        </tr>
       </table></td>
    </tr>
</table>
</td></tr></table>
<!-- End Save for Web Slices -->
</body>
</html>