<div class="container">

	<br>
	<?php if($this->session->flashdata('message')) { ?>
		<!-- Display Message -->
		<div class="alert-message error">
			<p><?php echo $this->session->flashdata('message'); ?></p>
		</div>
	<?php } ?>

	<div class="card">
		<div class="card-header">
			<?php echo $page_title; ?>
		</div>
		<div class="card-body">
			<h5 class="card-title"></h5>
			<p class="card-text"></p>
			<?php if($this->session->flashdata('notice')) { ?>
				<div id="message" >
					<?php echo $this->session->flashdata('notice'); ?>
				</div>
			<?php } ?>

			<?php $this->load->helper('form'); ?>

			<?php echo validation_errors(); ?>

			<form method="post" action="<?php echo site_url('contesting/edit/'); ?><?php echo $contest->id; ?>" name="edit_contest">
				<div class="form-group">
					<label for="contestnameInput">Contest Name</label>
					<input type="text" class="form-control" name="name" id="nameInput" aria-describedby="contestnameInputHelp" value="<?php if(set_value('name') != "") { echo set_value('name'); } else { echo $contest->name; } ?>" required>
					<small id="contestnameInputHelp" class="form-text text-muted">Name of Contest</small>
				</div>

				<div class="form-group">
					<label for="adifnameInput">ADIF Contest Name</label>
					<input type="text" class="form-control" name="adifname" id="adifnameInput" aria-describedby="adifnameInputHelp" value="<?php if(set_value('adifname') != "") { echo set_value('adifname'); } else { echo $contest->adifname; } ?>">
					<small id="adifnameInputHelp" class="form-text text-muted">Name of Contest in ADIF-specification</small>
				</div>

				<div class="form-group">
					<label for="activeInput">Active</label>
					<select id="activeInput" class="form-control mode form-control-sm" name="active">
						<?php
						printf("<option value=\"1\" %s>active</option>", $contest->active==1?"selected=\"selected\"":"");
						printf("<option value=\"0\" %s>not active</option>", $contest->active==0?"selected=\"selected\"":"");
						?>
					</select>
					<small id="activeInputHelp" class="form-text text-muted">Set to active if to be listed in Contest-list</small>
				</div>

				<button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-plus-square"></i> Update Contest</button>

			</form>
		</div>
	</div>

	<br>

</div>
