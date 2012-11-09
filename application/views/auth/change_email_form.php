<?php
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
);
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
?>
<?php echo form_open($this->uri->uri_string()); ?>
<div class="pgHeading" >
<h1>Change Email Address</h1>
</div>
<table class="frm">
	<tr>
		<th><?php echo form_label('Password', $password['id']); ?></th>
		<td><?php echo form_password($password); ?></td>
		<td style="color: red;"><?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?></td>
	</tr>
	<tr>
		<th><?php echo form_label('New email address', $email['id']); ?></th>
		<td><?php echo form_input($email); ?></td>
		<td style="color: red;"><?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?></td>
	</tr>
</table>
<a href="JavaScript:void(0);" onclick=" $(this).parent().get(0).submit()" class="btn" ><span>Send confirmation email</span></a>
<?php //echo form_submit('change', 'Send confirmation email'); ?>
<?php echo form_close(); ?>