<div class="sitepack-container">
    <div class="sitepack-heading">
        <a href="https://sitepack.eu" target="_blank">
            <img src="<?= esc_url(plugin_dir_url(SITEPACK_PLUGIN_BASENAME)) ?>/images/logo_transparent_45.png" alt="SitePack icon"
                 class="sitepack-icon" align="left"/>
        </a>
        <h1>Connect</h1>

        <a href="https://sitepack.nl/?utm_source=wordpress&utm_medium=button_right_top&utm_campaign=wp_plugin"
           target="_blank" rel="noopener"
           class="sitepack-pull-right sitepack-admin-login button">
            <?php
            echo __('Open SitePack', 'sitepack-connect') ?>
            <span class="dashicons dashicons-external"></span>
        </a>
    </div>
    <div class="sitepack-menu">
        <ul>
            <li>
                <a href="<?= esc_url(admin_url('admin.php?page=sitepack')) ?>" class="active">
                    <?= __('Settings', 'sitepack-connect') ?>
                </a>
            </li>
        </ul>
    </div>

    <div class="sitepack-body">
        <div class="wrap">
            <div class="sitepack-dashboard">
                <div class="sitepack-block">
                    <h3>
                        <?= __('API Keys', 'sitepack-connect') ?>
                        <a href="https://sitepack.nl/admin" target="_blank" rel="noopener"
                           class="button sitepack-button-right">
                            <?= __('Configure workflow(s)', 'sitepack-connect') ?>
                            <span class="dashicons dashicons-external"></span>
                        </a>
                    </h3>

                    <div class="form-row-group">
                        <label>
                            <?= __('Domain', 'sitepack-connect')?>
                        </label>

                        <input type="text" name="api_key" value="<?= esc_url(get_option('siteurl')); ?>" class="regular-text" />
                    </div>
                    <div class="form-row-group">
                        <label>
                            <?= __('API Key', 'sitepack-connect')?>
                        </label>

                        <input type="text" name="api_key" value="<?= esc_attr(get_option(SitePackConnectAdmin::SITEPACK_API_KEY)); ?>" class="regular-text" />
                    </div>
                    <div class="form-row-group">
                        <label>
                            <?= __('API Secret', 'sitepack-connect') ?>
                        </label>

                        <div class="sitepack-hide" id="sitepack-secret">
                            <button class="button" onclick="jQuery('#sitepack-secret input').toggle();">
                                <?= __('Display', 'sitepack-connect')?>
                            </button>
                            <input type="text" name="api_secret" value="<?= esc_attr(get_option(SitePackConnectAdmin::SITEPACK_API_SECRET)); ?>" class="regular-text" />
                        </div>
                        <div class="sitepack-hide-toggle">
                        </div>
                    </div>
                </div>
                <div class="sitepack-block">
                    <h3>
                        <?= __('eCommerce plugin', 'sitepack-connect') ?>
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
                        <?= __("SitePack Connect needs an eCommerce plugin to display products and process orders. For now, this is only compatible with WooCommerce.", 'sitepack-connect') ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>