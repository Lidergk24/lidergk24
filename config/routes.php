<?php
return array(
'archive/archiveProducts' => 'archive/archiveProducts',
'archiveCustom/archiveCustomProducts' => 'archiveCustom/archiveCustomProducts',
// Товар:
'product/([0-9]+)' => 'product/view/$1', // actionView в ProductController
// Каталог:
'catalog' => 'catalog/index', // actionIndex в CatalogController
'article' => 'catalog/article',
// Категория товаров:
'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2', // actionCategory в CatalogController
'category/([a-z]+)' => 'catalog/category/$1', // actionCategory в CatalogController
//Илья сказал, что продукты из категории под заказ должны быть полностью исключены с сайта, но я оставляю комментарии чтобы их можно было вернуть позже
// 'custom' => 'catalog/custom',
'special'=> 'catalog/special',
//Илья сказал, что продукты из категории под заказ должны быть полностью исключены с сайта, но я оставляю комментарии чтобы их можно было вернуть позже
// 'is/([a-z-0-9+]+)' => 'catalog/is/$1',
// Корзина:
'cart/order' => 'cart/checkout', // actionCheckout в CartController
'cart/addAjax/(c?[0-9]+)' => 'cart/addAjax/$1', // actionAddAjax в CartController
'cart/setAjax/(c?[0-9]+)' => 'cart/setAjax/$1', // actionSetAjax в CartController
'cart/delAjax/(c?[0-9]+)' => 'cart/delAjax/$1', // actionDelAjax в CartController
//'cart/add/([0-9]+)' => 'cart/add/$1', // actionAdd в CartController
'cart/couponAjax' => 'cart/couponAjax', // actionCouponAjax в CartController
'cart' => 'cart/index', // actionIndex в CartController
// спец цены
'special/listAjax' => 'special/listAjax',
'special/setAjax/([0-9-]+)' => 'special/setAjax/$1',
// Пользователь:
'user/register' => 'user/register', 
'user/login' => 'user/login', 
'user/logout' => 'user/logout', 
'cabinet/addur' => 'cabinet/addur', 
'cabinet/addfiz' => 'cabinet/addfiz', 
'cabinet/edit' => 'cabinet/edit', 
'cabinet/delete' => 'cabinet/delete/$1',
'cabinet/adressdel' => 'cabinet/adressdel/$1', 
'cabinet/delfiz' => 'cabinet/delfiz/$1', 
'cabinet/urprofile/([0-9]+)' => 'cabinet/urprofile/$1',
'cabinet/editprofile/([0-9]+)' => 'cabinet/editprofile/$1', 
'cabinet/history' => 'cabinet/history', 
'cabinet/sale' => 'cabinet/sale', 
'cabinet/view_order/([0-9]+)' => 'cabinet/view_order/$1', 
'cabinet/adress' => 'cabinet/adress',
'cabinet/newadd' => 'cabinet/newadd',
'cabinet/repeat/([0-9]+)' => 'cabinet/repeat/$1',
'cabinet/special' =>'cabinet/special',
'cabinet/specialend' =>'cabinet/specialend',
'cabinet/specialorder' =>'cabinet/specialorder',
'cabinet' => 'cabinet/index',
// Управление заказами:
'admin/order/view/([0-9]+)' => 'adminOrder/view/$1', 
'admin/order' => 'adminOrder/index', 
'admin/addadressclient' => 'admin/addadressclient', 
'admin/addnewprofile' => 'admin/addNewProfile', 
'admin/nprofile' => 'admin/nprofile', 
'admin/clients' => 'admin/clients',
'admin/thisbrand' => 'admin/thisbrand',
'admin/addmanager' => 'admin/addmanager',
'admin/allmg' => 'admin/allmg',
'admin/operators' => 'admin/operators',
'admin/deleteOperator' => 'admin/deleteOperator',
'admin/addOperator' => 'admin/addOperator',
'admin/roles' => 'admin/roles',
'admin/addRole' => 'admin/addRole',
'admin/addphone' => 'admin/addphone',
'admin/removeRole' => 'admin/removeRole',
'admin/updateCatFilters' => 'admin/updateCatFilters',
'admin/editbook/([0-9]+)' => 'admin/editbook/$1',
'admin/allbook' => 'admin/allbook',
'admin/book' => 'admin/book',
'admin/drop' => 'admin/drop',
'admin/zakaz/([0-9+]+)' => 'adminOrder/zakaz/$1', 
'admin/statdelete/([0-9]+)' => 'admin/statdelete/$1',
'admin/fiddelete/([0-9]+)' => 'admin/fiddelete/$1',
'admin/catfiddelete/([0-9]+)' => 'admin/catfiddelete/$1',
'admin/allfiddelete' => 'admin/allfiddelete',
'admin/editbook/([0-9]+)' => 'admin/editbook/$1',
'admin/allbook' => 'admin/allbook', 
'admin/book' => 'admin/book',
'admin/fids' => 'admin/fids',
'admin/editbfid/([0-9]+)' => 'admin/editfid/$1',
'admin/addfid' => 'admin/addfid',
'admin/addCatfid' => 'admin/addCatfid',
'admin/addAllfid' => 'admin/addAllfid',
'admin/rules' => 'admin/rules',
'admin/setRulesGroup' => 'admin/setRulesGroup',
'admin/upprice' => 'admin/upprice',
'admin/deletebrand' => 'admin/deletebrand',
'admin/editbrand/([0-9]+)' => 'admin/editbrand/$1',
'admin/send' => 'admin/send',
'admin/ruldel/([0-9]+)' => 'admin/ruldel/$1',
'admin/profiles/([0-9]+)' => 'admin/profiles/$1',
'admin/ordprof/([0-9+]+)' => 'admin/ordprof/$1',
'admin/allrules' => 'admin/allrules',
'admin/price' => 'admin/price',
'admin/addbaner' => 'admin/addbaner',
'admin/addSquareBaner' => 'admin/addSquareBaner',
'admin/banners' => 'admin/banners',
'admin/renewBrandsMainPage' => 'admin/renewBrandsMainPage',
'admin/ac' => 'admin/ac',
'admin/onlysales' => 'admin/onlysales',
'admin/salesedit/([0-9+]+)' => 'admin/salesedit',
'admin/hit' => 'admin/hit',
'admin/saleblock' => 'admin/saleblock',
'admin/allprofile' => 'admin/allprofile',
'admin/coupon' => 'admin/coupon',
'admin/addcoupon' => 'admin/addcoupon',
'admin/report' => 'admin/report',
'admin/deletecoupon/([0-9+]+)' => 'admin/deletecoupon',
'admin/category' => 'admin/category',
'admin/businesscategory' => 'admin/businesscategory',
'admin/podbizcat/([a-z-0-9+]+)' => 'admin/podbizcat',
'admin/renumerateBusinessCat' => 'admin/RenumerateBusinessCat',
'admin/subcat/([a-z-0-9+]+)' => 'admin/subcat',
'admin/rephone' => 'admin/rephone',
'admin/endcat/([a-z-0-9+]+)' => 'admin/endcat',
'admin/metacat/([a-z-0-9+]+)' => 'admin/metacat',
'admin/searchproduct' => 'admin/searchproduct',
// Админпанель:
'admin' => 'admin/index', 
// О магазине
'contacts' => 'site/contact', 'about' => 'site/about', 
'podcat/([a-z]+)' => 'catalog/catmy/$1', 
'art/([a-z]+)' => 'catalog/one/$1',
'podcat/([0-9]+)/page-([0-9]+)' => 'catalog/catmy/$1/$2', 
'brand' => 'site/brand', 
'delivery' => 'site/delivery', 
'pay' => 'site/pay', 
'search' => 'site/search', 
'brendirovanie' => 'site/brendirovanie', 
'discount' => 'site/discount', 
'night' => 'site/night', 
'manager' => 'site/manager', 
'brandy' => 'site/brandy', 
'postavshchikam' => 'site/postavshchikam', 
'privacy' => 'site/privacy',
'google' => 'site/google',
'yandex' => 'site/yandex',
'sitemap' => 'site/sitemap',
'agreement' => 'site/agreement',
'postponement' => 'site/postponement',
'vacancy' => 'site/vacancy',
'region' => 'site/region',
'loyalty' => 'site/loyalty',
'selling' => 'site/selling',
'business/([a-z-0-9+]+)' => 'site/business',
'ajax/sortbaner' => 'site/sortbaner',
'ajax/sortsales' => 'site/sortsales',
'ajax/deletebaner' => 'site/deletebaner',
'ajax/salesdel' => 'site/salesdel',
'ajax/sendproperty' => 'site/sendproperty',
// Главная страница
'index.php' => 'site/index', // actionIndex в SiteController
'' => 'site/index', // actionIndex в SiteController
);