<form class="bundle_leads_form">
    <input type="hidden" name="id" value="<?=$this->id?>">
    <ul>
        <? if ($this->name_enabled): ?>
            <li>
                <label for="bundle-leads-form-<?=$this->id?>-name">Name</label>
                <input type="text" name="name" data-required="<?=$this->name_required?>" id="bundle-leads-form-<?=$this->id?>-name">
            </li>
        <? endif ?>

        <? if ($this->email_enabled): ?>
            <li>
                <label for="bundle-leads-form-<?=$this->id?>-email">Email</label>
                <input type="text" name="email" data-required="<?=$this->email_required?>" id="bundle-leads-form-<?=$this->id?>-email">
            </li>
        <? endif ?>

        <? if ($this->phone_enabled): ?>
            <li>
                <label for="bundle-leads-form-<?=$this->id?>-phone">Phone</label>
                <input type="tel" name="phone" data-required="<?=$this->phone_required?>" id="bundle-leads-form-<?=$this->id?>-phone">
            </li>
        <? endif ?>

        <? if ($this->address_enabled): ?>
            <li>
                <label for="bundle-leads-form-<?=$this->id?>-address">Address</label>
                <textarea name="address" data-required="<?=$this->address_required?>" id="bundle-leads-form-<?=$this->id?>-address"></textarea>
            </li>
        <? endif ?>

        <? if ($this->interest_enabled): ?>
            <li>
                <label for="bundle-leads-form-<?=$this->id?>-interest">Area of interest</label>
                <? if ($this->interest_values): ?>
                    <select name="interest" data-required="<?=$this->interest_required?>" id="bundle-leads-form-<?=$this->id?>-interest">
                        <option></option>
                        <? foreach ($this->interest_values as $value): ?>
                            <option><?=$value?></option>
                        <? endforeach ?>
                    </select>
                <? else: ?>
                    <input type="text" name="interest" data-required="<?=$this->interest_required?>" id="bundle-leads-form-<?=$this->id?>-interest">
                <? endif ?>
            </li>
        <? endif ?>

        <? if ($this->budget_enabled): ?>
            <li>
                <label for="bundle-leads-form-<?=$this->id?>-budget">Budget</label>
                <? if ($this->budget_values): ?>
                    <select name="budget" data-required="<?=$this->budget_required?>" id="bundle-leads-form-<?=$this->id?>-budget">
                        <option></option>
                        <? foreach ($this->budget_values as $value): ?>
                            <option><?=$value?></option>
                        <? endforeach ?>
                    </select>
                <? else: ?>
                    <input type="text" name="budget" data-required="<?=$this->budget_required?>" id="bundle-leads-form-<?=$this->id?>-budget">
                <? endif ?>
            </li>
        <? endif ?>

        <? if ($this->message_enabled): ?>
            <li>
                <label for="bundle-leads-form-<?=$this->id?>-message">Message</label>
                <textarea name="message" data-required="<?=$this->message_required?>" id="bundle-leads-form-<?=$this->id?>-message"></textarea>
            </li>
        <? endif ?>

        <? if ($this->referral_enabled): ?>
            <li>
                <label for="bundle-leads-form-<?=$this->id?>-referral">How did you hear about us?</label>
                <input type="text" name="referral" data-required="<?=$this->referral_required?>" id="bundle-leads-form-<?=$this->id?>-referral">
            </li>
        <? endif ?>

        <li class="submit">
            <button type="submit" class="button">Send</button>
        </li>
    </ul>
    <div class="sent" style="display: none;">
        <p>Thank-you for contacting us. Your message has been sent.</p>
    </div>
</form>