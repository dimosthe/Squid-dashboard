<?php

use yii\db\Schema;
use yii\db\Migration;

class m150930_122838_add_ads_domains_to_blacklist extends Migration
{
    public function safeUp()
    {
        $this->insert('blacklist', array('id'=>'', 'name'=>'ads', 'comments'=>''));

        $handle = fopen("/etc/squidguard/blacklists/ads/domains", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $this->insert('blacklist_domains', array('id'=>'', 'domain'=>$line, 'blacklist_id'=>'11'));
            }
            fclose($handle);
        }
    }

    public function down()
    {
        echo "m150930_122838_add_ads_domains_to_blacklist cannot be reverted.\n";

        return false;
    }
}
