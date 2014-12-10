<?php

/*
 * This file is part of the VinceType bundle.
 *
 * (c) Vincent Chalamon <http://www.vincent-chalamon.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Listen to kernel.request event to save locale
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class LocaleListener
{

    /**
     * Locale
     *
     * @var string
     */
    protected $locale;

    /**
     * Log kernel.request event
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $this->locale = $event->getRequest()->getLocale();
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
}
