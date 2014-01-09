<?php

/*ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);*/

require_once(__DIR__ . DIRECTORY_SEPARATOR . "CssToInlineStyles.php");

if ( isset($_REQUEST['url'])) {
	$url = $_REQUEST['url'];
} else {
	$url = date('Ymd', time());
}

$url = $url . ".html";

$fh = fopen(__DIR__ . DIRECTORY_SEPARATOR . "drafts" . DIRECTORY_SEPARATOR . $url, "w");

$html = <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
	<head>
		<title>Talk It Out! - Practical Applications for AAC Use</title>
		<style type="text/css">
			h1 {
				font-family: arial; font-size: 14pt; font-weight: normal; margin: 5px 0 0 0; color: #c56f29;
			}

			p {
				font-family: arial; font-size: 10pt; margin: 5px 0 12px 15px;
			}

			ul, ol {
				font-family: arial; font-size: 10pt; padding:0; margin: 5px 0 12px 15px;
			}

			li {
				margin: 0 0 0 15px; padding:0;
			}
		</style>
	</head>
	<body style="background-color: #c56f29; margin: 0; padding: 0;">
		<div style="margin: 0 auto 0 auto; width: 600px;">
			<table width="600" cellpadding="0" cellspacing="0" background="http://www.annienicholsslp.com/newsletter/img/brown-outline.gif" style="background-color: #80481b; background-image: url('http://www.annienicholsslp.com/newsletter/img/brown-outline.gif'); background-repeat: repeat-y no-repeat; margin: 10px 0 0 0;">
				<tr>
					<td colspan="3">
						<img src="http://www.annienicholsslp.com/newsletter/img/transparent.gif" width="1" height="15">
					</td>
				</tr>
				<tr>
					<td>
						<img src="http://www.annienicholsslp.com/newsletter/img/transparent.gif" width="15" height="1">
					</td>
					<td style="background-color:#ffffff;padding:0 25px 20px 25px;">
						<table width="100%">
							<tr>
								<td colspan="2" style="padding:5px 25px 45px 25px;">
									<p style="font-family: arial; font-size: 8pt; margin: 0; text-align: center;">
										<a href="http://www.annienicholsslp.com/newsletter/{{url}}" style="color:#016878;text-decoration:none;">Online Version</a>
									</p>
								</td>
							</tr>
							<tr>
							<td valign="middle">
									<h1 style="font-family: arial; font-size: 24pt; font-weight: normal; margin: 0 0 0 0; color: #d23d21; line-height: 16px;">
										Talk It Out!
									</h1>
									<h2 style="font-family: arial; font-size: 14pt; font-weight: normal; margin: 5px 0 0 25px; color: #dc5b23; line-height: 16px;">
										Practical Applications for AAC Use
									</h2>
								</td>
								<td width="100" valign="top">
									<img src="http://www.annienicholsslp.com/newsletter/img/leaf.jpg" width="65" height="76" alt="" title="">
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top">
									<img src="http://www.annienicholsslp.com/newsletter/img/transparent.gif" width="520" height="14">
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top">
									{{content}}
									<h1 style="font-family: arial; font-size: 14pt; font-weight: normal; margin: 5px 0 0 0; color: #c56f29;">
										Contact
									</h1>
									<p style="font-family: arial; font-size: 10pt; margin: 5px 0 12px 15px;">
										<a href="mailto:anichols@acsc.net">anichols@acsc.net</a> Edgewood at 641-2119 x 4054
									</p>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<p style="font-family: arial; font-size: 8pt; margin: 0; text-align: center;">
										Volume {{volume}} Issue {{issue}}
									</p>
								</td>
							</tr>
						</table>
						<img src="http://www.annienicholsslp.com/newsletter/img/transparent.gif" width="520" height="1">
					</td>
					<td>
						<img src="http://www.annienicholsslp.com/newsletter/img/transparent.gif" width="15" height="1">
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<img src="http://www.annienicholsslp.com/newsletter/img/transparent.gif" width="1" height="15">
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
EOF;

$html = preg_replace('/{{url}}/', $url, $html);
$html = preg_replace('/{{content}}/', $_POST['message'], $html);
$html = preg_replace('/{{volume}}/', $_POST['volume'], $html);
$html = preg_replace('/{{issue}}/', $_POST['issue'], $html);

$inliner = new CssToInlineStyles($html);

fwrite($fh, $inliner->convert());
fclose($fh);

header("content-type: text/json");

?>
{
	"url": "drafts/<?php echo $url; ?>"
}