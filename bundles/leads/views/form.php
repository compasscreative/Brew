<form class="bundle_leads_form">
	<input type="hidden" name="id" value="<?=$id?>">
	<ul>
		<?php if($this->name_enabled){ ?>
			<li>
				<label for="bundle-leads-form-<?=$id?>-name">Name</label>
				<input type="text" name="name" data-required="<?=$this->name_required?>" id="bundle-leads-form-<?=$id?>-name">
			</li>
		<?php } ?>
		<?php if($this->email_enabled){ ?>
			<li>
				<label for="bundle-leads-form-<?=$id?>-email">Email</label>
				<input type="text" name="email" data-required="<?=$this->email_required?>" id="bundle-leads-form-<?=$id?>-email">
			</li>
		<?php } ?>
		<?php if($this->phone_enabled){ ?>
			<li>
				<label for="bundle-leads-form-<?=$id?>-phone">Phone</label>
				<input type="tel" name="phone" data-required="<?=$this->phone_required?>" id="bundle-leads-form-<?=$id?>-phone">
			</li>
		<?php } ?>
		<?php if($this->address_enabled){ ?>
			<li>
				<label for="bundle-leads-form-<?=$id?>-address">Location</label>
				<input type="text" name="address" data-required="<?=$this->address_required?>" id="bundle-leads-form-<?=$id?>-address">
			</li>
		<?php } ?>
		<?php if($this->interest_enabled){ ?>
			<li>
				<label for="bundle-leads-form-<?=$id?>-interest">Area of interest</label>
				<?php if ($this->interest_values){ ?>
					<select name="interest" data-required="<?=$this->interest_required?>" id="bundle-leads-form-<?=$id?>-interest">
						<option></option>
						<?php foreach ($this->interest_values as $value){ ?>
							<option><?=$value?></option>
						<?php } ?>
					</select>
				<?php } else { ?>
					<input type="text" name="interest" data-required="<?=$this->interest_required?>" id="bundle-leads-form-<?=$id?>-interest">
				<?php } ?>
			</li>
		<?php } ?>
		<?php if($this->budget_enabled){ ?>
			<li>
				<label for="bundle-leads-form-<?=$id?>-budget">Budget</label>
				<?php if ($this->budget_values){ ?>
					<select name="budget" data-required="<?=$this->budget_required?>" id="bundle-leads-form-<?=$id?>-budget">
						<option></option>
						<?php foreach ($this->budget_values as $value){ ?>
							<option><?=$value?></option>
						<?php } ?>
					</select>
				<?php } else { ?>
					<input type="text" name="budget" data-required="<?=$this->budget_required?>" id="bundle-leads-form-<?=$id?>-budget">
				<?php } ?>
			</li>
		<?php } ?>
	</ul>
	<ul>
		<?php if($this->message_enabled){ ?>
			<li>
				<label for="bundle-leads-form-<?=$id?>-message">Message</label>
				<textarea name="message" data-required="<?=$this->message_required?>" id="bundle-leads-form-<?=$id?>-message"></textarea>
			</li>
		<?php } ?>
		<?php if($this->referral_enabled){ ?>
			<li>
				<label for="bundle-leads-form-<?=$id?>-referral">How did you hear about us?</label>
				<input type="text" name="referral" data-required="<?=$this->referral_required?>" id="bundle-leads-form-<?=$id?>-referral">
			</li>
		<?php } ?>
		<li class="submit">
			<button type="submit" class="button">Send</button>
		</li>
	</ul>
	<div class="sent" style="display: none;">
		<p>Thank-you for contacting us. Your message has been sent.</p>
	</div>
</form>