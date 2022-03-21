<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';


$APPLICATION->SetTitle('Your title of catalog'); //тоже можно вынести в helper
/**
 *  часть параметров лучше выносить в helper для того, если нужно хранить и менять праметры для одного компонента на разных страницах
 * \Exception\CatalogHelper::getArrParams() методо должен возващать массив параметров.
 */

$APPLICATION->IncludeComponent(
    'bitrix:catalog',
    'catalog',
    [
        'IBLOCK_TYPE'   => Product::getInfoBlockType(),
        'IBLOCK_ID'     => Product::getInfoBlockId(),
        'SEF_URL_TEMPLATES' => [
            'index'     => CATALOG_ROOT . '/',
            'personal_recommendation' => CATALOG_ROOT . '/personal/',
            'section'   => CATALOG_ROOT . '/#SECTION_CODE_PATH#/',
            'element'   => 'product/#ELEMENT_CODE#/',
            'search'    => CATALOG_ROOT . '/search/',
            'smart_filter'   => CATALOG_ROOT . '/#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/',
        ],
    ] +
    \Exception\CatalogHelper::getArrParams() // часть параметров лучше выносить в helper для того, если нужно хранить и менять праметры для одного компонента на разных страницах
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
