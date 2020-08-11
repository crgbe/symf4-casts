<?php


namespace App\Service;


use App\Helper\LoggerTrait;
use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Security\Core\Security;

class MarkdownHelper
{
    use LoggerTrait;

    private $cache;
    private $markdown;
    private $logger;
    private $isDebug;
    private $security;

    public function __construct(
        AdapterInterface $cache,
        MarkdownInterface $markdown,
        LoggerInterface $markdownLogger,
        bool $isDebug,
        Security $security
    )
    {
        $this->cache = $cache;
        $this->markdown = $markdown;
        $this->logger = $markdownLogger;
        $this->isDebug = $isDebug;
        $this->security = $security;
    }

    public function parse(string $source): string {

        if(stripos($source, 'bacon')){
            $this->logger->info("This article is talking about bacon !!!", [
                'user' => $this->security->getUser(),
            ]);
        }

        if($this->isDebug){
            return $this->markdown->transform($source);
        }

        $item = $this->cache->getItem('markdown_'.md5($source));

        if(!$item->isHit()){
            $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }

        return  $item->get();
    }

    public function sendMessage($message){
        $this->logInfo($message, [
            'message' => $message,
        ]);
    }
}