<?php

define('EMAIL_FOR_REPORTS', 'colissa@gmail.com');
define('RECAPTCHA_PRIVATE_KEY', '@privatekey@');
define('FINISH_URI', 'http://');
define('FINISH_ACTION', 'message');
define('FINISH_MESSAGE', 'Well, that was easy! Check your email for the link to the full Digital Audit Report!');
define('UPLOAD_ALLOWED_FILE_TYPES', 'doc, docx, xls, csv, txt, rtf, html, zip, jpg, jpeg, png, gif');

require_once str_replace('\\', '/', __DIR__) . '/handler.php';

?>

<?php if (frmd_message()): ?>
<link rel="stylesheet" href="<?=dirname($form_path)?>/formoid-metro-blue.css" type="text/css" />
<span class="alert alert-success"><?=FINISH_MESSAGE;?></span>
<?php else: ?>
<!-- Start Formoid form-->
<link rel="stylesheet" href="<?=dirname($form_path)?>/formoid-metro-blue.css" type="text/css" />
<script type="text/javascript" src="<?=dirname($form_path)?>/jquery.min.js"></script>
<form class="formoid-metro-blue" style="background-color:#c4e1ff;font-size:16px;font-family:Georgia,serif;color:#000000;max-width:600px;min-width:150px" method="post"><div class="title"><h2>EasyDAR</h2></div>
	<div class="element-input<?frmd_add_class("input")?>" title="Ensure this is accurate"><label class="title">Buisness Name<span class="required">*</span></label><input class="large" type="text" name="input" required="required"/></div>
	<div class="element-input<?frmd_add_class("input1")?>" title="e.g. www.azcentral.com"><label class="title">Buisness Website URL<span class="required">*</span></label><input class="large" type="text" name="input1" required="required"/></div>
	<div class="element-input<?frmd_add_class("input2")?>" title="e.g. Scottsdale, AZ"><label class="title">City, State<span class="required">*</span></label><input class="large" type="text" name="input2" required="required"/></div>
	<div class="element-textarea<?frmd_add_class("textarea")?>" title="e.g. flower shop phx, hair salon chandler, etc."><label class="title">Keywords<span class="required">*</span></label><textarea class="medium" name="textarea" cols="20" rows="5" required="required"></textarea></div>
<div class="submit"><input type="submit" value="Submit"/></div></form><script type="text/javascript" src="<?=dirname($form_path)?>/formoid-metro-blue.js"></script>

<!-- Stop Formoid form-->
<?php endif; ?>

<?php frmd_end_form(); ?>