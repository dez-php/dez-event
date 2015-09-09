<?php

    namespace Dez\EventDispatcher;

    /**
     * Class Event
     * @package Dez\EventDispatcher
     */
    class Event implements EventInterface {

        /**
         * @var bool
         */
        protected $stopped    = false;

        /**
         * @return bool
         */
        public function isStoped() {
            return $this->stopped;
        }

        /**
         *
         */
        public function stop() {
            $this->stopped   = true;
        }

    }