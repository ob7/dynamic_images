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
    <div class="repeatable-element-container <?php  echo $customClass ? $customClass : '' ?> <?php echo $styling;?>">
        <?php if(count($items) > 0) { ?>

            <?php foreach($items as $item) {?>
                <div class="dynamic-image-item <?php  echo $item['customElementClass'] ? $item[customElementClass] : ''?>">
                <?php
                $f = File::getByID($item['fID']);
                if (is_object($f) && $enableImage == 1) {
                    if ($cropImage == 1) {
                        $width = $cropWidth;
                        $height = $cropHeight;
                        $alt = null;
                        $crop = $crop;
                        $image = $ih->outputThumbnail($f, $width, $height, $alt, $crop);
                        echo '<div class="dynamic-image-item-image">';
                        echo $image;
                        echo '</div>';
                    } else if ($cropImage == 0) {
                        $tag = Core::make('html/image', array($f, false))->getTag();
                        echo '<div class="dynamic-image-item-image">';
                        echo $tag;
                        echo '</div>';
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
