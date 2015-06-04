<?php

namespace tigokr\imageplaceholder;

/**
 * This is just an example.
 */
class Bootstrap implements  \yii\base\BootstrapInterface {

    public $id = 'placeholder';

    public function bootstrap($app) {
        if ($app instanceof \yii\web\Application) {
            $app->controllerMap[$this->id] = '\tigokr\imageplaceholder\PlaceholderController';

            $app->getUrlManager()->addRules([
                $this->id => $this->id . '/index',
                $this->id.'/<size:\d+(x\d+)?>' => $this->id . '/index',
            ], false);
        }
    }
}
