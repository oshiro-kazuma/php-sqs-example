<?php

/**
 * Interface SqsEventRepository
 */
interface SqsEventRepository {
    /**
     * @param DomainEvent $m
     * @return
     */
    function publish($m);

    /**
     * @return DomainEvent[]
     */
    function subscribe();

    /**
     * @param DomainEvent $m
     * @return
     */
    function unsubscribe($m);
}
