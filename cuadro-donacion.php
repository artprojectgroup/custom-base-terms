<?php $plugin = custom_base_terms_plugin($custom_base_terms['plugin_uri']); ?>
<div class="donacion">
  <p>
    <?php _e('If you enjoyed and find helpful this plugin, please make a donation:', 'custom_base_terms'); ?>
  </p>
  <p><a href="<?php echo $custom_base_terms['plugin_url']; ?>" target="_blank" title="<?php _e('Make a donation by ', 'custom_base_terms'); ?>APG"><span class="icon-bills"></span></a></p>
  <div>
    <p>Art Project Group:</p>
    <p><a href="http://www.artprojectgroup.es" title="Art Project Group" target="_blank"><strong class="artprojectgroup">APG</strong></a></p>
  </div>
  <div>
    <p>
      <?php _e('Follow us:', 'custom_base_terms'); ?>
    </p>
    <p><a href="https://www.facebook.com/artprojectgroup" title="<?php _e('Follow us on ', 'custom_base_terms'); ?>Facebook" target="_blank"><span class="icon-facebook6"></span></a> <a href="https://twitter.com/artprojectgroup" title="<?php _e('Follow us on ', 'custom_base_terms'); ?>Twitter" target="_blank"><span class="icon-social19"></span></a> <a href="https://plus.google.com/+ArtProjectGroupES" title="<?php _e('Follow us on ', 'custom_base_terms'); ?>Google+" target="_blank"><span class="icon-google16"></span></a> <a href="http://es.linkedin.com/in/artprojectgroup" title="<?php _e('Follow us on ', 'custom_base_terms'); ?>LinkedIn" target="_blank"><span class="icon-logo"></span></a></p>
  </div>
  <div>
    <p>
      <?php _e('More plugins:', 'custom_base_terms'); ?>
    </p>
    <p><a href="http://profiles.wordpress.org/artprojectgroup/" title="<?php _e('More plugins on ', 'custom_base_terms'); ?>WordPress" target="_blank"><span class="icon-wordpress2"></span></a></p>
  </div>
  <div>
    <p>
      <?php _e('Contact with us:', 'custom_base_terms'); ?>
    </p>
    <p><a href="mailto:info@artprojectgroup.es" title="<?php _e('Contact with us by ', 'custom_base_terms'); ?>e-mail"><span class="icon-open21"></span></a> <a href="skype:artprojectgroup" title="<?php _e('Contact with us by ', 'custom_base_terms'); ?>Skype"><span class="icon-social6"></span></a></p>
  </div>
  <div>
    <p>
      <?php _e('Documentation and Support:', 'custom_base_terms'); ?>
    </p>
    <p><a href="<?php echo $custom_base_terms['plugin_url']; ?>" title="<?php echo $custom_base_terms['plugin']; ?>"><span class="icon-work"></span></a></p>
  </div>
  <div>
    <p> <?php echo sprintf(__('Please, rate %s:', 'custom_base_terms'), $custom_base_terms['plugin']); ?> </p>
    <div class="star-holder rate">
      <div style="width: <?php echo esc_attr(str_replace(',', '.', $plugin['rating'])); ?>px;" class="star-rating"></div>
      <div class="star-rate"> <a title="<?php _e('***** Fantastic!', 'custom_base_terms'); ?>" href="<?php echo $custom_base_terms['puntuacion']; ?>?rate=5#postform"><span></span></a> <a title="<?php _e('**** Great', 'custom_base_terms'); ?>" href="<?php echo $custom_base_terms['puntuacion']; ?>?rate=4#postform"><span></span></a> <a title="<?php _e('*** Good', 'custom_base_terms'); ?>" href="<?php echo $custom_base_terms['puntuacion']; ?>?rate=3#postform"><span></span></a> <a title="<?php _e('** Works', 'custom_base_terms'); ?>" href="<?php echo $custom_base_terms['puntuacion']; ?>?rate=2#postform"><span></span></a> <a title="<?php _e('* Poor', 'custom_base_terms'); ?>" href="<?php echo $custom_base_terms['puntuacion']; ?>?rate=1#postform"><span></span></a> </div>
    </div>
  </div>
</div>