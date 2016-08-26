<?php defined('C5_EXECUTE') or die("Access Denied.");

$color = Core::make('helper/form/color');

echo Core::make('helper/concrete/ui')->tabs(array(
    array('items', t('Items'), true),
    array('options', t('Options')),
    array('layout', t('Layout')),
    array('colors', t('Colors & Padding'))
));

if(!$cropWidth) {
    $cropWidth = 200;
}
if(!$cropHeight) {
    $cropHeight = 200;
}
?>
<script>
$(document).ready(function(){
	$("[type='checkbox']").bootstrapSwitch();
});
</script>

<div class="ccm-tab-content" id="ccm-tab-content-items">
    <div class="repeatable-elements-container">
        <div class="repeatable-elements-controls">
            <button type="button" data-expand-text="Expand All" data-collapse-text="Collapse All" class="btn btn-default edit-all-items"><?php    echo t('Expand All')?></button>
        </div>
        <div class="repeatable-element-entries">
            <!-- REPEATABLE DYNAMIC ELEMENT ITEMS WILL BE APPENDED INTO HERE -->
        </div>
        <div>
            <button type="button" class="btn btn-success add-repeatable-element-entry"> <?php    echo t('Add Item')?> </button>
        </div>
    </div>
</div>

<div class="ccm-tab-content" id="ccm-tab-content-options">
    <div class="option-box" data-option=".display-title">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <label class="control-label"><?php echo t('Display Titles?');?></label>
            </div>
            <div class="col-xs-12 col-md-6">
                <?php echo $form->checkbox('displayTitle', 1, $displayTitle, array('data-size' => 'small', 'data-on-color' => 'success', 'data-off-color' => 'danger'))?>
            </div>
        </div>
    </div>
    <label class="control-label"><?php echo t('Enable Images?');?></label>
    <div class="option-box" data-option=".enable-image">
        <div class="option-box-row">
            <select class="form-control top-option" name="enableImage" id="toggleImage">
                <option <?php echo $enableImage == 0 ? 'selected' : ''?> value="0"><?php echo t('No')?></option>
                <option <?php echo $enableImage == 1 ? 'selected' : ''?> value="1"><?php echo t('Yes')?></option>
            </select>
            <button type="button" class="btn btn-default option-button <?php echo $enableImage == 0 ? 'disabled' : '';?>">Options</button>
        </div>
        <div class="option-box-options image-options <?php echo $enableImage == 0 ? 'disabled' : ''; ?>">
            <hr/>
            <label class="control-label"><?php echo t('Resize Images?');?></label>
            <select class="form-control" name="cropImage" id="toggleCrop">
                <option <?php echo $cropImage == 0 ? 'selected' : ''?> value="0"><?php echo t('No')?></option>
                <option <?php echo $cropImage == 1 ? 'selected' : ''?> value="1"><?php echo t('Yes')?></option>
            </select>
            <div class="crop-options <?php    echo $cropImage == 0 ? 'disabled' : ''?>">
                <label class="control-label"><?php echo t('Width');?></label>
                <input class="form-control" name="cropWidth" type="number" min="1" value="<?php echo $cropWidth?>"/>

                <label class="control-label"><?php echo t('Height');?></label>
                <input class="form-control" name="cropHeight" type="number" min="1" value="<?php echo $cropHeight?>"/>

                <label class="control-label"><?php echo t('Crop to dimensions?');?></label>
                <select class="form-control" name="crop">
                    <option <?php echo $crop == 0 ? '' : 'selected'?> value="0">No</option>
                    <option <?php echo $crop == 1 ? 'selected' : ''?> value="1">Yes</option>
                </select>
            </div>
        </div>
    </div>
    <label class="control-label"><?php echo t('Custom Class For Entire Block (Optional):');?></label>
    <div class="option-box" data-option=".custom-class">
        <input class="form-control" name="customClass" type="text" maxlength="255" value="<?php echo $customClass?>"/>
    </div>
