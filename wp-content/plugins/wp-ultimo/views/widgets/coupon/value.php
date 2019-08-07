<div class="submitbox" id="submitpost">
  
  <div id="minor-publishing">
      
    <!-- .misc-pub-section -->
    <div class="misc-pub-section curtime misc-pub-curtime">
      
      <p class="wpultimo-price-text">
        <?php _e('Use this block to set the value of the coupon.', 'wp-ultimo'); ?>
      </p>

      <div class="wpultimo-price wpultimo-price-first" style="margin-top: 10px;">
        <label for="type">
          <?php _e('Coupon Type', 'wp-ultimo'); ?>
          </label>

        <select id="type" name="type" style="width: 100%;">
          <?php foreach ($coupon->types as $type => $type_slug) : ?>
            <option <?php selected($coupon->type, $type); ?> value="<?php echo $type; ?>"><?php echo $type_slug; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      
      <div class="wpultimo-price wpultimo-price-first" style="margin-top: 10px;">
        <label for="value">
          <?php _e('Coupon Value', 'wp-ultimo'); ?>
          <?php echo WU_Util::tooltip(__('Set the absolute value of the coupon.', 'wp-ultimo')); ?>
        </label>
        <input placeholder="0" step="0.01" type="number" id="value" name="value" class="" value="<?php echo $coupon->value; ?>">
      </div>
    
      <div class="clear"></div>
      
    </div>
    
    <div class="clear"></div>
  </div>
  
  <div id="major-publishing-actions">

    <input name="original_publish" type="hidden" id="original_publish" value="Publish">
    <input type="submit" name="save_coupon" id="publish" class="button button-primary button-large button-streched" value="<?php echo $edit ? __('Update Coupon', 'wp-ultimo') : __('Create Coupon', 'wp-ultimo'); ?>">
    
    <div class="clear"></div>
  </div>
  
</div>