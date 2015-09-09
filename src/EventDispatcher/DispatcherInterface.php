<?php

    namespace Dez\EventDispatcher;

    /**
     * Interface DispatcherInterface
     * @package Dez\EventDispatcher
     */
    interface DispatcherInterface {


        /**
         * @param $eventName
         * @param EventInterface|null $event
         * @return mixed
         */
        public function dispatch( $eventName, EventInterface $event = null );

        /**
         * @param $eventName
         * @param $listener
         * @return mixed
         */
        public function addListener( $eventName, $listener );

        /**
         * @param $eventName
         * @return mixed
         */
        public function removeListener( $eventName );

        /**
         * @param $eventName
         * @return mixed
         */
        public function hasListeners( $eventName );

        /**
         * @param $eventName
         * @return mixed
         */
        public function getListeners( $eventName );

        /**
         * @param $eventName
         * @return mixed
         */
        public function sortListeners( $eventName );

    }