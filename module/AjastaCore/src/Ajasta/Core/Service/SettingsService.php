<?php
namespace Ajasta\Core\Service;

use Ajasta\Core\Entity\Setting;
use Ajasta\Core\Entity\SettingType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use RuntimeException;

class SettingsService
{
    /**
     * @var array
     */
    protected $defaults;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $settingRepository;

    /**
     * @param array            $defaults
     * @param ObjectManager    $objectManager
     * @param ObjectRepository $settingRepository
     */
    public function __construct(array $defaults, ObjectManager $objectManager, ObjectRepository $settingRepository)
    {
        $this->defaults          = $defaults;
        $this->objectManager     = $objectManager;
        $this->settingRepository = $settingRepository;
    }

    /**
     * @param  string $path
     * @return Setting
     */
    public function findSetting($path)
    {
        return $this->settingRepository->find($path) ?: $this->getDefaultSetting($path);
    }

    /**
     * @param Setting $setting
     */
    public function persistSetting(Setting $setting)
    {
        $this->objectManager->persist($setting);
        $this->objectManager->flush();
    }

    /**
     * @return array
     */
    public function getSettingsForForm()
    {
        $settings = [];

        foreach ($this->getStructuredSettings() as $category => $values) {
            foreach ($values as $name => $setting) {
                if ($category === 'core') {
                    $settings[$name] = $setting->getValue();
                    continue;
                }

                if (!isset($settings[$category])) {
                    $settings[$category] = [];
                }

                $settings[$category][$name] = $setting->getValue();
            }
        }

        return ['settings' => $settings];
    }

    /**
     * @param array $settings
     */
    public function persistSettingsFromFrom(array $settings)
    {
        $structuredSettings = $this->getStructuredSettings();

        foreach ($structuredSettings as $category => $values) {
            foreach ($values as $name => $setting) {
                if ($category === 'core') {
                    if (isset($settings['settings'][$name])) {
                        $setting->setValue($settings['settings'][$name]);
                        $this->objectManager->persist($setting);
                    }

                    continue;
                }

                if (isset($settings['settings'][$category][$name])) {
                    $setting->setValue($settings['settings'][$category][$name]);
                    $this->objectManager->persist($setting);
                }
            }
        }

        $this->objectManager->flush();
    }

    /**
     * @return array
     */
    protected function getStructuredSettings()
    {
        $structuredSettings = [];

        foreach ($this->settingRepository->findAll() as $setting) {
            if (!isset($structuredSettings[$setting->getCategory()])) {
                $structuredSettings[$setting->getCategory()] = [];
            }

            $structuredSettings[$setting->getCategory()][$setting->getName()] = $setting;
        }

        foreach ($this->defaults as $category => $values) {
            if (!isset($structuredSettings[$category])) {
                $structuredSettings[$category] = [];
            }

            foreach ($values as $name => $default) {
                if (isset($structuredSettings[$category][$name])) {
                    continue;
                }

                $structuredSettings[$category][$name] = $this->getDefaultSetting($category, $name);
            }
        }

        return $structuredSettings;
    }

    /**
     * @param  string $category
     * @param  string $name
     * @return Setting
     * @throws RuntimeException
     */
    protected function getDefaultSetting($category, $name)
    {
        if (!isset($this->defaults[$category][$name])) {
            throw new RuntimeException(sprintf('Default for "%s/%s" not found', $category, $name));
        }

        $default = $this->defaults[$category][$name];

        if (!is_array($default)) {
            throw new RuntimeException(sprintf('Default for "%s/%s" is not an array', $category, $name));
        }

        if (!isset($default['type'])) {
            throw new RuntimeException(sprintf('Default for "%s/%s" has no type specified', $category, $name));
        }

        if (!isset($default['value'])) {
            throw new RuntimeException(sprintf('Default for "%s/%s" has no valuespecified', $category, $name));
        }

        return new Setting(SettingType::get($default['type']), $category, $name, $default['value']);
    }
}
