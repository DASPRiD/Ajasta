<?php
namespace Ajasta\Core\Pdf;

use RuntimeException;

class TranslationLoader
{
    /**
     * @var string
     */
    protected $translationPath;

    /**
     * @param string $translationPath
     */
    public function __construct($translationPath)
    {
        $this->translationPath = $translationPath;
    }

    /**
     * @param  string $locale
     * @return string[]
     */
    public function getMessages($locale)
    {
        $path = sprintf('%s/%s.php', $this->translationPath, $locale);

        if (!file_exists($path)) {
            return [];
        }

        $messages = include $path;

        if (!is_array($messages)) {
            throw new RuntimeException(sprintf(
                'Translation file %s did not return an array',
                $path
            ));
        }

        return $messages;
    }
}
