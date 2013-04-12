<? if ($this->sections): ?>
    <form class="package_builder">

        <? foreach ($this->sections as $section): ?>

            <div class="section <?=$e(strtolower(str_replace(' ', '', $section['name'])))?>">
                <h2><?=$e($section['name'])?></h2>
                <ul class="options">
                    <? foreach($section['options'] as $option): ?>
                        <li>
                            <h3><?=$e($option->name)?></h3>
                            <div class="option na">
                                <label>
                                    <input type="radio" name="option[<?=$e($option->id)?>]" data-price-low="0" data-price-high="0" checked="checked"> N/A
                                </label>
                            </div>
                            <div class="option">
                                <label>
                                    <input type="radio" name="option[<?=$e($option->id)?>]" data-price-low="<?=$e($option->small_price_1)?>" data-price-high="<?=$e($option->small_price_2)?>"> Small <span>($<?=round($option->small_price_1 / 1000, 1)?> to <?=round($option->small_price_2 / 1000, 1)?>K)</span>
                                </label>
                            </div>
                            <div class="option">
                                <label>
                                    <input type="radio" name="option[<?=$e($option->id)?>]" data-price-low="<?=$e($option->medium_price_1)?>" data-price-high="<?=$e($option->medium_price_2)?>"> Medium <span>($<?=round($option->medium_price_1 / 1000, 1)?> to <?=round($option->medium_price_2 / 1000, 1)?>K)</span>
                                </label>
                            </div>
                            <div class="option">
                                <label>
                                    <input type="radio" name="option[<?=$e($option->id)?>]" data-price-low="<?=$e($option->large_price_1)?>" data-price-high="<?=$e($option->large_price_2)?>"> Large <span>($<?=round($option->large_price_1 / 1000, 1)?> to <?=round($option->large_price_2 / 1000, 1)?>K)</span>
                                </label>
                            </div>
                            <div class="info">
                                <div class="small">
                                    <? if ($option->small_photo['small']): ?>
                                        <a href="<?=$e($option->small_photo['large'])?>" title="Example of a small <?=$e(strtolower($option->name))?>">
                                            <img src="<?=$e($option->small_photo['small'])?>">
                                        </a>
                                    <? else: ?>
                                        <div class="no_photo"></div>
                                    <? endif ?>
                                    <div class="description">
                                        <h4>Small</h4>
                                        <p><?=$e($option->small_description)?></p>
                                    </div>
                                </div>
                                <div class="medium">
                                    <? if ($option->medium_photo['small']): ?>
                                        <a href="<?=$e($option->medium_photo['large'])?>" title="Example of a medium <?=$e(strtolower($option->name))?>">
                                            <img src="<?=$e($option->medium_photo['small'])?>">
                                        </a>
                                    <? else: ?>
                                        <div class="no_photo"></div>
                                    <? endif ?>
                                    <div class="description">
                                        <h4>Medium</h4>
                                        <p><?=$e($option->medium_description)?></p>
                                    </div>
                                </div>
                                <div class="large">
                                    <? if ($option->large_photo['small']): ?>
                                        <a href="<?=$e($option->large_photo['large'])?>" title="Example of a large <?=$e(strtolower($option->name))?>">
                                            <img src="<?=$e($option->large_photo['small'])?>">
                                        </a>
                                    <? else: ?>
                                        <div class="no_photo"></div>
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
            </div>
        <? endforeach ?>

        <ul class="summary">
            <? foreach ($this->extras as $extra): ?>
                <li class="extra" data-percentage="<?=$e($extra['percentage'])?>">
                    <?=$e($extra['name'])?>: <strong>$0</strong>
                </li>
            <? endforeach ?>
            <li class="total">
                Your budget*: <strong>$0</strong>
            </li>
            <li class="fineprint">*This tool provides a rough estimate only and is not meant to give exact costs.</li>
        </ul>

    </form>
<? endif ?>