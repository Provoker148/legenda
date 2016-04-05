<?php
// Related Options / Связанные опции
// Support: support@liveopencart.com / Поддержка: help@liveopencart.ru

// Heading
$_['heading_title']         = 'Связанные опции';
$_['related_options']       = 'Связанные опции'; 

// Text
$_['text_module']           = 'Модули';
$_['text_success']          = 'Настройки обновлены!';
$_['text_content_top']      = 'Верх страницы';
$_['text_content_bottom']   = 'Низ страницы';
$_['text_column_left']      = 'Левая колонка';
$_['text_column_right']     = 'Правая колонка';
$_['text_ro_updated_to']    = 'Модуль обновлен до версии ';
$_['text_ro_all_options']   = 'Все доступные опции';
$_['text_ro_support']       = "Разработка: <a href='http://19th19th.ru' target='_blank'>19th19th.ru</a> | Поддержка, вопросы и предложения: <a href=\"mailto:opencart@19th19th.ru\">opencart@19th19th.ru</a>";
$_['text_ro_clear_options'] = 'Очистить параметры';



// Entry
$_['entry_settings']                  = 'Настройки модуля';
$_['entry_additional']                = 'Дополнительные поля';

$_['entry_PHPExcel_not_found']        = 'Не установлена библиотека PHPExcel. Не найден файл: ';
$_['entry_export']                    = 'Экспорт';
$_['entry_export_description']        = 'Данные выгружаются в формате XLS.<br>В первой строке таблицы содержатся заголовки, в последующих строках данные';
$_['entry_export_get_file']           = 'Получить файл';
$_['entry_export_fields']             = 'Выгружаемые данные:';
$_['entry_import']                    = 'Импорт';
$_['entry_import_description']        = 'Формат файла: XLS. Данные берутся с первого листа.
<br>В первой строке таблицы должны быть заголовки вида: product_id, relatedoptions_model, quantity, price, option_id1, option_value_id1, option_id2, option_value_id2, ... (не путать с product_option_id и product_option_value_id)
<br>Начиная со второй строки таблицы должны быть данные соответствующие заголовкам.<br><br>
При совпадении импортируемых сочетаний связанных опций товаров с существующими, существующие сочетания будут заменены.';

$_['entry_import_delete_before']      = 'Удалить все связанные опции перед загрузкой';
$_['button_upload']		                = 'Загрузить файл';
$_['button_upload_help']              = 'загрузка начнется сразу после выбора файла';
$_['entry_server_response']           = 'Ответ сервера';
$_['entry_import_result']             = 'Обработано товаров/связанных опций';

$_['entry_update_quantity']           = 'Пересчитывать количество';
$_['entry_update_quantity_help']      = 'автоматически пересчитываеть количество товара на основании данных по связанным опциям';
$_['entry_stock_control']             = 'Контролировать остаток';
$_['entry_stock_control_help']        = 'запретить добавлять в корзину товар в количестве превышающем остаток по связанным опциям';
$_['entry_show_stock']                = 'Показывать остаток опций';
$_['entry_show_stock_help']           = 'показывать покупателям текущий остаток по связанным опциям';
$_['entry_update_options']            = 'Обновлять опции';
$_['entry_update_options_help']    	  = 'автоматически обновлять опции товара на основании данных по связанным опциям';
$_['entry_subtract_stock']            = 'Вычитать остаток опций';
$_['entry_subtract_stock_help']    	  = 'включить для обновляемых опций настройку вычитания остатка';
$_['text_subtract_stock_from_product']            = 'Взять из параметров товара';
$_['text_subtract_stock_from_product_first_time'] = 'Взять из параметров товара (только при добавлении опции)';
$_['entry_options_values']            = 'Значения опций';
$_['entry_add_related_options']       = 'Добавить связанные опции';
$_['entry_related_options_quantity']  = 'Количество';
$_['entry_ro_version']                = 'Связанные опции, версия';

