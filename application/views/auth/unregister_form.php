<?php
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
);
?>
<?php echo form_open($this->uri->uri_string()); ?>
<div class="pgHeading" >
<h1>Cancel Account</h1>
</div>
<table class="frm">
	<tr>
		<th><?php echo form_label('Password', $password['id']); ?></th>
		<td><?php echo form_password($password); ?></td>
		<td style="color: red;"><?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?></td>
	</tr>
</table>
<a href="JavaScript:void(0);" onclick=" $(this).parent().get(0).submit()" class="btn" ><span>Cancel account</span></a>
<?php //echo form_submit('cancel', 'Delete account'); ?>
<?php echo form_close(); ?>