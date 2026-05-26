<?php

namespace Apps\Tms\Components\Tools\Uom;

use Apps\Tms\Packages\Adminltetags\Traits\DynamicTable;
use Apps\Tms\Packages\Tools\Uom\ToolsUom;
use System\Base\BaseComponent;

class UomComponent extends BaseComponent
{
    use DynamicTable;

    protected $uomPackage;

    public function initialize()
    {
        $this->uomPackage = $this->usePackage(ToolsUom::class);
    }

    /**
     * @acl(name=view)
     */
    public function viewAction()
    {
        if (isset($this->getData()['id'])) {
            if ($this->getData()['id'] != 0) {
                $uom = $this->uomPackage->getById((int) $this->getData()['id']);

                if (!$uom) {
                    return $this->throwIdNotFound();
                }

                $this->view->uom = $uom;
            }

            $this->view->pick('uom/view');

            return;
        }

        $controlActions =
            [
                'actionsToEnable'       =>
                [
                    'edit'      => 'tools/uom'
                ]
            ];

        $this->generateDTContent(
            $this->uomPackage,
            'tools/uom/view',
            null,
            ['name'],
            true,
            ['name'],
            $controlActions,
            [],
            null,
            'name'
        );

        $this->view->pick('uom/list');
    }

    /**
     * @acl(name=add)
     */
    public function addAction()
    {
        $this->requestIsPost();

        $this->uomPackage->addUom($this->postData());

        $this->addResponse(
            $this->uomPackage->packagesData->responseMessage,
            $this->uomPackage->packagesData->responseCode
        );
    }

    /**
     * @acl(name=update)
     */
    public function updateAction()
    {
        $this->requestIsPost();

        $this->uomPackage->updateUom($this->postData());

        $this->addResponse(
            $this->uomPackage->packagesData->responseMessage,
            $this->uomPackage->packagesData->responseCode
        );
    }

    /**
     * @acl(name=remove)
     */
    public function removeAction()
    {
        $this->requestIsPost();

        $this->uomPackage->removeUom($this->postData());

        $this->addResponse(
            $this->uomPackage->packagesData->responseMessage,
            $this->uomPackage->packagesData->responseCode
        );
    }
}