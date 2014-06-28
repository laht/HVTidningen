<?php
/**
 * Baskonfiguration f�r WordPress.
 *
 * Denna fil inneh�ller f�ljande konfigurationer: Inst�llningar f�r MySQL,
 * Tabellprefix, S�kerhetsnycklar, WordPress-spr�k, och ABSPATH.
 * Mer information p� {@link http://codex.wordpress.org/Editing_wp-config.php 
 * Editing wp-config.php}. MySQL-uppgifter f�r du fr�n ditt webbhotell.
 *
 * Denna fil anv�nds av wp-config.php-genereringsskript under installationen.
 * Du beh�ver inte anv�nda webbplatsen, du kan kopiera denna fil direkt till
 * "wp-config.php" och fylla i v�rdena.
 *
 * @package WordPress
 */

// ** MySQL-inst�llningar - MySQL-uppgifter f�r du fr�n ditt webbhotell ** //
/** Namnet p� databasen du vill anv�nda f�r WordPress */
define('DB_NAME', 'thv');

/** MySQL-databasens anv�ndarnamn */
define('DB_USER', 'thv');

/** MySQL-databasens l�senord */
define('DB_PASSWORD', 'D1w3zosA');

/** MySQL-server */
define('DB_HOST', 'localhost');

/** Teckenkodning f�r tabellerna i databasen. */
define('DB_CHARSET', 'utf8');

/** Kollationeringstyp f�r databasen. �ndra inte om du �r os�ker. */
define('DB_COLLATE', '');

/**#@+
 * Unika autentiseringsnycklar och salter.
 *
 * �ndra dessa till unika fraser!
 * Du kan generera nycklar med {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Du kan n�r som helst �ndra dessa nycklar f�r att g�ra aktiva cookies obrukbara, vilket tvingar alla anv�ndare att logga in p� nytt.
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
 * Tabellprefix f�r WordPress Databasen.
 *
 * Du kan ha flera installationer i samma databas om du ger varje installation ett unikt
 * prefix. Endast siffror, bokst�ver och understreck!
 */
$table_prefix  = 'wp_';

/**
 * WordPress-spr�k, f�rinst�llt f�r svenska.
 *
 * Du kan �ndra detta f�r att �ndra spr�k f�r WordPress.  En motsvarande .mo-fil
 * f�r det valda spr�ket m�ste finnas i wp-content/languages. Exempel, l�gg till
 * sv_SE.mo i wp-content/languages och ange WPLANG till 'sv_SE' f�r att f� sidan
 * p� svenska.
 */
define('WPLANG', 'sv_SE');

/** 
 * F�r utvecklare: WordPress fels�kningsl�ge. 
 * 
 * �ndra detta till true f�r att aktivera meddelanden under utveckling. 
 * Det �r rekommderat att man som till�ggsskapare och temaskapare anv�nder WP_DEBUG 
 * i sin utvecklingsmilj�. 
 */ 
define('WP_DEBUG', true);

/* Det var allt, sluta redigera h�r! Blogga p�. */

/** Absoluta s�kv�g till WordPress-katalogen. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Anger WordPress-v�rden och inkluderade filer. */
require_once(ABSPATH . 'wp-settings.php');