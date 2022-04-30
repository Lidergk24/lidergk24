<?php header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'."\n\n";

    $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
    $params = include($paramsPath);
    $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
    
    $glav = mysqli_query($con, "select cat_slug from Category");
    
    foreach ( $glav as $glavOne ) { 
        
        echo "<url>\n";
        echo "\t<loc>https://lider-gk24.ru/category/{$glavOne['cat_slug']}</loc>\n";
        echo "\t<priority>1</priority>";
        echo "\t </url> \n";  
        
    }
    
    $categorys = mysqli_query($con, "select cat_slug from Product_category");
    
    foreach ( $categorys as $category ) {
        
        echo "<url>\n";
        echo "\t<loc>https://lider-gk24.ru/podcat/{$category['cat_slug']}</loc>\n";
        echo "\t<priority>0.9</priority>";
        echo "</url> \n"; 
        
    }
    
    $items = mysqli_query($con, "SELECT product_part_number, product_date from Product");
    

    foreach ( $items as $item ) {
        $gfgg = date("Y-m-d", strtotime($item['product_date']));
        echo "<url>\n";
        echo "\t<loc>https://lider-gk24.ru/product/{$item['product_part_number']}</loc>\n";
        echo "\t<priority>0.8</priority>";
        echo "\t </url> \n";
    } 
    
        echo "<url>\n";
        echo "\t<loc>https://lider-gk24.ru/about/</loc>\n";
        echo "\t<priority>0.7</priority>";
        echo "\t </url> \n";
        
        echo "<url>\n";
        echo "\t<loc>https://lider-gk24.ru/contacts/</loc>\n";
        echo "\t<priority>0.7</priority>";
        echo "\t </url> \n";
        
        echo "<url>\n";
        echo "\t<loc>https://lider-gk24.ru/brendirovanie/</loc>\n";
        echo "\t<priority>0.7</priority>";
        echo "\t </url> \n";
        
        echo "<url>\n";
        echo "\t<loc>https://lider-gk24.ru/delivery/</loc>\n";
        echo "\t<priority>0.7</priority>";
        echo "\t </url> \n";
        
        echo "<url>\n";
        echo "\t<loc>https://lider-gk24.ru/pay/</loc>\n";
        echo "\t<priority>0.7</priority>";
        echo "\t </url> \n";
        
        echo "<url>\n";
        echo "\t<loc>https://lider-gk24.ru/discount/</loc>\n";
        echo "\t<priority>0.7</priority>";
        echo "\t </url> \n";
        
        echo "<url>\n";
        echo "\t<loc>https://lider-gk24.ru/privacy/</loc>\n";
        echo "\t<priority>0.7</priority>";
        echo "\t </url> \n";
        
        echo "<url>\n";
        echo "\t<loc>https://lider-gk24.ru/postavshchikam/</loc>\n";
        echo "\t<priority>0.7</priority>";
        echo "\t </url> \n";
        
        echo "<url>\n";
        echo "\t<loc>https://lider-gk24.ru/night/</loc>\n";
        echo "\t<priority>0.7</priority>";
        echo "\t </url> \n";
        
        echo "<url>\n";
        echo "\t<loc>https://lider-gk24.ru/manager/</loc>\n";
        echo "\t<priority>0.7</priority>";
        echo "\t </url> \n";
        
        echo "<url>\n";
        echo "\t<loc>https://lider-gk24.ru/article/</loc>\n";
        echo "\t<priority>0.7</priority>";
        echo "\t </url> \n";
        
        echo "<url>\n";
        echo "\t<loc>https://lider-gk24.ru/article/</loc>\n";
        echo "\t<priority>0.7</priority>";
        echo "\t </url> \n";
        
        echo "<url>\n";
        echo "\t<loc>https://lider-gk24.ru/brandy/</loc>\n";
        echo "\t<priority>0.7</priority>";
        echo "\t </url> \n";

    $articles = mysqli_query($con, "select article_slug, article_date from article");
    
    foreach ( $articles as $article ) { 
        
        echo "<url>\n";
        echo "\t<loc>https://lider-gk24.ru/art/{$article['article_slug']}</loc>";
        echo "\t<priority>0.6</priority>";
        echo "</url> \n";
        
    }
        
    $brands = mysqli_query($con, "Select brand_name from Product_brand");
        
    foreach ( $brands as $brand ) {
       
        echo "<url>\n";
        $brand_name = str_replace('&', '&amp;', $brand['brand_name']);
        echo "\t<loc>https://lider-gk24.ru/brand/"."{$brand_name}"."</loc>";
        echo "\t<priority>0.6</priority>";
        echo "</url> \n";
        
    }
    
echo "</urlset>\n\n";