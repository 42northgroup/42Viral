<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach($contents as $content): ?> 
        <url>
            <loc><?php echo $content['Content']['canonical']/*['canonical']*/; ?></loc>

            <lastmod>2005-01-01</lastmod>

            <changefreq>monthly</changefreq>

            <priority>0.8</priority>
        </url>
    <?php endforeach; ?>
</urlset> 