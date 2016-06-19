<?php

/**
 * Interface MessageRepository
 */
interface MessageRepository {
    /**
     * @param Message $m
     * @return
     */
    function publish($m);

    /**
     * @return Message[]
     */
    function subscribe();

    /**
     * @param Message $m
     * @return
     */
    function unsubscribe($m);
}