</div>
<div class="ccm-tab-content" id="ccm-tab-content-layout">
    <label class="control-label">
        <?php echo t('Choose layout')?>
    </label>
    <select class="form-control" id="stylingOptions" name="styling">
        <option <?php echo $styling == 'none' ? 'selected ' : ''?> value="none">None (No layout will be applied by block)</option>
        <option <?php echo $styling == 'default' ? 'selected ' : ''?>value="default">Column</option>
        <option <?php echo $styling == 'row-of-flex' ? 'selected ' : ''?>value="row-of-flex">Row</option>
    </select>
    <div id="stylesPreview" class="style-preview-container <?php echo $styling?>">
        <h3>Layout Example:</h3>
        <div class="style-preview">
        </div>
    </div>
</div>
<div class="ccm-tab-content" id="ccm-tab-content-colors">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <?php echo $form->label('backgroundColor', t('Background Color'))?><br>
                <?php echo $color->output('backgroundColor', $backgroundColor ? $backgroundColor : 'rgba(60,78,97,1.0)', array('showAlpha' => 'true'));?>
                <p class="small muted">This color appears behind the image if the image has padding.</p>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group" id="image-padding-slider">
                <?php
                echo $form->label('imagePadding', t('Image padding: '));
                ?> 
                <span class="image_padding_slider">
                    <?php 
                    if (isset($imagePadding)){
                        echo $imagePadding;
                    } else {
                        echo '0';
                    }
                    ?>px
                </span> 
                <?php
                echo $form->text('imagePadding', $imagePadding, array('class'=>'image_padding_slider'));
                ?>
                <div class="image_padding_slider">
                </div>
                <p class="small muted">This is the padding applied to the images themselves.  If any padding is present the color set to the left will appear as a border.</p>
                <script type="text/javascript">
                    $('input.image_padding_slider').hide();
                    $('div.image_padding_slider').
                    slider(
                        {
                            range: "min",
                            min  : 0,
                            step : 1,
                            max  : 200,
                            value: parseInt($('span.image_padding_slider').text(),10),
                            slide: function(event, uiobj) {
                                $('span.image_padding_slider').text(uiobj.value+'px');
                                $('input.image_padding_slider').val(uiobj.value);
                            }
                        });
                </script>
            </div>
        </div>
    </div>
</div>
<script>
 $('.option-box select.top-option').click(function() {
     value = $(this).find('option:selected').val();
     item = $(this).parent().parent().data('option');
     console.log("ITEM IS " + item);
     if (value == 1) {
         $(this).parent().find('button').removeClass('disabled');
         $(item).removeClass("disabled");
         /* $(this).parent().parent().find('.option-box-options').removeClass('disabled');*/
     } else if (value == 0) {
         $(this).parent().find('button').addClass("disabled");
         $(item).addClass("disabled");
         $(this).parent().parent().find('.option-box-options').addClass('disabled');
     }
     console.log("VALUE IS " + value);
 });
 $(".option-button").click(function() {
     $(this).parent().parent().find('.option-box-options').toggleClass("disabled");
 });

</script>


