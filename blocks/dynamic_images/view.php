<?php defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
if ($cropImage == 1) {
    $ih = Core::make('helper/image');
}
if ($c->isEditMode()) { ?>
    <div class="ccm-edit-mode-disabled-item" style="<?php   echo isset($width) ? "width: $width;" : '' ?><?php   echo isset($height) ? "height: $height;" : '' ?>">
        <div style="padding: 40px 0px 40px 0px"><?php echo t('Repeatable Element view disabled in edit mode.')?></div>
    </div>
<?php } else { ?>
        <style>
         .repeatable-element-container-<?php echo h($bID)?> .dynamic-image-item .dynamic-image-item-image img {
             background-color: <?php echo h($backgroundColor)?>;
             padding: <?php echo h($imagePadding)?>px;
         }
        </style>
    <div class="repeatable-element-container repeatable-element-container-<?php echo h($bID)?> <?php  echo $customClass ? $customClass : '' ?> <?php echo $styling;?>">
        <?php if(count($items) > 0) { ?>

            <?php foreach($items as $item) {?>
                <div class="dynamic-image-item <?php  echo $item['customElementClass'] ? $item[customElementClass] : ''?>">
                <?php
                $f = File::getByID($item['fID']);
                if (is_object($f) && $enableImage == 1) {
                    //cropImage is retardly named so, it really means resizeImage, and $crop means crop
                    if ($cropImage == 1) {
                        $width = $cropWidth;
                        $height = $cropHeight;
                        $alt = null;
                        $crop = $crop;
                        $image = $ih->outputThumbnail($f, $width, $height, $alt, true, $crop);
                        echo '<div class="dynamic-image-item-image">' . $image . '</div>';
                    } else if ($cropImage == 0) {
                        $tag = Core::make('html/image', array($f, false))->getTag();
                        $tag->addClass('img-responsive');
                        echo '<div class="dynamic-image-item-image">' . $tag . '</div>';
                    }
                }
                ?>
                <?php if($item['title'] && $displayTitle == 1) { ?>
                    <div class="dynamic-image-item-title">
                        <p><?php echo h($item['title'])?></p>
                    </div>
                <?php } ?>

                </div>
            <?php } ?>

        <?php } else { ?>
        <div class="ccm-repeatable-item-placeholder">
            <p><?php echo t('No Repeatable Items Entered.'); ?></p>
        </div>
        <?php } ?>
    </div>
<?php } ?>
