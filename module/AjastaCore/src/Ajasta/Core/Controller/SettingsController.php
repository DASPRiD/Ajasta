<?php
namespace Ajasta\Core\Controller;

use Ajasta\Core\Service\SettingsService;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SettingsController extends AbstractActionController
{
    /**
     * @var SettingsService
     */
    protected $settingsService;

    /**
     * @var FormInterface
     */
    protected $settingsForm;

    /**
     * @param SettingsService $settingsService
     * @param FormInterface   $settingsForm
     */
    public function __construct(SettingsService $settingsService, FormInterface $settingsForm)
    {
        $this->settingsService  = $settingsService;
        $this->settingsForm     = $settingsForm;
    }

    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->settingsForm->setData($this->getRequest()->getPost());

            if ($this->settingsForm->isValid()) {
                $this->settingsService->persistSettingsFromFrom($this->settingsForm->getData());
                $this->redirect()->toRoute('settings');
            }
        } else {
            $this->settingsForm->populateValues($this->settingsService->getSettingsForForm());
        }

        return new ViewModel([
            'form' => $this->settingsForm,
        ]);
    }
}