<!-- THE TEMPLATE USED FOR EACH ITEM -->
<script type="text/template" id="entryTemplate">
    <div class="repeatable-element-entry item-closed">
        <div class="repeatable-element-entry-row">
            <!--Item # Title -->
            <div class="repeatable-element-entry-row-title">
                <h4>Item #<span class="item-number"><%=item_number%></span></h4> :: <p>(<%=title%>)</p>
            </div>
            <!-- Item Controls -->
            <div class="repeatable-element-entry-controls">
                <!-- Delete Button -->
                <button type="button" class="btn btn-danger remove-repeatable-element-entry"> <?php    echo t('Delete')?> </button>
                <!-- Edit Button -->
                <button type="button" class="btn btn-default edit-repeatable-element-entry" data-item-close-text="<?php    echo t('Collapse Details')?>" data-item-edit-text="<?php    echo t('Edit Details')?>"><?php    echo t('Edit Details');?></button>

                <!-- Edit Image-->
                <div class="form-group enable-image <%=enable_image > 0 ? '' : 'disabled' %>">
                    <label><?php    echo t('Image');?></label>
                    <div class="repeatable-element-image">
                        <% if(image_url.length > 0) { %>
                        <img src="<%=image_url%>"/>
                        <% } else { %>
                        <i class="fa fa-picture-o"></i>
                        <% } %>
                    </div>
                    <input name="<?php    echo $view->field('fID')?>[]" type="hidden" class="repeatable-element-fID" value="<%=fID%>"/>
                </div>
                <!-- Move item button-->
                <i class="fa fa-arrows"></i>
            </div>
        </div>

        <!-- Repeatable Content -->
        <div class="repeatable-element-entry-content">
            <hr/>
            <!-- Title -->
            <div class="form-group">
                <label><?php    echo t('Title');?></label>
                <input class="form-control" name="<?php    echo $view->field('title'); ?>[]" type="text" maxlength="60" value="<%=title%>" />
            </div>
            <!-- Custom Class For Element -->
            <div class="form-group">
                <label><?php    echo t('Custom Class For This Element (Optional)');?></label>
                <input class="form-control" name="<?php    echo $view->field('customElementClass'); ?>[]" type="text" maxlength="255" value="<%=custom_element_class%>" />
            </div>
            <!--Sort Order-->
            <input class="repeatable-element-entry-sort" name="<?php    echo $view->field('sortOrder');?>[]" type="hidden" value="<%=sort_order%>"/>
        </div>

    </div>
</script>



