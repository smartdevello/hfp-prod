<?php

add_action('product_cat_edit_form_fields','product_cat_edit_form_fields', 10, 2);
add_action('product_cat_add_form_fields','product_cat_add_form_fields');

add_action('product_cat_edit_form', 'category_edit_form');
add_action('product_cat_add_form','category_edit_form');


function category_edit_form() {
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
            jQuery('#edittag').attr( "enctype", "multipart/form-data" ).attr( "encoding", "multipart/form-data" );
    });
</script>

<?php 
}
function product_cat_add_form_fields($taxonomy) {
    ?>
        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="hcpcs_code"><?php _e('HCPCS code', ''); ?></label>
            </th>
            <td>
                <input type="text" id="hcpcs_code" name="hcpcs_code"/>
            </td>
        </tr>
    <?php
}
function product_cat_edit_form_fields ($tag, $taxonomy) {

?>

    <tr class="form-field">
            <th valign="top" scope="row">
                <label for="hcpcs_code"><?php _e('HCPCS code', ''); ?></label>
            </th>
            <td>
                <input type="text" id="hcpcs_code" name="hcpcs_code" value="<?php echo esc_attr(get_term_meta($tag->term_id, 'hcpcs_code', true)); ?>"/>
            </td>
        </tr>
<?php 
}
add_action( "created_product_cat", "update_product_cat", 10, 2);
add_action("edited_product_cat", "update_product_cat", 10, 2);

function update_product_cat($term_id, $tt_id){
    if (isset($_POST['hcpcs_code'])) {
        update_term_meta($term_id, 'hcpcs_code', $_POST['hcpcs_code']);
    }
}