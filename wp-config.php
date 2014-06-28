<?php
/**
 * Baskonfiguration för WordPress.
 *
 * Denna fil innehåller följande konfigurationer: Inställningar för MySQL,
 * Tabellprefix, Säkerhetsnycklar, WordPress-språk, och ABSPATH.
 * Mer information på {@link http://codex.wordpress.org/Editing_wp-config.php 
 * Editing wp-config.php}. MySQL-uppgifter får du från ditt webbhotell.
 *
 * Denna fil används av wp-config.php-genereringsskript under installationen.
 * Du behöver inte använda webbplatsen, du kan kopiera denna fil direkt till
 * "wp-config.php" och fylla i värdena.
 *
 * @package WordPress
 */

// ** MySQL-inställningar - MySQL-uppgifter får du från ditt webbhotell ** //
/** Namnet på databasen du vill använda för WordPress */
define('DB_NAME', 'thv');

/** MySQL-databasens användarnamn */
define('DB_USER', 'thv');

/** MySQL-databasens lösenord */
define('DB_PASSWORD', 'D1w3zosA');

/** MySQL-server */
define('DB_HOST', 'localhost');

/** Teckenkodning för tabellerna i databasen. */
define('DB_CHARSET', 'utf8');

/** Kollationeringstyp för databasen. Ändra inte om du är osäker. */
define('DB_COLLATE', '');

/**#@+
 * Unika autentiseringsnycklar och salter.
 *
 * Ändra dessa till unika fraser!
 * Du kan generera nycklar med {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Du kan när som helst ändra dessa nycklar för att göra aktiva cookies obrukbara, vilket tvingar alla användare att logga in på nytt.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '#z;GVAvDpJsAV*4@@[gd2(wrFg}VK%p$rR1]^BQ$=r>g6]_z^Yz*4){,2x<PCzl8');
define('SECURE_AUTH_KEY',  'Nm@BuR#k.2bik,2dN?ldIqoC>8M`jOq<{Mv+9F&3$p#[P_Um~DbkmhEX?X}mjD:I');
define('LOGGED_IN_KEY',    'yEg#%m5#HcD*>8&a?Lx| ]3[x2BMOci2W48l90JlSV,@<u_*@yZUMcOGccg&}q[#');
define('NONCE_KEY',        ')!cc5fG^q.S{J`_Wq!Eay_%7`r)p}!/&gXHC3VZ=?@BeO35T7{!,,Yon/B5)i3+L');
define('AUTH_SALT',        'KEHt71lhrDzbr*.^+qgPI]sYxz2>{C:l/oxTS+o~RQ,3|654fd)[M%A@Ma&E+PJ]');
define('SECURE_AUTH_SALT', 'n+c=$yjQbszq3#~XuO@@Fg03^. :01hu]-P=;DKB2P=*ON1nnREmm<+Ozm -<U;e');
define('LOGGED_IN_SALT',   'hBC*&/>$`Pzl&[uF+_WSHg!=8][S-K@%3]y_%}eqF`@kk8xO)Q147o])Y9gV3|!M');
define('NONCE_SALT',       '*2&|:nlw^s(.{4nxIqcx~P4f|p!QYD.~(Bt]OU(ARSi5O}Z1QTha#U|]-+udgalh');

/**#@-*/

/**
 * Tabellprefix för WordPress Databasen.
 *
 * Du kan ha flera installationer i samma databas om du ger varje installation ett unikt
 * prefix. Endast siffror, bokstäver och understreck!
 */
$table_prefix  = 'wp_';

/**
 * WordPress-språk, förinställt för svenska.
 *
 * Du kan ändra detta för att ändra språk för WordPress.  En motsvarande .mo-fil
 * för det valda språket måste finnas i wp-content/languages. Exempel, lägg till
 * sv_SE.mo i wp-content/languages och ange WPLANG till 'sv_SE' för att få sidan
 * på svenska.
 */
define('WPLANG', 'sv_SE');

/** 
 * För utvecklare: WordPress felsökningsläge. 
 * 
 * Ändra detta till true för att aktivera meddelanden under utveckling. 
 * Det är rekommderat att man som tilläggsskapare och temaskapare använder WP_DEBUG 
 * i sin utvecklingsmiljö. 
 */ 
define('WP_DEBUG', true);

/* Det var allt, sluta redigera här! Blogga på. */

/** Absoluta sökväg till WordPress-katalogen. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Anger WordPress-värden och inkluderade filer. */
require_once(ABSPATH . 'wp-settings.php');