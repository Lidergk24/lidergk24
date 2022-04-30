<?php  include ROOT . '/views/layouts/header.php'; 
$environment = include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php'); ?>
<div class="breadcrumb-wrapper">
   <div class="container">
      <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
         <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item"href="/" title="Главная"><span itemprop="name">ГЛАВНАЯ</span></a><meta itemprop="position" content="1"/></li>
         <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item"href="/article" title="Статьи"><span itemprop="name">Новости</span></a><meta itemprop="position" content="2"/></li>
         <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item"><span itemprop="name"><?php echo $atricleOnes['article_name']; ?></span></a><meta itemprop="position" content="3"/></li>
      </ul>
   </p>
</p>
<section class="politics article-page recipes-page">
   <div class="container">
      <h1><?php echo $atricleOnes['article_name']; ?></h1>
      <div class="politics__content article-page__content recipes-page__content">
        <img src=" <?php echo $environment["base_url"]; ?> /upload/images/<?php echo $atricleOnes['article_image']; ?>" alt="<?php echo $atricleOnes['article_name']; ?>">
        <?php echo $atricleOnes['article_text']; ?>
   </div>
</section>
</div>
<?php  include ROOT . '/views/layouts/footer.php'; ?>