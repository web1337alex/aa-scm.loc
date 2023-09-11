<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки базы данных
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры базы данных: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'wpsc' );

/** Имя пользователя базы данных */
define( 'DB_USER', 'os_adm' );

/** Пароль к базе данных */
define( 'DB_PASSWORD', 'FxJ)S9.n/pu_fi@Y' );

/** Имя сервера базы данных */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '1_j+/k_k^q?ned=Azjl75<o&kRH=9qDxoWxtp3M1S:A,j<c!$bXCWOV:Z05OCZgJ' );
define( 'SECURE_AUTH_KEY',  'lzKWECAH9Hs#9}Myknng1<|TU@xa9f)(VUI967?l+eE8[HTa*e#mQ 6hORAYzCzp' );
define( 'LOGGED_IN_KEY',    '#A.3:{]X+0nDSPV-V?-KVUQ7vmb>Z]U1Z<O2WO+nf|Q,`*PdM@P|B8]!,3GZJi&/' );
define( 'NONCE_KEY',        'mU(qjXDO1vZiArF!ze$ocaH(c@mVv&;;Fi].AoBP1De0Y&rY.=|{@]hTTZlrT!Vl' );
define( 'AUTH_SALT',        'qdq3cE}0hIz32r,`[g1[{fF?G#96MoOTc&.[~k:HtAqgi%-|kWJ#qEd5zVt[:H`4' );
define( 'SECURE_AUTH_SALT', '0,@Xg`rTH.AgYsad<R.(JK<. bf_/lz|V8adQ%%sLGBNv! ?.SH3.f$> NoItg%P' );
define( 'LOGGED_IN_SALT',   '_w^w_2mlS_LREb!yA(C^.8p&P>`MbS(WE$m]TFW 6gCT%`-OL4co>Q@aq>u|D(n0' );
define( 'NONCE_SALT',       'Eq6 Y0)e9<N|WVr?cKR`vgS$M&T tm*[<_biOtx~loSG@SkiopqWE 8 {%r}PqRO' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_sc_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
