<?php 

namespace Reactor\Events;

/**
 * Class DispatcherQueued
 * @package Reactor\Events
 */
class DispatcherQueued extends Dispatcher {
	/**
	 * queue for events
	 * @var array
     */
	protected $events = array();

	/**
	 * @param Event $event
	 * @return $this
     */
	public function dispatch(Event $event) {
		$this->storeEvent($event);
		return $this;
	}

	/**
	 * use queue for get all event and notify all listeners
     */
	public function process() {
		while ( $event = $this->loadEvent() ) {
			parent::dispatch($event);
		}
	}

	/**
	 * @return Event
     */
	protected function loadEvent() {
		return array_shift($this->events);
	}

	/**
	 * @param Event $event
     */
	protected function storeEvent(Event $event) {
		$this->events[] = $event;
	}

}
