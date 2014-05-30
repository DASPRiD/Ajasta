<?php
namespace Ajasta\Core\Controller;

use Ajasta\Core\Service\OptionService;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class OptionController extends AbstractActionController
{
    /**
     * @var OptionService
     */
    protected $optionService;

    /**
     * @var FormInterface
     */
    protected $optionForm;

    /**
     * @param OptionService $optionService
     * @param FormInterface $optionForm
     */
    public function __construct(OptionService $optionService, FormInterface $optionForm)
    {
        $this->optionService  = $optionService;
        $this->optionForm     = $optionForm;
    }

    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->optionForm->setData($this->getRequest()->getPost());

            if ($this->optionForm->isValid()) {
                $this->optionService->storeOptions($this->clientForm->getData());
                $this->redirect()->toRoute('options');
            }
        } else {
            $this->optionForm->bindValues($this->optionService->getAllOptions());
        }

        return new ViewModel([
            'form' => $this->optionForm,
        ]);
    }
}
