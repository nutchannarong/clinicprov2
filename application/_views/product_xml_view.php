<?php
echo '<?xml version="1.0" encoding="UTF-8" ?>';
//$datatime = date('Y-m-d') . 'T' . date('H:i:sT:00');
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <url>
        <loc><?php echo base_url('promotions'); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>

    <?php
    $get_product = $this->sitemap_model->getProduct();
    if ($get_product->num_rows() > 0) {
        foreach ($get_product->result() as $row_product) {
            ?>
            <url>
                <loc><?php echo base_url() . 'promotion/' . $row_product->product_slug; ?></loc>
                <changefreq>weekly</changefreq>
                <priority>0.90</priority>
            </url>
            <?php
        }
    }
    ?>

</urlset>

