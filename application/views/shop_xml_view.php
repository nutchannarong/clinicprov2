<?php
echo '<?xml version="1.0" encoding="UTF-8" ?>';
//$datatime = date('Y-m-d') . 'T' . date('H:i:sT:00');
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <url>
        <loc><?php echo base_url('shops'); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>

    <?php
    $get_shop = $this->sitemap_model->getShop();
    if ($get_shop->num_rows() > 0) {
        foreach ($get_shop->result() as $row_shop) {
            ?>
            <url>
                <loc><?php echo base_url() . 'shop/' . $row_shop->shop_id; ?></loc>
                <changefreq>weekly</changefreq>
                <priority>0.90</priority>
            </url>
            <?php
        }
    }
    ?>

</urlset>

