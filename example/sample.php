<?php

error_reporting(1);
ini_set('display_errors', 'On');

include_once './../vendor/autoload.php';

class Date extends Dez\EventDispatcher\Event {

    protected $date;

    public function __construct( \DateTime $date ) {
        $this->date = $date;
    }

    public function printTime($event) {
        $event->stop();
        var_dump( $this->date->format( 'd.m.Y H:i:s' ) );
    }

}

class QueryLogger extends Dez\EventDispatcher\Event {

    protected $query = '';

    public function __construct( $q ) {
        $this->query    = $q;
    }

    public function getQuery() {
        return $this->query;
    }

}

$dispatcher     = new Dez\EventDispatcher\Dispatcher();

$dispatcher->addListener( 'onTest2', function($e, $name) {
    var_dump( $e, $name );
} );

$dispatcher->addListener( 'onTest', function( Dez\EventDispatcher\EventInterface $event, $eventName ) {
    var_dump( $eventName, $event, 'end now stopping...' );
    $event->stop();
}, 1000 );

$dispatcher->addListener( 'onTest', function( Dez\EventDispatcher\EventInterface $event, $eventName ) {
    var_dump( $eventName, $event );
}, 1 );

$dispatcher->addListener( 'onDbQuery', function( QueryLogger $event, $eventName, $dispatcher ) {
    var_dump( $eventName, $event->getQuery() );
    $dispatcher->dispatch( 'onTest2' );
} );

$dispatcher->addListener( 'onTest', [ new Date( new DateTime() ), 'printTime' ], 2 );

// dispatch
$dispatcher->getListeners('onTest');

$dispatcher->dispatch( 'onTest', new Date( new DateTime() ) );
$dispatcher->dispatch( 'onDbQuery', new QueryLogger( 'select * from table_name' ) );
