<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($this->config->item('use_username', 'tank_auth')) {
	$login_label = 'Email or login';
} else {
	$login_label = 'Email';
}
?>
<?php echo form_open($this->uri->uri_string()); ?>
<div class="pgHeading" >
<h1>Forgot Password</h1>
</div>
<table class="frm">
	<tr>
		<th><?php echo form_label($login_label, $login['id']); ?></th>
		<td><?php echo form_input($login); ?></td>
		<td style="color: red;"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></td>
	</tr>
</table>
<a href="JavaScript:void(0);" onclick=" $(this).parent().get(0).submit()" class="btn" ><span>Get a new password</span></a>
<?php //echo form_submit('reset', 'Get a new password'); ?>
<?php echo form_close(); ?>