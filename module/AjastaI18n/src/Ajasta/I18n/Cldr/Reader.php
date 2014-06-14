<?php
namespace Ajasta\I18n\Cldr;

use RuntimeException;

class Reader
{
    /**
     * @var string
     */
    protected $ldmlPath;

    /**
     * @var array
     */
    protected $ldml = [];

    /**
     * @param string $ldmlPath
     */
    public function __construct($ldmlPath)
    {
        $this->ldmlPath = rtrim($ldmlPath, '/');
    }

    /**
     * Reads data from LDML files.
     *
     * @param  string      $locale
     * @param  string      $path
     * @param  string|null $attribute
     * @param  string|null $value
     * @param  array       $temp
     * @return array
     */
    public function getPathData($locale, $path, $attribute = null, $value = null, $temp = [])
    {
        $locale = strtr($locale, '-', '_');
        $result = $this->findRoute($locale, $path, $attribute, $value, $temp);

        if ($result) {
            $temp = $this->readFile($locale, $path, $attribute, $value, $temp);
        }

        if ($locale !== 'root' && $result) {
            $locale = substr($locale, 0, strrpos($locale, '_'));

            if (empty($locale)) {
                $locale = 'root';
            }

            $temp = $this->getPathData($locale, $path, $attribute, $value, $temp);
        }

        return $temp;
    }

    /**
     * Reads content from locale.
     *
     * @param  string      $locale
     * @param  string      $path
     * @param  string|null $attribute
     * @param  string|null $value
     * @param  array       $temp
     * @return array
     */
    protected function readFile($locale, $path, $attribute, $value, $temp)
    {
        if (!isset($this->ldml[$locale])) {
            return $temp;
        }

        $result = $this->ldml[$locale]->xpath($path);

        if (empty($result)) {
            return $temp;
        }

        foreach ($result as $found) {
            if (!$value) {
                if (!$attribute) {
                    $temp[] = (string) $found;
                    continue;
                }

                $key = (string) $found[$attribute];

                if (empty($temp[$key])) {
                    $temp[$key] = (string) $found;
                }

                continue;
            }

            if (empty($temp[$value])) {
                if ($attribute) {
                    $temp[$value] = (string) $found[$attribute];
                    continue;
                }

                $temp[$value] = (string) $found;
            }
        }

        return $temp;
    }

    /**
     * Finds possible routing to other path or locale.
     *
     * @param  string      $locale
     * @param  string      $path
     * @param  string|null $attribute
     * @param  string|null $value
     * @param  array       $temp
     * @return bool
     */
    protected function findRoute($locale, $path, $attribute, $value, &$temp)
    {
        if (!isset($this->ldml[$locale])) {
            $filename = $this->ldmlPath . '/' . $locale  . '.xml';

            if (!file_exists($filename)) {
                throw new RuntimeException(sprintf('Unsupported locale "%s"', $locale));
            }

            $this->ldml[$locale] = simplexml_load_file($filename);
        }

        $search = '';
        $token  = strtok($path, '/');

        if (empty($this->ldml[$locale])) {
            return true;
        }

        while ($token !== false) {
            $search .= '/' . $token;

            if (strpos($search, '[@') !== false) {
                while (strrpos($search, '[@') > strrpos($search, ']')) {
                    $token = strtok('/');

                    if (!$token) {
                        $search .= '/';
                    }

                    $search .= '/' . $token;
                }
            }

            $result = $this->ldml[$locale]->xpath($search . '/alias');

            if (!empty($result)) {
                $source  = $result[0]['source'];
                $newPath = $result[0]['path'];

                if ($newPath !== '//ldml') {
                    while (substr($newPath, 0, 3) === '../') {
                        $newPath = substr($newPath, 3);
                        $search  = substr($search, 0, strrpos($search, '/'));
                    }

                    $path = $search . '/' . $newPath;

                    while (false !== ($token = strtok('/'))) {
                        $path .= '/' . $token;
                    }
                }

                if ($source !== 'locale') {
                    $locale = $source;
                }

                $temp = $this->getPathData($locale, $path, $attribute, $value, $temp);
                return false;
            }

            $token = strtok('/');
        }

        return true;
    }
}
