<?php 
namespace Src\Module\Auth;

class Login
{
    protected $table = DEF_TBL_USR_USERS;
    protected $cdate;
    protected $action;
    protected $email;
    protected $arPostData = [];
    protected $data = [];
    public $dataJson = [];

    public function __construct($arParams=[])
    {
        $this->action = $arParams['action'];
        $this->arPostData = $arParams['postData'];
        $this->cdate = getCurrentDate();
    }

    public function doInvokeAction()
    {
        print_r($this->arPostData); exit;
    }
}