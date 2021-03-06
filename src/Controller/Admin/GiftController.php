<?php
namespace App\Controller\Admin;

use Wpadmin\Controller\AppController;

/**
 * Cost Controller
 *
 * @property \App\Model\Table\CostTable $Gift
 */
class GiftController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set([
            'gifts' => $this->Gift,
            'pageTitle' => '礼物设置 ',
            'bread' => [
                'first' => ['name' => '基础管理'],
                'second' => ['name' => '礼物设置'],
            ],
        ]);
    }

    /**
     * View method
     *
     * @param string|null $id Cost id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->autoLayout(false);
        $cost = $this->Cost->get($id, [
            'contain' => []
        ]);
        $this->set('cost', $cost);
        $this->set('_serialize', ['cost']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $gift = $this->Gift->newEntity();
        if ($this->request->is('post')) {
            $gift = $this->Gift->patchEntity($gift, $this->request->data);
            if ($this->Gift->save($gift)) {
                $this->Util->ajaxReturn(true, '添加成功');
            } else {
                $errors = $gift->errors();
                $this->Util->ajaxReturn(['status' => false, 'msg' => getMessage($errors), 'errors' => $errors]);
            }
        }
        $this->set(compact('gift'));

    }

    /**
     * Edit method
     *
     * @param string|null $id Cost id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $gift = $this->Gift->get($id);
        if ($this->request->is(['post', 'put'])) {
            $gift = $this->Gift->patchEntity($gift, $this->request->data);
            if ($this->Gift->save($gift)) {
                $this->Util->ajaxReturn(true, '修改成功');
            } else {
                $errors = $gift->errors();
                $this->Util->ajaxReturn(false, getMessage($errors));
            }
        }
        $this->set(compact('gift'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cost id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod('post');
        $id = $this->request->data('id');
        if ($this->request->is('post')) {
            $gift = $this->Gift->get($id);
            if ($this->Gift->delete($gift)) {
                $this->Util->ajaxReturn(true, '删除成功');
            } else {
                $errors = $gift->errors();
                $this->Util->ajaxReturn(true, getMessage($errors));
            }
        }
    }

    /**
     * get jqgrid data
     *
     * @return json
     */
    public function getDataList()
    {
        $this->request->allowMethod('ajax');
        $page = $this->request->data('page');
        $rows = $this->request->data('rows');
        $sort = 'Gift.' . $this->request->data('sidx');
        $order = $this->request->data('sord');
        $keywords = $this->request->data('keywords');
        $where = [];
        if (!empty($keywords)) {
            $where[' name like'] = "%$keywords%";
        }
        $data = $this->getJsonForJqrid($page, $rows, '', $sort, $order, $where);
        foreach ($data as &$item) {
            $item['pic'] = generateImgUrl($item['pic']);
        }
        $this->autoRender = false;
        $this->response->type('json');
        $this->response->body(json_encode($data));
        $this->response->send();
        $this->response->stop();
    }

}
