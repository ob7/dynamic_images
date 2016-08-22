<?php     defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
if ($cropImage == 1) {
    $ih = Core::make('helper/image');
}
if ($c->isEditMode()) { ?>
    <div class="ccm-edit-mode-disabled-item" style="<?php   echo isset($width) ? "width: $width;" : '' ?><?php   echo isset($height) ? "height: $height;" : '' ?>">
        <div style="padding: 40px 0px 40px 0px"><?php   echo t('Repeatable Element view disabled in edit mode.')?></div>
    </div>
<?php     } else { ?>
    <div class="repeatable-element-container <?php  echo $customClass ? $customClass : '' ?>">
        <?php     if(count($items) > 0) { ?>
            <?php     foreach($items as $item) {?>
                <div class="dynamic-image-item <?php  echo $item['customElementClass'] ? $item[customElementClass] : ''?>">
                <?php     if($item['title'] && $displayTitle == 1) { ?>
                    <p>
                        <?php    echo h($item['title'])?>
                    </p>
                <?php     } ?>
                <?php    
                $f = File::getByID($item['fID']);
                if (is_object($f) && $enableImage == 1) {
                    if ($cropImage == 1) {
                        $width = $cropWidth;
                        $height = $cropHeight;
                        $crop = $crop;
                        $image = $ih->getThumbnail($f, $width, $height, $crop);
                        echo '<img src="' . $image->src . '">';
                    } else if ($cropImage == 0) {
                        $tag = Core::make('html/image', array($f, false))->getTag();
                        echo $tag;
                    }
                }
                ?>
                </div>
            <?php     } ?>
        <?php     } else { ?>
        <div class="ccm-repeatable-item-placeholder">
            <p><?php    echo t('No Repeatable Items Entered.'); ?></p>
        </div>
        <?php     } ?>
    </div>
<?php     } ?>