<!--FORM FUNCTIONALITY-->
<script>
 $(document).ready(function() {
     var entriesContainer = $('.repeatable-element-entries');
     var entriesTemplate = _.template($('#entryTemplate').html());

     // Add item button
     $('.add-repeatable-element-entry').click(function() {
         var currentEntries = document.getElementsByClassName('repeatable-element-entry').length + 1;
         entriesContainer.append(entriesTemplate({
             title: '',
             custom_element_class: '',
             fID: '',
             image_url: '',
             sort_order: '',
             item_number: currentEntries,
             enable_image: enable_image
         }));

         var newSlide = $('.repeatable-element-entry').last();
         attachDelete(newSlide.find('.remove-repeatable-element-entry'));
         attachFileManagerLaunch(newSlide.find('.repeatable-element-image'));
         var closeText = newSlide.find('.edit-repeatable-element-entry').data('itemCloseText');
         $('.repeatable-element-entry').not('.item-closed').each(function() {
             $(this).addClass('item-closed');
             var thisEditButton = $(this).closest('.repeatable-element-entry').find('.edit-repeatable-element-entry');
             thisEditButton.text(thisEditButton.data('itemEditText'));
         });
         newSlide.removeClass('item-closed').find('.edit-repeatable-element-entry').text(closeText);

         //Move to newest added item
         var thisModal = $(this).closest('.ui-dialog-content');
         var modalHeight = thisModal.find('.ccm-ui').height();
         var scrollPosition = modalHeight;
         $(thisModal).animate({ scrollTop: scrollPosition }, "slow");

         // Ensure edit all button is toggled to original state
         var editAll = $('.edit-all-items');
         editAll.text(editAll.data('expandText'));

         doSortCount();
     });

     // Image selector
     var attachFileManagerLaunch = function($obj) {
         $obj.click(function() {
             var oldLauncher = $(this);
             ConcreteFileManager.launchDialog(function(data) {
                 ConcreteFileManager.getFileDetails(data.fID, function(r) {
                     jQuery.fn.dialog.hideLoader();
                     var file = r.files[0];
                     oldLauncher.html(file.resultsThumbnailImg);
                     oldLauncher.next('.repeatable-element-fID').val(file.fID);
                 });
             });
         });
     }

     // Remove item function
     var attachDelete = function($obj) {
         $obj.click(function() {
             $(this).closest('.repeatable-element-entry').remove();
             doSortCount();
         });
     };

     // Move item
     $('.repeatable-element-entries').sortable({
         placeholder: "ui-state-highlight",
         axis: "y",
         handle: "i.fa-arrows",
         cursor: "move",
         update: function() {
             doSortCount();
         }
     });

     // Sort items
     var doSortCount = function() {
         $('.repeatable-element-entry').each(function(index) {
             $(this).find('.repeatable-element-entry-sort').val(index);
             $(this).find('.item-number').html(index+1); // item_number simply gives each item a number in the form for user reference, it does not save to database
         });
     };

     // Edit item button
     $('.repeatable-element-entries').on('click','.edit-repeatable-element-entry', function() {
         $(this).closest('.repeatable-element-entry').toggleClass('item-closed');
         var thisEditButton = $(this).closest('.repeatable-element-entry').find('.edit-repeatable-element-entry');
         if (thisEditButton.data('itemEditText') === thisEditButton.text()) {
             thisEditButton.text(thisEditButton.data('itemCloseText'));
         } else if (thisEditButton.data('itemCloseText') === thisEditButton.text()) {
             thisEditButton.text(thisEditButton.data('itemEditText'));
         }
     });

     // Initial load up of already saved items
     <?php if($items) {
         $itemNumber = 1;
         foreach ($items as $item) { ?>
             entriesContainer.append(entriesTemplate({
                 title: '<?php    echo $item['title']?>',
                 custom_element_class: '<?php    echo $item['customElementClass']?>',
                 fID: '<?php    echo $item['fID']?>',
                 <?php     if (File::getByID($item['fID'])) { ?>
                 image_url: '<?php     echo File::getByID($item['fID'])->getThumbnailURL('file_manager_listing');?>',
                 <?php     } else { ?>
                 image_url: '',
                 <?php     } ?>
                 sort_order: '<?php    echo $item['sortOrder']?>',
                 item_number: '<?php    echo $itemNumber?>',
                 enable_image: <?php    echo $enableImage?>
             }));
        <?php
            ++$itemNumber;
        }
     } ?>

     attachDelete($('.remove-repeatable-element-entry'));
     attachFileManagerLaunch($('.repeatable-element-image'));
     doSortCount();

 });

    //Extra functionalities
    //Expand or close all items
     $('.edit-all-items').on('click', function() {
         var thisButton = $('.edit-all-items');
         if (thisButton.data('expandText') === thisButton.text()) {
             $('.repeatable-element-entry').removeClass('item-closed');
             thisButton.text(thisButton.data('collapseText'));
             var closeText = $('.edit-repeatable-element-entry').data('itemCloseText');
             $('.edit-repeatable-element-entry').text(closeText);
         } else if (thisButton.data('collapseText') === thisButton.text()) {
             $('.repeatable-element-entry').addClass('item-closed');
             thisButton.text(thisButton.data('expandText'));
             var editText = $('.edit-repeatable-element-entry').data('itemEditText');
             $('.edit-repeatable-element-entry').text(editText);
         };
     });

 // Enable or disable elements
     var enable_image = <?php echo $enableImage?>;

// Toggle images
 $('#toggleImage').click(function() {
     var enableImage = $('#toggleImage option:selected').val();
     if (enableImage == 0) {
         enable_image = 0;
         $('.image-options').addClass('disabled');
     } else if (enableImage == 1) {
         enable_image = 1;
         $('.image-options').removeClass('disabled');
     }
 });

// Toggle crop
 $('#toggleCrop').click(function() {
     var enableCrop = $('#toggleCrop option:selected').val();
     if (enableCrop == 0) {
         $('.crop-options').addClass("disabled");
     } else if (enableCrop == 1) {
         $('.crop-options').removeClass("disabled");
     }
 });
 </script>