$_['entry_ro_use_variants']           = 'Использовать различные варианты связанных опций';
$_['entry_ro_variant']                = 'Вариант связанных опций';
$_['entry_ro_variant_name']           = 'Название варианта';
$_['entry_ro_options']                = 'Опции варианта';
$_['entry_ro_add_variant']            = 'Добавить вариант';
$_['entry_ro_delete_variant']         = 'Удалить вариант';
$_['entry_ro_add_option']             = 'Добавить опцию';
$_['entry_ro_delete_option']          = 'Удалить опцию';
$_['entry_ro_use']                    = 'Использовать связанные опции';
$_['entry_show_clear_options']        = 'Показать "Очистить параметры"';
$_['entry_show_clear_options_help']   = 'отображать у покупателя кнопку для сброса выбранных значений опций товара';
$_['option_show_clear_options_not']   = 'не использовать';
$_['option_show_clear_options_top']   = 'выше опций';
$_['option_show_clear_options_bot']   = 'ниже опций';
$_['entry_hide_inaccessible']         = 'Скрывать недоступные значения';
$_['entry_hide_inaccessible_help']    = 'скрывать от покупателя недоступные для выбора значения опций';
$_['entry_spec_model']                = 'Модель';
$_['entry_spec_model_help']           = 'указывать разные модели для сочетаний связанных опций (указанные модели будут отображаться в корзине и сохраняться в заказе)';
$_['entry_spec_sku']                  = 'SKU';
$_['entry_spec_sku_help']             = 'указывать разные SKU для сочетаний связанных опций (указанные SKU будут сохраняться в заказах)';
$_['entry_spec_upc']                  = 'UPC';
$_['entry_spec_upc_help']             = 'указывать разные значения UPC для сочетаний связанных опций (указанные значения будут сохраняться в заказах)';
$_['entry_spec_location']             = 'Расположение';
$_['entry_spec_location_help']        = 'указывать разные расположения для сочетаний связанных опций (указанные расположения будут сохраняться в заказах)';
$_['entry_spec_price']                = 'Цена';
$_['entry_spec_price_help']           = 'указывать разные цены для сочетаний связанных опций, если цена для набора связанных опций не заполнена - используется обычная цена товара';
$_['entry_spec_weight']               = 'Вес';
$_['entry_spec_weight_help']          = 'указывать разные веса для сочетаний связанных опций (будет использоваться при расчете весов товаров в заказах)';
$_['entry_spec_price_discount']       = 'Скидки';
$_['entry_spec_price_discount_help']  = 'указывать разные скидки для сочетаний связанных опций (работает только вместе c включенной функцией "'.$_['entry_spec_price'].'"), если скидки для набора связанных опций не заполнены - используются обычные скидки товара';
$_['entry_add_discount']              = 'Добавить скидку';
$_['entry_del_discount_title']        = 'Удалить скидку';
$_['entry_spec_price_special']        = 'Акции';
$_['entry_spec_price_special_help']   = 'указывать разные акции для сочетаний связанных опций (работает только вместе c включенной функцией "'.$_['entry_spec_price'].'"), если акции для набора связанных опций не заполнены - используются обычные акции товара';
$_['entry_add_special']               = 'Добавить акцию';
$_['entry_del_special_title']         = 'Удалить акцию';
$_['entry_prices']                    = 'Цены';
$_['entry_select_first_short']        = 'Автовыбор';
$_['entry_select_first_priority']     = 'Приоритет';
$_['entry_select_first']              = 'Автовыбор сочетания';
$_['entry_select_first_help']         = 'автоматический выбор значений опций на странице товара';
$_['option_select_first_not']         = 'не использовать';
$_['option_select_first']             = 'первое доступное';
$_['option_select_first_last']        = 'последнее оставшееся';
$_['entry_step_by_step']              = 'Пошаговый выбор опций';
$_['entry_step_by_step_help']         = 'покупатель сначала выбирает значение первой опции, потом второй, затем третьей и т.д. (в любой момент покупатель может начать выбор сначала, или перевыбрать значение одной из выбранных опций - неподходящие значения последующих опций будут сброшены)';
$_['entry_allow_zero_select']         = 'Выбор сочетаний без остатка';
$_['entry_allow_zero_select_help']    = 'позволить покупателю выбирать сочетания опций с нулевым остатком';
$_['entry_edit_columns']              = 'Редактирование опций';
$_['entry_edit_columns_0']            = '1 колонка';
$_['entry_edit_columns_2']            = '2 колонки';
$_['entry_edit_columns_3']            = '3 колонки';
$_['entry_edit_columns_4']            = '4 колонки';
$_['entry_edit_columns_5']            = '5 колонок';
$_['entry_edit_columns_100']          = 'по ширине';
$_['entry_edit_columns_help']         = 'расположение полей выбора опций при редактировании связанных опций';
$_['entry_add_all_variants']          = 'Добавить все возможные комбинации опций';
$_['entry_add_product_variants']      = 'Добавить все комбинации опций товара';
$_['entry_remove_product_combs']      = 'Удалить все комбинации опций товара';
$_['entry_ro_description']            = 'Описание';
$_['ro_description_not']              = 'не использовать';
$_['ro_description_yes']              = 'не показывать покупателям';
$_['ro_description_replace']          = 'показывать под опциями';
$_['ro_description_add']              = 'заменять описание товара';
$_['entry_ro_description_help']       = 'указывать разные описания для разных сочетаний связанных опций';
$_['entry_ro_description_edit']       = 'изм';
$_['entry_about']                     = 'О модуле';
$_['entry_about_description']         = '
Модуль <a href="http://liveopencart.ru/opencart-moduli-shablony/moduli/prochee/svyazannyie-optsii" target="_blank" title="Связанные опции для OpenCart/ocStore">Связанные опции</a>
позволяет создавать для товаров комбинации связанных опций и указывать для каждой комбинации отдельный остаток, цену, модель и другие данные.
Это может быть полезно для товаров, имеющих взаимозависимые характеристики (опции), например цвет и размер у одежды.<br>
Для работы модуля требуется <a href="http://liveopencart.ru/news_site/chto-takoe-vqmod/" target="_blank" title="Что такое vQmod?">vQmod версии 2.4.1 или выше</a>.<br><br>

