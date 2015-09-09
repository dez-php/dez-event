<?php

    namespace Dez\EventDispatcher;

    /**
     * Interface EventInterface
     * @package Dez\EventDispatcher
     */
    interface EventInterface {

        /**
         * @return mixed
         */
        public function isStoped();

        /**
         * @return mixed
         */
        public function stop();

    }