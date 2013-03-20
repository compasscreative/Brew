<?
$this->title = 'Leads';
$this->insert('admin::partials/header');
?>

<div class="panel">
    <div class="header">
        <div class="title">Lead from <?=$this->lead->name?></div>
    </div>
    <div class="body">
        <form autocomplete="off" id="leads_lead_edit">
            <input type="hidden" name="id" value="<?=$this->lead->id?>">
            <ul>
                <li>
                    <div class="label">
                        <label>Date:</label>
                    </div>
                    <div class="field">
                        <div class="info"><?=date_create($this->lead->submitted_date)->format('F j, Y \a\t g:i a')?></div>
                    </div>
                </li>
                <? if (strlen($this->lead->message)): ?>
                    <li>
                        <div class="label">
                            <label>Message:</label>
                        </div>
                        <div class="field">
                            <div class="info"><?=nl2br($this->lead->message)?></div>
                        </div>
                    </li>
                <? endif ?>
                <li>
                    <div class="label">
                        <label>Email:</label>
                    </div>
                    <div class="field">
                        <div class="info"><a href="mailto:<?=$this->lead->email?>"><?=$this->lead->email?></a></div>
                    </div>
                </li>
                <? if (strlen($this->lead->phone)): ?>
                    <li>
                        <div class="label">
                            <label>Phone:</label>
                        </div>
                        <div class="field">
                            <div class="info"><?=$this->lead->phone?></div>
                        </div>
                    </li>
                <? endif ?>
                <? if (strlen($this->lead->address)): ?>
                    <li>
                        <div class="label">
                            <label>Address:</label>
                        </div>
                        <div class="field">
                            <div class="info"><?=nl2br($this->lead->address)?></div>
                        </div>
                    </li>
                <? endif ?>
                <? if (strlen($this->lead->interest)): ?>
                    <li>
                        <div class="label">
                            <label>Area of interest:</label>
                        </div>
                        <div class="field">
                            <div class="info"><?=$this->lead->interest?></div>
                        </div>
                    </li>
                <? endif ?>
                <? if (strlen($this->lead->budget)): ?>
                    <li>
                        <div class="label">
                            <label>Approximate budget:</label>
                        </div>
                        <div class="field">
                            <div class="info"><?=$this->lead->budget?></div>
                        </div>
                    </li>
                <? endif ?>
                <? if (strlen($this->lead->referral)): ?>
                    <li>
                        <div class="label">
                            <label>How did you hear about us?</label>
                        </div>
                        <div class="field">
                            <div class="info"><?=$this->lead->referral?></div>
                        </div>
                    </li>
                <? endif ?>
                <? if (strlen($this->lead->url)): ?>
                    <li>
                        <div class="label">
                            <label>Submitted from:</label>
                        </div>
                        <div class="field">
                            <div class="info"><a href="<?=$this->lead->url?>"><?=trim(str_replace(array('https://', 'http://', 'www.'), array('', ''), $this->lead->url), '/')?></a></div>
                        </div>
                    </li>
                <? endif ?>
                <li>
                    <div class="label">
                        <label>IP address:</label>
                    </div>
                    <div class="field">
                        <div class="info"><?=$this->lead->ip_address?></div>
                    </div>
                </li>
                <li>
                    <div class="buttons">
                        <button class="delete_lead" type="button">Delete</button>
                        <button type="button" onclick="javascript:window.location = '/admin/leads';">Done</button>
                    </div>
                </li>
            </ul>
        </form>
    </div>
</div>

<? $this->insert('admin::partials/footer') ?>