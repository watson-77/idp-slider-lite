<?php
if( ! defined('WP_UNINSTALL_PLUGIN') ) exit;

// проверка пройдена успешно. Начиная от сюда удаляем опции и все остальное.
delete_option('idp-slider-subpage');