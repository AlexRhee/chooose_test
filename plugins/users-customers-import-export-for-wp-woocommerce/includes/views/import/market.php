<style>
    .box14{
        width: 30%;
        margin-top:2px;
        min-height: 310px;
        margin-right: 10px;
        padding:10px;
        position:absolute;
        z-index:1;
        right:0px;
        float:right;
        background: -webkit-gradient(linear, 0% 20%, 0% 92%, from(#fff), to(#f3f3f3), color-stop(.1,#fff));
        border: 1px solid #ccc;
        -webkit-border-radius: 60px 5px;
        -webkit-box-shadow: 0px 0px 35px rgba(0, 0, 0, 0.1) inset;
    }
    .box14_ribbon{
        position:absolute;
        top:0; right: 0;
        width: 130px;
        height: 40px;
        background: -webkit-gradient(linear, 555% 20%, 0% 92%, from(rgba(0, 0, 0, 0.1)), to(rgba(0, 0, 0, 0.0)), color-stop(.1,rgba(0, 0, 0, 0.2)));
        border-left: 1px dashed rgba(0, 0, 0, 0.1);
        border-right: 1px dashed rgba(0, 0, 0, 0.1);
        -webkit-box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.2);
        -webkit-transform: rotate(6deg) skew(0,0) translate(-60%,-5px);
    }
    .box14 h3
    {
        text-align:center;
        margin:2px;
    }
    .box14 p
    {
        text-align:center;
        margin:2px;
        border-width:1px;
        border-style:solid;
        padding:5px;
        border-color: rgb(204, 204, 204);
    }
    .box14 span
    {
        background:#fff;
        padding:5px;
        display:block;
        box-shadow:green 0px 3px inset;
        margin-top:10px;
    }
    .box14 img {
        width: 40%;
        padding-left:30%;
        margin-top: 5px;
    }
    .table-box-main {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }

    .table-box-main:hover {
        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
    }
</style>
<div class="box14 table-box-main">
    <h3>
       <center><a href="https://www.xadapter.com/" target="_blank" style="text-decoration:  none;color:black;" >XAdapter</a></center></h3> 
       <hr>
       <img src="https://cdn.xadapter.com/wp-content/uploads/2016/10/4-WordPress-Users-WooCommerce-Customers-Import-Export-Plugin.jpg">
       <h3>WordPress Users & WooCommerce Customers Import Export Plugin</h3>

    <br /> <center><a href="http://www.xadapter.com/product/wordpress-users-woocommerce-customers-import-export/" target="_blank" class="button button-primary">Upgrade to Premium Version</a></center>
    <span> 
    <ul style="list-style: disc; margin-left: 1px;">
				<li style='color:red;'><strong><?php _e('Your Business is precious! Go Premium!','wf_customer_import_export'); ?></strong></li>
        
                <li><?php _e('HikeForce Import Export Users Plugin Premium version helps you to seamlessly import/export Customer details into your Woocommerce Store.', 'wf_customer_import_export'); ?></li>
        
                <li><?php _e('Export/Import WooCommerce Customer details into a CSV file.', 'wf_customer_import_export'); ?><strong><?php _e('( Basic version supports only WordPress User details )', 'wf_customer_import_export'); ?></strong></li>
                <li><?php _e('Option to choose All Roles or Multiple Roles while export (Basic Supports only single role at a time).', 'wf_customer_import_export'); ?></li>
                <li><?php _e('Various Filter options for exporting Customers.', 'wf_customer_import_export'); ?></li>
                <li><?php _e('Various Filter options for exporting Customers.', 'wf_customer_import_export'); ?></li>
                <li><?php _e('Map and Transform fields while Importing Customers.', 'wf_customer_import_export'); ?></li>
                <li><?php _e('Change values while improting Customers using Evaluation Fields.', 'wf_customer_import_export'); ?></li>
                <li><?php _e('Choice to Update or Skip existing imported Customers.', 'wf_customer_import_export'); ?></li>
                <li><?php _e('Choice to Send or Skip Emails for newly imported Customers.', 'wf_customer_import_export'); ?></li>
                <li><?php _e('WPML Supported. French language support Out of the Box.', 'wf_customer_import_export'); ?></li>
                <li><?php _e('Import/Export file from/to a remote server via FTP in Scheduled time interval with Cron Job.', 'wf_customer_import_export'); ?></li>
                <li><?php _e('Excellent Support for setting it up!', 'wf_customer_import_export'); ?></li>
    </ul>
    </span>
    
    <center> <a href="https://www.xadapter.com/category/documentation/wordpress-users-woocommerce-customers-import-export/" target="_blank" class="button button-primary">Documentation</a> <a href="http://userexportimportwoodemo.hikeforce.com/wp-login.php?redirect_to=http%3A%2F%2Fuserexportimportwoodemo.hikeforce.com%2Fwp-admin%2Fadmin.php%3Fpage%3Dhf_wordpress_customer_im_ex&reauth=1" target="_blank" class="button button-primary">Live Demo</a> <a href="<?php echo plugins_url( 'Sample_Users.csv', WF_CustomerImpExpCsv_FILE ); ?>" target="_blank" class="button button-primary"><?php _e('Sample User CSV', 'wf_customer_import_export'); ?></a></center>
</div>