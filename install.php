<?php
require_once('Core/Core.php');

$Smarty->translate('Installation');
switch($_REQUEST['category'])
{
    case 'createconfig':
        $ConfigurationFile = '
            <?php
                global $FCCore;
                // Auth Database Settings
                $FCCore["AuthDB"]["host"]				=	"'.$_REQUEST['auth_host'].'";
                $FCCore["AuthDB"]["database"]			=	"'.$_REQUEST['auth_db'].'";
                $FCCore["AuthDB"]["username"]			=	"'.$_REQUEST['auth_user'].'";
                $FCCore["AuthDB"]["password"]			=	"'.$_REQUEST['auth_password'].'";
                $FCCore["AuthDB"]["encoding"]			=	"'.$_REQUEST['auth_encoding'].'";
                // Characters Database Settings
                $FCCore["CharDB"]["host"]				=	"'.$_REQUEST['characters_host'].'";
                $FCCore["CharDB"]["database"]			=	"'.$_REQUEST['characters_db'].'";
                $FCCore["CharDB"]["username"]			=	"'.$_REQUEST['characters_user'].'";
                $FCCore["CharDB"]["password"]			=	"'.$_REQUEST['characters_password'].'";
                $FCCore["CharDB"]["encoding"]			=	"'.$_REQUEST['characters_encoding'].'";
                // World Database Settings
                $FCCore["WorldDB"]["host"]				=	"'.$_REQUEST['world_host'].'";
                $FCCore["WorldDB"]["database"]			=	"'.$_REQUEST['world_db'].'";
                $FCCore["WorldDB"]["username"]			=	"'.$_REQUEST['world_user'].'";
                $FCCore["WorldDB"]["password"]			=	"'.$_REQUEST['world_password'].'";
                $FCCore["WorldDB"]["encoding"]			=	"'.$_REQUEST['world_encoding'].'";
                // Database Settings
                $FCCore["Database"]["host"]				=	"'.$_REQUEST['website_host'].'";
                $FCCore["Database"]["database"]			=	"'.$_REQUEST['website_db'].'";
                $FCCore["Database"]["username"]			=	"'.$_REQUEST['website_user'].'";
                $FCCore["Database"]["password"]			=	"'.$_REQUEST['website_password'].'";
                $FCCore["Database"]["encoding"]			=	"'.$_REQUEST['website_encoding'].'";
                // System Configuration
                //$FCCore["TimeZone"]					=	"Asia/Singapore"; // Singapore
                $FCCore["TimeZone"]						=	"Europe/Moscow"; //Moscow
                // Smarty Configuration
                $FCCore["SmartyCaching"]				=	false;
                $FCCore["SmartyDebug"]					=	false;
                // FreedomCore Configuration
                $FCCore["Caching"]						=	false;
                $FCCore["debug"]						=	true;
                $FCCore["email"]						=	"";	// Admin Email
                $FCCore["registration"]					=	false;
                // Template Engine Configuration
                $FCCore["ApplicationName"]				=	"FreedomCore";
                $FCCore["ApplicationDescription"]		=	"FreedomCore Test Engine";
                $FCCore["ApplicationKeywords"]			=	"FreedomHead";
                $FCCore["Template"]						=	"FreedomCore";
                $FCCore["ExpansionTemplate"]			=	"WoD"; // MoP - Mists of Pandaria, WoD - Warlords of Draenor, Cata - Cataclysm, WotLK - Wrath of the Lich King

                // Social Media Links
                $FCCore["Social"]["Facebook"]			=	"FreedomHead";
                $FCCore["Social"]["Twitter"]			=	"FreedomHead";
                $FCCore["Social"]["Vkontakte"]			=	"FreedomHead";
                $FCCore["Social"]["Skype"]				=	"FreedomHead";
                $FCCore["Social"]["Youtube"]			=	"FreedomHead";

                // Google Analytics
                $FCCore["GoogleAnalytics"]["Account"]	=	"";
                $FCCore["GoogleAnalytics"]["Domain"]	=	"";

                // Facebook Settings
                $FCCore["Facebook"]["admins"]			=	"";
                $FCCore["Facebook"]["pageid"]			=	"";
            ?>
        ';
        $ConfigFolder = getcwd().DS.'Core'.DS.'Configuration'.DS.'Configuration.php.undone';
        if(File::Exists($ConfigFolder))
        {
            unlink($ConfigFolder);
            file_put_contents($ConfigFolder, $ConfigurationFile);
        }
        else
        {
            file_put_contents($ConfigFolder, $ConfigurationFile);
        }
        echo '1';
    break;

    default:
        ob_start();
        phpinfo(INFO_MODULES);
        $info = ob_get_contents();
        ob_end_clean();
        $info = stristr($info, 'Client API version');
        preg_match('/[1-9].[0-9].[1-9][0-9]/', $info, $match);
        $MySQLVersion = $match[0];
        $ApacheVersion = str_replace(' ', '', str_replace('Apache/', '', strstr(apache_get_version(), '(', true)));
        $PHPVersion = strstr(phpversion(), '-', true);

        if(str_replace('.', '', $MySQLVersion) >= 5011)
            $MySQLCheck = true;
        else
            $MySQLCheck = false;

        if(substr(str_replace('.', '', $PHPVersion), 0, 2) >= 54)
            $PHPCheck = true;
        else
            $PHPCheck = false;

        if(substr(str_replace('.', '', $ApacheVersion), 0, 2) > 22)
            $ApacheCheck = true;
        elseif(substr(str_replace('.', '', $ApacheVersion), 0, 2) == 22)
            if(substr(str_replace('.', '', $ApacheVersion), 0, 4) >= 2214)
                $ApacheCheck = true;
            else
                $ApacheCheck = false;
        else
            $ApacheCheck = false;

        if($PHPCheck && $MySQLCheck && $ApacheCheck)
            $AllowInstallation = true;
        else
            $AllowInstallation = false;

        $InstalledSoftware = array(
            'php' => array(
                'version' => 'PHP '.$PHPVersion,
                'verified' => $PHPCheck
            ),
            'apache' => array(
                'version' => 'Apahce '.$ApacheVersion,
                'verified' => $ApacheCheck
            ),
            'mysql' => array(
                'version' => 'MySQL API '.$MySQLVersion,
                'verified' => $MySQLCheck
            ),
            'allow' => $AllowInstallation
        );

        //String::PrettyPrint(File::GetDirectoryContent(getcwd().DS.'sql'.DS.'base'));
        $Smarty->assign('Software', $InstalledSoftware);
        $Smarty->display('installation/main');
        break;
}

?>