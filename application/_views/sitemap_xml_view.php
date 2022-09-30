<?php
echo '<?xml version="1.0" encoding="UTF-8" ?>';
//$datatime = date('Y-m-d') . 'T' . date('H:i:sT:00');
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <url>
        <loc><?php echo base_url(); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>1.00</priority>
    </url>
    <url>
        <loc><?php echo base_url('promotions'); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.90</priority>
    </url>
    <url>
        <loc><?php echo base_url('shops'); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.90</priority>
    </url>
    <url>
        <loc><?php echo base_url('review'); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.80</priority>
    </url>
    <url>
        <loc><?php echo base_url('blog'); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.90</priority>
    </url>
    <url>
        <loc><?php echo base_url('authen'); ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.80</priority>
    </url>
    <url>
        <loc><?php echo base_url('about'); ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.80</priority>
    </url>
    <url>
        <loc><?php echo base_url('conditions'); ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.80</priority>
    </url>
    <url>
        <loc><?php echo base_url('privacypolicy'); ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.80</priority>
    </url>
    <url>
        <loc><?php echo base_url('contact'); ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.80</priority>
    </url>
    <url>
        <loc><?php echo base_url('sitemap'); ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.80</priority>
    </url>
</urlset>
