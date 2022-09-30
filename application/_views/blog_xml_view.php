<?php
echo '<?xml version="1.0" encoding="UTF-8" ?>';
//$datatime = date('Y-m-d') . 'T' . date('H:i:sT:00');
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <url>
        <loc><?php echo base_url('blog'); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>

    <?php
    $get_blog = $this->sitemap_model->getBlog();
    if ($get_blog->num_rows() > 0) {
        foreach ($get_blog->result() as $row_blog) {
            ?>
            <url>
                <loc><?php echo base_url() . "blog/detail/" . $row_blog->article_slug; ?></loc>
                <changefreq>weekly</changefreq>
                <priority>0.90</priority>
            </url>
            <?php
        }
    }
    ?>

</urlset>

