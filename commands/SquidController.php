<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use dektrium\user\models\User;
use dektrium\user\helpers\Password;
use yii\helpers\Console;
use app\helpers\Squid;
use app\helpers\SquidGuard;

class SquidController extends Controller {

	public function actionStart()
	{
		if(!Squid::status())
        {
            $status = Squid::writeconfig();

            if(!$status)
            {
                $this->stdout('Unable to write to configuration file', Console::FG_RED); 
                exit();
            }
            
            $status = SquidGuard::writeconfig();
            
            if(!$status)
            {
            	$this->stdout('Unable to write to configuration file', Console::FG_RED);
            	exit();
            }
            
            $status = Squid::start();

            $this->stdout($status, Console::FG_GREEN); 
        }
        else
            $this->stdout('Squid Proxy is already running', Console::FG_RED);
	}

	public function actionStop()
    {
        if(Squid::status())
        {
            $status = Squid::stop();

            $this->stdout($status, Console::FG_GREEN); 
        }
        else
            $this->stdout('Squid Proxy is not running', Console::FG_RED);
    }

}