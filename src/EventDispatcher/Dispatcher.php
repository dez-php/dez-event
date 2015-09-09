<?php

    namespace Dez\EventDispatcher;

    /**
     * Class Dispatcher
     * @package Dez\EventDispatcher
     */
    class Dispatcher implements DispatcherInterface {


        /**
         * @var array
         */
        protected $listeners    = [];

        /**
         * @var array
         */
        protected $sorted       = [];


        /**
         * @param $eventName
         * @param EventInterface|null $event
         * @return Event
         * @throws Exception
         */
        public function dispatch( $eventName, EventInterface $event = null ) {

            if( $this->hasListeners( $eventName ) ) {
                if( $event === null )
                    $event  = new Event();

                foreach( $this->getListeners( $eventName ) as $listener ) {
                    if( is_callable( $listener ) ) {

                        call_user_func_array( $listener, [ $event, $eventName, $this ] );

                        if( $event->isStoped() ) {
                            break;
                        }

                    } else {
                        throw new Exception( 'Listener is not callable' );
                    }
                }
            }

            return $event;

        }


        /**
         * @param $eventName
         * @return mixed
         */
        public function getListeners( $eventName ) {
            $this->sortListeners( $eventName );
            return $this->sorted[ $eventName ];
        }

        /**
         * @param $eventName
         * @param $listener
         * @param $position
         * @return $this
         */
        public function addListener( $eventName, $listener, $position = 0 ) {
            $this->listeners[ $eventName ][ $position ][]
                = $listener;
            $this->sorted[$eventName]   = [];
            return $this;
        }

        /**
         * @param $eventName
         * @return $this
         */
        public function removeListener( $eventName ) {
            if( $this->hasListeners( $eventName ) )
                unset( $this->sorted[$eventName], $this->listeners[$eventName] );
            return $this;
        }

        /**
         * @param $eventName
         * @return bool
         */
        public function hasListeners( $eventName ) {
            return isset( $this->listeners[ $eventName ] );
        }

        /**
         * @param $eventName
         * @return $this
         */
        public function sortListeners( $eventName ) {
            if( $this->hasListeners( $eventName ) ) {
                $this->sorted[ $eventName ]     = [];
                $listeners  = $this->listeners[ $eventName ];
                ksort( $listeners );
                $this->sorted[ $eventName ]     = call_user_func_array( 'array_merge', $listeners );
            }
            return $this;
        }

    }