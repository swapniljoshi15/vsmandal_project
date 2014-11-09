<h1><?php echo lang('edit_group_heading');?></h1>
<p><?php echo lang('edit_group_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(current_url());?>

      <p>
            <?php echo lang('create_group_name_label', 'group_name');?> <br />
            <?php echo form_input($group_name);?>
      </p>

      <p>
            <?php echo lang('edit_group_desc_label', 'description');?> <br />
            <?php echo form_input($group_description);?>
      </p>

	 <h3>Change access for each functions listed below</h3>
		<?php foreach ($functions as $function):?>
		<label class="checkbox">
		<?php
			$gID=$function->function_id;
			$checked = null;
			$item = null;
			foreach($functions_access as $access) {
				if ($gID == $access->function_id) {
					$checked= ' checked="checked"';
				break;
				}
			}
		?>
		<input type="checkbox" name="functions[]" value="<?php echo $function->function_id;?>"<?php echo $checked;?>>
		<?php echo $function->function_name;?>
		</label><br />
		<?php endforeach?>
		
      <p><?php echo form_submit('submit', lang('edit_group_submit_btn'));?></p>

<?php echo form_close();?>