<div class="sitepack-container">
    <div class="sitepack-heading">
        <a href="https://sitepack.eu" target="_blank">
            <img src="<?php
            echo plugin_dir_url(SITEPACK_PLUGIN_BASENAME) ?>/images/logo_transparent_45.png" alt="SitePack icon"
                 class="sitepack-icon" align="left"/>
        </a>
        <h1>Connect</h1>

        <a href="https://sitepack.nl/?utm_source=wordpress&utm_medium=button_right_top&utm_campaign=wp_plugin"
           target="_blank" rel="noopener"
           class="sitepack-pull-right sitepack-admin-login button">
            <?php
            echo __('Open SitePack', 'sitepack') ?>
            <span class="dashicons dashicons-external"></span>
        </a>
    </div>
    <div class="sitepack-menu">
        <ul>
            <li>
                <a href="<?php echo admin_url('admin.php?page=sitepack') ?>" class="active">
                    <?php echo __('Settings', 'sitepack') ?>
                </a>
            </li>
        </ul>
    </div>

    <div class="sitepack-body">
        <div class="wrap">
            <div class="sitepack-dashboard">
                <div class="sitepack-block">
                    <h3>
                        <?php
                        echo __('API Keys', 'sitepack') ?>
                        <a href="https://sitepack.nl/admin" target="_blank" rel="noopener"
                           class="button sitepack-button-right">
                            <?php
                            echo __('Configure workflow(s)', 'sitepack') ?>
                            <span class="dashicons dashicons-external"></span>
                        </a>
                    </h3>

                    <div class="form-row-group">
                        <label>
                            <?php
                            echo __('Domain', 'sitepack')
                            ?>
                        </label>

                        <input type="text" name="api_key" value="<?php echo get_option('siteurl'); ?>" class="regular-text" />
                    </div>
                    <div class="form-row-group">
                        <label>
                            <?php
                            echo __('API Key', 'sitepack')
                            ?>
                        </label>

                        <input type="text" name="api_key" value="<?php echo get_option(SitePackConnectAdmin::SITEPACK_API_KEY); ?>" class="regular-text" />
                    </div>
                    <div class="form-row-group">
                        <label>
                            <?php
                            echo __('API Secret', 'sitepack')
                            ?>
                        </label>

                        <div class="sitepack-hide" id="sitepack-secret">
                            <button class="button" onclick="jQuery('#sitepack-secret input').toggle();">
                                <?php
                                echo __('Display', 'sitepack')
                                ?>
                            </button>
                            <input type="text" name="api_secret" value="<?php echo get_option(SitePackConnectAdmin::SITEPACK_API_SECRET); ?>" class="regular-text" />
                        </div>
                        <div class="sitepack-hide-toggle">
                        </div>
                    </div>
                </div>
                <div class="sitepack-block">
                    <h3>
                        <?php
                        echo __('eCommerce plugin', 'sitepack')
                        ?>
                    </h3>

                    <?php if(spWooIsActive() === true) : ?>
                    <div class="input-group">
                        <label>
                            <input type="radio" name="ecommerce" value="woo" checked />
                            WooCommerce
                        </label>
                    </div>
                    <?php else: ?>
                    <div class="sitepack-alert sitepack-alert-error">
                        <?php
                        echo __("SitePack Connect needs an eCommerce plugin to display products and process orders. For now, this is only compatible with WooCommerce.", 'sitepack')
                        ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>