<?
$this->title = 'Package Builder';
$this->insert('partials/header');
?>

<h1>Package Builder</h1>

<? if ($this->sections): ?>
    <form class="package_builder">

        <? foreach ($this->sections as $section): ?>
            <h2><?=$e($section['name'])?></h2>
            <ul>
                <? foreach($section['options'] as $option): ?>
                    <li>
                        <h3><?=$e($option->name)?></h3>
                        <div class="option">
                            <label>
                                <input type="radio" name="option[<?=$e($option->id)?>]" data-price-low="0"  data-price-high="0" checked="checked"> N/A
                            </label>
                        </div>
                        <div class="option">
                            <label>
                                <input type="radio" name="option[<?=$e($option->id)?>]" data-price-low="<?=$e($option->small_price_1)?>"  data-price-high="<?=$e($option->small_price_2)?>"> Small ($<?=round($option->small_price_1 / 1000, 1)?> to <?=round($option->small_price_2 / 1000, 1)?>K)
                            </label>
                        </div>
                        <div class="option">
                            <label>
                                <input type="radio" name="option[<?=$e($option->id)?>]" data-price-low="<?=$e($option->medium_price_1)?>"  data-price-high="<?=$e($option->medium_price_2)?>"> Medium ($<?=round($option->medium_price_1 / 1000, 1)?> to <?=round($option->medium_price_2 / 1000, 1)?>K)
                            </label>
                        </div>
                        <div class="option">
                            <label>
                                <input type="radio" name="option[<?=$e($option->id)?>]" data-price-low="<?=$e($option->large_price_1)?>"  data-price-high="<?=$e($option->large_price_2)?>"> Large ($<?=round($option->large_price_1 / 1000, 1)?> to <?=round($option->large_price_2 / 1000, 1)?>K)
                            </label>
                        </div>
                        <div class="info">
                            <div class="small">
                                <? if ($option->small_photo['small']): ?>
                                    <a href="<?=$e($option->small_photo['large'])?>">
                                        <img src="<?=$e($option->small_photo['small'])?>">
                                    </a>
                                <? endif ?>
                                <div class="description">
                                    <h4>Small</h4>
                                    <p><?=$e($option->small_description)?></p>
                                </div>
                            </div>
                            <div class="medium">
                                <? if ($option->medium_photo['small']): ?>
                                    <a href="<?=$e($option->medium_photo['large'])?>">
                                        <img src="<?=$e($option->medium_photo['small'])?>">
                                    </a>
                                <? endif ?>
                                <div class="description">
                                    <h4>Medium</h4>
                                    <p><?=$e($option->medium_description)?></p>
                                </div>
                            </div>
                            <div class="large">
                                <? if ($option->large_photo['small']): ?>
                                    <a href="<?=$e($option->large_photo['large'])?>">
                                        <img src="<?=$e($option->large_photo['small'])?>">
                                    </a>
                                <? endif ?>
                                <div class="description">
                                    <h4>Large</h4>
                                    <p><?=$e($option->large_description)?></p>
                                </div>
                            </div>
                        </div>
                    </li>
                <? endforeach ?>
            </ul>
        <? endforeach ?>

        <h2>Summary</h2>
        <ul class="summary">
            <? foreach ($this->extras as $extra): ?>
                <li class="extra" data-percentage="<?=$e($extra['percentage'])?>">
                    <div class="title"><?=$e($extra['name'])?>:</div>
                    <div class="value">$0</div>
                </li>
            <? endforeach ?>
            <li class="total">
                <div class="title">Total:</div>
                <div class="value">$0</div>
            </li>
        </ul>

    </form>
<? endif ?>

<? $this->insert('partials/footer') ?>