<?php

/**
 * Контроллер ProductController
 */

class ProductController
{
    /**
     * Action для страницы просмотра товара
     */
    public function actionView($productId)
    {

        $is_custom = false;

        if (strpos($productId, '62-') !== false) {

            $is_custom = true;
            $productP = Product::getProductByIdCustom($productId);
            if ($productP != false) {
                $product =  $productP;
            } else {
                $product = Product::getHistoryProductByPartN($productId);
            }
            $title = $product['product_name'] . ' в интернет-магазине ЛИДЕР';
            $description = $product['product_name'] . ' купить в Москве оптом и в розницу по цене ' . $product['product_price'] . ' ₽ — интернет магазин Лидер';
             $similarProduct = Category::similarProductsCustom($product['product_category']);
        } else {

            $productP = Product::getProductById($productId);
            if ($productP != false) {
                $product =   $productP;
            } else {
                $product = Product::getHistoryProductByPartN($productId);
            }
            $similarProduct  = Category::similarProducts($product['product_category']);
        }

        if ($product != false) {
            $productByPartNumber = $product['product_part_number'];
            $productAtribut = Product::getProductAtributs($productByPartNumber);

            if ($is_custom) {
                $breadCrumbs = Product::breadcrumbsCustom($product['product_part_number']);
                $searchParentCat = Product::parentBreadcrumbsCustom($breadCrumbs[0]);
                $bossCat = Product::bossCatCustom($searchParentCat[0]);
            } else {
                $breadCrumbs = Product::breadcrumbs($productByPartNumber);
                $searchParentCat = Product::parentBreadcrumbs($breadCrumbs[0]);
                $bossCat = Product::bossCat($searchParentCat[0]);
            }

            if (count($similarProduct) < 6) {

                $allParentsCategory = Category::allParentsCategory($searchParentCat["cat_affiliate_id"]);

                $randCat = [];
                foreach ($allParentsCategory as $allParentsCategoryOne) {
                    $randCat[$k] = $allParentsCategoryOne["cat_code"];
                    $k++;
                }

                $result =  '"' . implode('", "', $randCat) . '"';
                $totalItems = count($similarProduct);
                $potrebCount = 6 - $totalItems;
                $searchNowItems = Category::searchNowItems($result, $potrebCount);
                $similarProduct = array_merge($similarProduct, $searchNowItems);
            }
            $characteristics = [];
            $videoYouTube = '';
            $sales = '';
            $oneAtribut = explode(";", $product['product_atributs']);
            $oneAtributUnique = array_unique($oneAtribut);
            foreach ($oneAtributUnique as $onePairAttribute) {
                $svoistvaOne = explode(":",  $onePairAttribute);
                $svoistvaOnes = $svoistvaOne[1];
                $featureDecoded = Product::getAtributsOne($svoistvaOnes);
                foreach ($featureDecoded as $feature) {
                    if ($feature["atributTitle"] == 'Видео YouTube') {
                        $videoYouTube = $feature['atributValue'];
                    }
                    if ($feature["atributTitle"] == 'Количество в коробке, шт') {
                        $priceForCorob = $feature['atributValue'];
                    }
                    if ($feature["atributTitle"] == 'Количество в упаковке, шт') {
                        $priceForUpak = $feature['atributValue'];
                    }
                    if ($feature["atributTitle"] == 'Единица измерения') {
                        $izm = $feature['atributValue'];
                    } else {
                        $izm = ' шт.';
                    }
                    if ($feature["atributTitle"] == 'АКЦИЯ') {
                        $sales = $feature['atributValue'];
                    }
                    $characteristics[][$feature["atributTitle"]] = $feature['atributValue'] ;
                }
            }
            $characteristics[]["Минимальное количество для заказа"] = $product["miz_zakaz"]. " ".$izm;
            $attributeGroups = array ("Высота, мм" => "Размеры", "Диаметр, мм" => "Размеры","Длина, мм" => "Размеры","Ширина, мм" => "Размеры", 
            "Бренд" => "Производитель","Страна" => "Производитель",
            "Количество в коробке, пар" => "Параметры отгрузки", "Минимальное количество для заказа" => "Параметры отгрузки","Количество в коробке, упак" => "Параметры отгрузки", "Количество в коробке, шт" => "Параметры отгрузки", "Количество в упаковке, пар" => "Параметры отгрузки", "Количество в упаковке, шт" => "Параметры отгрузки", "Минимальное количество для заказа" => "Параметры отгрузки",
            "Аромат" => "Прочие данные", "Количество секций" => "Прочие данные","Назначение" => "Прочие данные", "Разогрев в СВЧ" => "Прочие данные", "Система" => "Прочие данные", "Сложение" => "Прочие данные",
            "Форма" => "Прочие данные",  "Тиснение" => "Прочие данные",
            "Диаметр втулки, мм" => "Свойства товара","Длина, м/рул" => "Свойства товара","Количество слоев" => "Свойства товара","Листов, шт" => "Свойства товара","Материал" => "Свойства товара","Объем, л" => "Свойства товара","Объем, мл" => "Свойства товара", "Вес, гр"=> "Свойства товара", "Опудренность" => "Свойства товара","Перфорация" => "Свойства товара","Плотность, гр/м.кв" => "Свойства товара","Плотность, мкм" => "Свойства товара","Размер" => "Свойства товара","Размер листа, мм" => "Свойства товара","Состав" => "Свойства товара","Толщина" => "Свойства товара","Толщина обмотки, мм" => "Свойства товара","Цвет" => "Свойства товара"
        );
        $order = array("Свойства товара","Размеры","Производитель","Параметры отгрузки","Прочие данные");

            $attributeToDisplayInProductPage = [];
            foreach ($characteristics as $characteristicGroup) {
                foreach ($characteristicGroup as $characteristic => $characteristicValue) {
                    foreach ($attributeGroups as $oneAttributeGroup => $oneAttributeGroupValue) {
                        if ($oneAttributeGroup == $characteristic) {
                            $groupName = $oneAttributeGroupValue;
                            $innerArrayToDisplay = array($characteristic => $characteristicValue);
                            $attributeToDisplayInProductPage[$groupName][] = $innerArrayToDisplay;
                        }
                    }
                }
            }
             uksort($attributeToDisplayInProductPage, function($key1, $key2) use ($order) {
                return (array_search($key1, $order) > array_search($key2, $order));
            });
            $nal = $product['product_warehouse'];
                  if (($nal <= 0)) {
                   $left =  "";
                   } else if (($nal > 0) && (($nal <= 10))) {
                    $left = " менее 10 шт.";
                   } else if (($nal > 10) && (($nal <= 99))) {
                    $left =  " более 10 шт.";
                   } else if (($nal >= 100) && (($nal < 1000))) {
                    $left = " более 100 шт.";
                   } else if (($nal >= 1000) && (($nal < 10000))) {
                    $left =" более 1000 шт.";
                   } else if (($nal >= 10000) && (($nal <= 1000000))) {
                    $left = " более 10.000 шт."; } 
            $title = $product['product_name'] . ' в интернет-магазине ЛИДЕР';
            $description = $product['product_name'] . ' купить в Москве оптом и в розницу по цене ' . $product['product_price'] . ' ₽ — интернет магазин Лидер';
            $comp_prods_arr = [];
            foreach (json_decode($product["compatible_product"], true) as $CompProducts) {
                foreach ($CompProducts as $oneCompProduct) {
                    $comp_prods_arr[] = strval($oneCompProduct);
                }
            }
            $compatibleProducts = Product::getCompatibleProducts($comp_prods_arr);
            $brand = Product::brandDescription($product['product_brand']);
            require_once(ROOT . '/views/product/view.php');
            return true;
        }
    }
}