Если Вам нужна функция динамического обновления цены на странице товара в зависимости от выбранных опций (комбинации связанных опций)
- настоятельно рекомендуем использовать наш модуль <a href="http://liveopencart.ru/opencart-moduli-shablony/moduli/tsenyi/jivaya-tsena-dinamicheskoe-obnovlenie-tsenyi" target="_blank" title="Динамическое обновление цены для OpenCart/ocStore">Динамическое обновление цены - Живая цена</a>.
<br>Он полностью совместимо со всеми функциями цен модуля "'.$_['heading_title'].'". <br><br><br>
Есть вопросы по работе модуля? Требуется интеграция с шаблоном или доработка? Пишите: <b>opencart@19th19th.ru</b>.
<br><br><br>
Также рекомендуем:
<ul>
<li>
<a href="http://liveopencart.ru/opencart-moduli-shablony/moduli/vneshniy-vid/izobrajeniya-optsiy-pro" title="Изображения опций PRO для OpenCart/ocStore" target="_blank">
Изображения опций PRO</a> - модуль позволяющий привязывать изображения к опциям товара (одно или несколько изображений для каждой опции) и динамически менять видимые изображения на странице товара в зависимости от выбранной покупателем опции.
</li>

</ul>
';

$_['module_copyright'] = 'Модуль "'.$_['heading_title'].'" это коммерческое дополнение. Не выкладывайте его на сайтах для скачивания и не передавайте его копии другим лицам.<br>
Приобретая модуль, Вы приобретаете право его использования на одном сайте. <br>Если Вы хотите использовать модуль на нескольких сайтах, следует приобрести отдельную копию модуля для каждого сайта.<br>';


//warning
$_['warning_equal_options']    = 'совпадающий набор опций';

// Error
$_['error_equal_options']         = 'не должно быть совпадающих наборов связанных опций';
$_['error_not_enough_options']    = 'В наборе опций заданы не все опции';
$_['error_permission']            = 'У Вас нет прав для доступа к модулю!';
?>